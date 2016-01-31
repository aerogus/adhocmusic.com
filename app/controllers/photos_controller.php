<?php

define('NB_PHOTOS_PER_PAGE', 64);
define('PHOTOS_IMPORT_DIR', ADHOC_ROOT_PATH . '/import');
define('PHOTOS_EXTRACT_DIR', PHOTOS_IMPORT_DIR . '/tmp');

class Controller
{
    static function my()
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $trail = Trail::getInstance();
        $trail->addStep("Tableau de bord", "/membres/tableau-de-bord");
        $trail->addStep("Mes Photos");

        $smarty = new AdHocSmarty();

        $page = (int) Route::params('page');

        $smarty->assign('create', (bool) Route::params('create'));
        $smarty->assign('edit', (bool) Route::params('edit'));
        $smarty->assign('delete', (bool) Route::params('delete'));

        $photos = Photo::getPhotos(array(
            'contact' => $_SESSION['membre']->getId(),
            'limit'   => NB_PHOTOS_PER_PAGE,
            'debut'   => $page * NB_PHOTOS_PER_PAGE,
            'sort'    => 'id',
            'sens'    => 'ASC',
        ));
        $nb_photos = Photo::getMyPhotosCount();

        $smarty->assign('photos', $photos);

        $smarty->assign('nb_items', $nb_photos);
        $smarty->assign('nb_items_per_page', NB_PHOTOS_PER_PAGE);
        $smarty->assign('page', $page);

        return $smarty->fetch('photos/my.tpl');
    }

    static function show()
    {
        $id = (int) Route::params('id');
        $from = (string) Route::params('from');

        $smarty = new AdHocSmarty();
        $trail = Trail::getInstance();

        try {
            $photo = Photo::getInstance($id);
        } catch(Exception $e) {
            Route::set_http_code('404');
            $smarty->assign('unknown_photo', true);
            return $smarty->fetch('photos/show.tpl');
        }

        $meta_title = '';
        $meta_description = "Titre : " . $photo->getName();

        if($photo->getOnline() || (!$photo->getOnline() && Tools::isAuth() && Tools::auth(Membre::TYPE_INTERNE))) {

            $smarty->assign('photo', $photo);
            $smarty->assign('from', $from);
            $smarty->assign('og_image', $photo->getThumb130Url());
            $smarty->assign('has_credits', (bool) $photo->getCredits());

            $meta_title .= $photo->getName();

            if($photo->getIdGroupe()) {
                $groupe = Groupe::getInstance($photo->getIdGroupe());
                $smarty->assign('groupe', $groupe);
                $meta_title .= " - " . $groupe->getName();
                $meta_description .= " | Groupe : " . $groupe->getName();
            }
            if($photo->getIdEvent()) {
                $event = Event::getInstance($photo->getIdEvent());
                $smarty->assign('event', $event);
                $meta_title .= " - " . $event->getName() . " (" . Date::mysql_datetime($event->getDate(), "d/m/Y") . ")";
                $meta_description .= " | Evénement : " . $event->getName() . " (" . Date::mysql_datetime($event->getDate(), "d/m/Y") . ")";
            }
            if($photo->getIdLieu()) {
                $lieu = Lieu::getInstance($photo->getIdLieu());
                $smarty->assign('lieu', $lieu);
                $meta_title .= " - " . $lieu->getName();
                $meta_description .= " | Lieu : " . $lieu->getName() . " (" . $lieu->getIdDepartement() . " - " . $lieu->getCity() . ")";
            }
            if($photo->getIdContact()) {
                try {
                    $membre = Membre::getInstance($photo->getIdContact());
                    $smarty->assign('membre', $membre);
                } catch(Exception $e) {
                    mail('gus@adhocmusic.com', "[AD'HOC] Bug : photo avec membre introuvable", print_r($e, true));
                }
            }

            if($from == 'groupe' && $photo->getIdGroupe()) {
                $smarty->assign('menuselected', 'groupe');
                $trail->addStep("Groupes", "/groupes/");
                $trail->addStep($groupe->getName(), $groupe->getUrl());
            } elseif($from == 'profil' && $photo->getIdContact()) {
                $trail->addStep("Zone Membre", "/membres/");
            } elseif($from == 'event' && $photo->getIdEvent()) {
                $trail->addStep("Agenda", "/events/");
                $trail->addStep($event->getName(), $event->getUrl());
            } elseif($from == 'lieu' && $photo->getIdLieu()) {
                $trail->addStep("Lieux", "/lieux/");
                $trail->addStep($lieu->getName(), $lieu->getUrl());
            } else {
                $smarty->assign('menuselected', 'media');
                $trail->addStep("Média", "/media/");
            }
            $trail->addStep($photo->getName());

            $tabwho = array();
            foreach($photo->getTag() as $_who) {
                $mbr = Membre::getInstance($_who['id_contact']);
                $tabwho[] = '<a href="'.$mbr->getUrl().'"><strong>'.$mbr->getPseudo().'</strong></a>';
            }
            $who = implode(', ', $tabwho);
            $smarty->assign('who', $who, 'UTF8');

            // photo issu d'un album live ?
            if($photo->getIdEvent() && $photo->getIdLieu()) {
                $playlist = Photo::getPhotos(array(
                    'online' => true,
                    'event'  => $photo->getIdEvent(),
                    'lieu'   => $photo->getIdLieu(),
                    'sort'   => 'id',
                    'sens'   => 'ASC',
                    'limit'  => 200,
                ));

                // calcul photo suivante/précente
                $idx = 0;
                $count = count($playlist);
                foreach($playlist as $_idx => $_playlist) {
                    if($_playlist['id'] == $photo->getId()) {
                        $idx_photo = $_idx;
                        if($_idx < ($count - 1)) {
                            $next = $_idx + 1;
                        } else {
                            $next = 0;
                        }
                        if($_idx > 0) {
                            $prev = $_idx - 1;
                        } else {
                            $prev = $count - 1;
                        }
                    }
                }
                $smarty->assign('next', Photo::getUrlById($playlist[$next]['id']));
                $smarty->assign('prev', Photo::getUrlById($playlist[$prev]['id']));

                $smarty->assign('idx_photo', $idx_photo + 1);
                $smarty->assign('nb_photos', $count);
                $meta_title .= " - " . ($idx_photo + 1) . "/" . $count;
                $smarty->assign('playlist', $playlist);
            }

            $smarty->assign('title', $meta_title);
            $smarty->assign('description', $meta_description);

            $smarty->assign('comments', Comment::getComments(array(
                'type'       => 'p',
                'id_content' => $photo->getId(),
                'online'     => true,
                'sort'       => 'created_on',
                'sens'       => 'ASC',
            )));

        } else {

            // pas en ligne, pas les droits
            $smarty->assign('unknown_photo', true);

        }

        return $smarty->fetch('photos/show.tpl');
    }

    static function create()
    {
        Tools::auth(Membre::TYPE_STANDARD);

        if(Tools::isSubmit('form-photo-create'))
        {
            $data = array(
                'name' => trim((string) Route::params('name')),
                'credits' => trim((string) Route::params('credits')),
                'id_groupe' => (int) Route::params('id_groupe'),
                'id_lieu' => (int) Route::params('id_lieu'),
                'id_event' => (int) Route::params('id_event'),
                'id_contact' => (int) $_SESSION['membre']->getId(),
                'id_structure' => 0,
                'online' => (bool) Route::params('online'),
            );

            if(self::_validate_form_photo_create($data, $errors)) {

                $photo = Photo::init();
                $photo->setName($data['name']);
                $photo->setCredits($data['credits']);
                $photo->setIdGroupe($data['id_groupe']);
                $photo->setIdLieu($data['id_lieu']);
                $photo->setIdEvent($data['id_event']);
                $photo->setIdContact($data['id_contact']);
                $photo->setIdStructure($data['id_structure']);
                $photo->setOnline($data['online']);
                $photo->setCreatedNow();
                $photo->save();

                if(is_uploaded_file($_FILES['file']['tmp_name'])) {
                    $objImg = new Image($_FILES['file']['tmp_name']);
                    $objImg->setType(IMAGETYPE_JPEG);
                    $objImg->setMaxWidth(1024);
                    $objImg->setMaxHeight(768);
                    $objImg->setDestFile(Photo::getBasePath() . '/' . $photo->getId() . '.jpg');
                    $objImg->write();
                }

                Log::action(Log::ACTION_PHOTO_CREATE, $photo->getId());

                Tools::redirect('/medias/?create=1');

            } else {

                $errors['generic'] = true;

            }
        }

        $trail = Trail::getInstance();
        $trail->addStep("Tableau de bord", "/membres/tableau-de-bord");
        $trail->addStep("Mes Photos", "/photos/my");
        $trail->addStep("Ajouter une photo");

        $smarty = new AdHocSmarty();

        $smarty->enqueue_script('/js/photo-create.js');

        $id_groupe = (int) Route::params('id_groupe');
        if($id_groupe) {
            $groupe = Groupe::getInstance($id_groupe);
            $smarty->assign('groupe', $groupe);
        } else {
            $smarty->assign('groupes', Groupe::getGroupes(array(
                'sort'   => 'name',
                'sens'   => 'ASC',
            )));
        }

        $id_lieu = (int) Route::params('id_lieu');
        if($id_lieu) {
            $lieu = Lieu::getInstance($id_lieu);
            $smarty->assign('lieu', $lieu);
            $smarty->assign('events', Event::getEvents(array(
               'online' => true,
               'datfin' => date('Y-m-d H:i:s'),
               'lieu'   => $lieu->getId(),
               'sort'   => 'date',
               'sens'   => 'ASC',
               'limit'  => 100,
           )));
        } else {
            $smarty->assign('dep', Departement::getHashTable());
            $smarty->assign('lieux', Lieu::getLieuxByDep());
        }

        $id_event = (int) Route::params('id_event');
        if($id_event) {
            $event = Event::getInstance($id_event);
            $smarty->assign('event', $event);
            $lieu = Lieu::getInstance($event->getIdLieu());
            $smarty->assign('lieu', $lieu);
        }

        return $smarty->fetch('photos/create.tpl');
    }

    /**
     * validation du formulaire de création photo
     * @param array $data
     * @param array &$errors
     * @return bool
     */
    protected static function _validate_form_photo_create($data, &$errors)
    {
        $errors = array();
        if(empty($data['name'])) {
            $errors['name'] = "Vous devez saisir un titre pour la photo.";
        }
        if(empty($data['credits'])) {
            $errors['credits'] = "Vous devez saisir le nom du photographe";
        }
        if(count($errors)) {
            return false;
        }
        return true;
    }

    static function import()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        if(Tools::isSubmit('form-photo-import'))
        {
            set_time_limit(0); // l'import peut prendre du temps !

            // creation repertoire temporaire
            if(!file_exists(PHOTOS_EXTRACT_DIR)) {
                mkdir(PHOTOS_EXTRACT_DIR);
                Log::write('photo', "création rep tmp");
            }

            // extensions à traiter
            $exts = array('jpg', 'jpeg', 'JPG', 'JPEG');

            // à sécuriser
            $zip_name = PHOTOS_IMPORT_DIR . '/' . trim((string) Route::params('file'));

            // extraction de l'archive
            $zip = new ZipArchive();
            if ($zip->open($zip_name) === TRUE) {
                $zip->extractTo(PHOTOS_EXTRACT_DIR);
                $zip->close();
                Log::write('photo', "extraction archive ok");
            } else {
                Log::write('photo', "échec à l'extraction de l'archive");
            }

            $nb = 0;

            // boucle des extensions
            foreach($exts as $ext)
            {
                Log::write('photo', "boucle " . $ext);

                // boucle des fichiers
                foreach (glob(PHOTOS_EXTRACT_DIR . "/*." . $ext) as $filename)
                {
                    Log::write('photo', "traitement " . $filename . " (" . filesize($filename) . ") octets");

                    $data = array(
                        'name' => trim((string) Route::params('name')),
                        'credits' => trim((string) Route::params('credits')),
                        'id_groupe' => (int) Route::params('id_groupe'),
                        'id_lieu' => (int) Route::params('id_lieu'),
                        'id_event' => (int) Route::params('id_event'),
                        'id_contact' => (int) $_SESSION['membre']->getId(),
                        'id_structure' => 1,
                        'online' => true,
                    );
                    self::_validate_form_photo_create($data, $errors);

                    if(empty($errors)) {

                        $photo = Photo::init();
                        $photo->setName($data['name']);
                        $photo->setCredits($data['credits']);
                        $photo->setIdGroupe($data['id_groupe']);
                        $photo->setIdLieu($data['id_lieu']);
                        $photo->setIdEvent($data['id_event']);
                        $photo->setIdContact($data['id_contact']);
                        $photo->setIdStructure($data['id_structure']);
                        $photo->setOnline($data['online']);
                        $photo->setCreatedNow();
                        $photo->save();

                        Log::write('photo', "création image " . $photo->getId());

                        $objImg = new Image($filename);
                        $objImg->setType(IMAGETYPE_JPEG);
                        $objImg->setMaxWidth(1024);
                        $objImg->setMaxHeight(768);
                        $objImg->setDestFile(ADHOC_ROOT_PATH . '/static/media/photo/' . $photo->getId() . '.jpg');
                        $objImg->write();

                        unlink($filename);
                        Log::write('photo', "delete de " . $filename);

                        Log::action(Log::ACTION_PHOTO_CREATE, $photo->getId());

                        $nb++;

                    } else {

                        // errors

                    }

                }

            }

            // ménage
            rmdir(PHOTOS_EXTRACT_DIR);
            Log::write('photo', "delete du rep tmp");

            Tools::redirect('/medias/?create=1&nb='.$nb);

        }

        $trail = Trail::getInstance();
        $trail->addStep("Média", "/media/");
        $trail->addStep("Mes Photos", "/photos/my");
        $trail->addStep("Importer des photos");

        $smarty = new AdHocSmarty();

        $id_groupe = (int) Route::params('id_groupe');
        if($id_groupe) {
            $groupe = Groupe::getInstance($id_groupe);
            $smarty->assign('groupe', $groupe);
        } else {
            $smarty->assign('groupes', Groupe::getGroupes(array(
                'sort'   => 'name',
                'sens'   => 'ASC',
            )));
        }

        $id_lieu = (int) Route::params('id_lieu');
        if($id_lieu) {
            $lieu = Lieu::getInstance($id_lieu);
            $smarty->assign('lieu', $lieu);
            $smarty->assign('events', Event::getEvents(array(
               'online' => true,
               'datfin' => date('Y-m-d H:i:s'),
               'lieu'   => $lieu->getId(),
               'sort'   => 'date',
               'sens'   => 'ASC',
               'limit'  => 100,
           )));
        } else {
            $smarty->assign('dep', Departement::getHashTable());
            $smarty->assign('lieux', Lieu::getLieuxByDep());
        }

        $id_event = (int) Route::params('id_event');
        if($id_event) {
            $event = Event::getInstance($id_event);
            $smarty->assign('event', $event);
            $lieu = Lieu::getInstance($event->getIdLieu());
            $smarty->assign('lieu', $lieu);
        }

        return $smarty->fetch('photos/import.tpl');
    }

    static function edit()
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        $smarty->enqueue_script('/js/photo-edit.js');

        $trail = Trail::getInstance();
        $trail->addStep("Tableau de bord", "/membres/tableau-de-bord");
        $trail->addStep("Mes Photos", "/photos/my");
        $trail->addStep("Editer une photo");

        try {
            $photo = Photo::getInstance($id);
        } catch(Exception $e) {
            Route::set_http_code('404');
            $smarty->assign('unknown_photo', true);
            return $smarty->fetch('photos/edit.tpl');
        }

        if(Tools::isSubmit('form-photo-edit'))
        {
            $data = array(
                'id' => (int) $photo->getId(),
                'name' => (string) Route::params('name'),
                'credits' => (string) Route::params('credits'),
                'id_groupe' => (int) Route::params('id_groupe'),
                'id_lieu' => (int) Route::params('id_lieu'),
                'id_event' => (int) Route::params('id_event'),
                'id_contact' => (int) Route::params('id_contact'),
                'online' => (bool) Route::params('online'),
            );

            if(self::_validate_form_photo_edit($data, $errors)) {

                $photo->setName($data['name']);
                $photo->setCredits($data['credits']);
                $photo->setIdGroupe($data['id_groupe']);
                $photo->setIdLieu($data['id_lieu']);
                $photo->setIdEvent($data['id_event']);
                $photo->setOnline($data['online']);
                $photo->setModifiedNow();

                if(is_uploaded_file($_FILES['file']['tmp_name'])) {
                    $objImg = new Image($_FILES['file']['tmp_name']);
                    $objImg->setType(IMAGETYPE_JPEG);
                    $objImg->setMaxWidth(1024);
                    $objImg->setMaxHeight(768);
                    $objImg->setDestFile(Photo::getBasePath() . '/' . $photo->getId() . '.jpg');
                    $objImg->write();

                    Photo::invalidatePhotoInCache($photo->getId(),  80,  80, '000000', false,  true);
                    Photo::invalidatePhotoInCache($photo->getId(), 130, 130, '000000', false, false);
                    Photo::invalidatePhotoInCache($photo->getId(), 400, 300, '000000', false, false);
                    Photo::invalidatePhotoInCache($photo->getId(), 680, 600, '000000', false, false);
                }

                if($photo->save()) {
                    Log::action(Log::ACTION_PHOTO_EDIT, $photo->getId());
                    Tools::redirect('/medias/?edit=1');
                }

            } else {

                $errors['generic'] = true;

            }
        }

        $smarty->assign('photo', $photo);

        $smarty->assign('groupes', Groupe::getGroupes(array(
            'sort'   => 'name',
            'sens'   => 'ASC',
        )));

        $smarty->assign('dep', Departement::getHashTable());
        $smarty->assign('lieux', Lieu::getLieuxByDep());

        if($photo->getIdEvent()) {
            $event = Event::getInstance($photo->getIdEvent());
            $smarty->assign('event', $event);
            $lieu = Lieu::getInstance($event->getIdLieu());
            $smarty->assign('lieu', $lieu);
        }

        return $smarty->fetch('photos/edit.tpl');
    }

    static function ajax_update()
    {
        if(!Tools::isAuth()) {
            return 'KO';
        }

        $id = (int) Route::params('id');
        $name = trim((string) Route::params('name'));
        $credits = trim((string) Route::params('credits'));

        try {
            $photo = Photo::getInstance($id);
        } catch(Exception $e) {
            return 'KO';
        }

        if($name) {
            $photo->setName($name);
        }
        if($credits) {
            $photo->setCredits($credits);
        }

        if($photo->save()) {
            return 'OK';
        }

        return 'KO';
    }

    /**
     * validation du formulaire de modification photo
     * @param array $data
     * @param array &$errors
     * @return bool
     */
    protected static function _validate_form_photo_edit($data, &$errors)
    {
        $errors = array();
        if(empty($data['name'])) {
            $errors['name'] = "Vous devez saisir un titre pour la photo.";
        }
        if(empty($data['credits'])) {
            $errors['credits'] = "Vous devez saisir le nom du photographe";
        }
        if(count($errors)) {
            return false;
        }
        return true;
    }

    static function delete()
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Tableau de bord", "/membres/tableau-de-bord");
        $trail->addStep("Mes Photos", "/photos/my");
        $trail->addStep("Supprimer une photo");

        try {
            $photo = Photo::getInstance($id);
        } catch(Exception $e) {
            Route::set_http_code('404');
            $smarty->assign('unknown_photo', true);
            return $smarty->fetch('photos/delete.tpl');
        }

        if(Tools::isSubmit('form-photo-delete'))
        {
            if($photo->delete()) {
                Log::action(Log::ACTION_PHOTO_DELETE, $photo->getId());
                Tools::redirect('/media/?delete=1');
            }
        }

        $smarty->assign('photo', $photo);

        if($photo->getIdGroupe()) {
            $smarty->assign('groupe', Groupe::getInstance($photo->getIdGroupe()));
        }
        if($photo->getIdEvent()) {
            $smarty->assign('event', Event::getInstance($photo->getIdEvent()));
        }
        if($photo->getIdLieu()) {
            $smarty->assign('lieu', Lieu::getInstance($photo->getIdLieu()));
        }

        return $smarty->fetch('photos/delete.tpl');
    }
}
