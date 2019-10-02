<?php declare(strict_types=1);

define('NB_PHOTOS_PER_PAGE', 64);
define('PHOTOS_IMPORT_DIR', ADHOC_ROOT_PATH . '/import');
define('PHOTOS_EXTRACT_DIR', PHOTOS_IMPORT_DIR . '/tmp');

/**
 *
 */
final class Controller
{
    /**
     * @return string
     */
    static function my(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        Trail::getInstance()
            ->addStep("Tableau de bord", "/membres/tableau-de-bord")
            ->addStep("Mes Photos");

        $smarty = new AdHocSmarty();

        $page = (int) Route::params('page');

        $smarty->assign('create', (bool) Route::params('create'));
        $smarty->assign('edit', (bool) Route::params('edit'));
        $smarty->assign('delete', (bool) Route::params('delete'));

        $photos = Photo::getPhotos(
            [
                'contact' => $_SESSION['membre']->getId(),
                'limit'   => NB_PHOTOS_PER_PAGE,
                'debut'   => $page * NB_PHOTOS_PER_PAGE,
                'sort'    => 'id',
                'sens'    => 'ASC',
            ]
        );
        $nb_photos = Photo::getMyPhotosCount();

        $smarty->assign('photos', $photos);

        $smarty->assign('nb_items', $nb_photos);
        $smarty->assign('nb_items_per_page', NB_PHOTOS_PER_PAGE);
        $smarty->assign('page', $page);

        return $smarty->fetch('photos/my.tpl');
    }

    /**
     * @return string
     */
    static function show(): string
    {
        $id = (int) Route::params('id');
        $from = (string) Route::params('from');

        $smarty = new AdHocSmarty();

        try {
            $photo = Photo::getInstance($id);
        } catch (Exception $e) {
            Route::set_http_code('404');
            $smarty->assign('unknown_photo', true);
            return $smarty->fetch('photos/show.tpl');
        }

        $meta_title = '';
        $meta_description = "Titre : " . $photo->getName();

        if ($photo->getOnline() || (!$photo->getOnline() && Tools::isAuth() && Tools::auth(Membre::TYPE_INTERNE))) {

            $smarty->assign('photo', $photo);
            $smarty->assign('from', $from);
            $smarty->assign('og_image', $photo->getThumb130Url());
            $smarty->assign('has_credits', (bool) $photo->getCredits());

            $meta_title .= $photo->getName();

            if ($photo->getIdGroupe()) {
                $groupe = Groupe::getInstance($photo->getIdGroupe());
                $smarty->assign('groupe', $groupe);
                $meta_title .= " - " . $groupe->getName();
                $meta_description .= " | Groupe : " . $groupe->getName();
            }
            if ($photo->getIdEvent()) {
                $event = Event::getInstance($photo->getIdEvent());
                $smarty->assign('event', $event);
                $meta_title .= " - " . $event->getName() . " (" . Date::mysql_datetime($event->getDate(), "d/m/Y") . ")";
                $meta_description .= " | Evénement : " . $event->getName() . " (" . Date::mysql_datetime($event->getDate(), "d/m/Y") . ")";
            }
            if ($photo->getIdLieu()) {
                $lieu = Lieu::getInstance($photo->getIdLieu());
                $smarty->assign('lieu', $lieu);
                $meta_title .= " - " . $lieu->getName();
                $meta_description .= " | Lieu : " . $lieu->getName() . " (" . $lieu->getIdDepartement() . " - " . $lieu->getCity() . ")";
            }
            if ($photo->getIdContact()) {
                try {
                    $membre = Membre::getInstance($photo->getIdContact());
                    $smarty->assign('membre', $membre);
                } catch (Exception $e) {
                    mail(DEBUG_EMAIL, "[AD'HOC] Bug : photo avec membre introuvable", print_r($e, true));
                }
            }

            $trail = Trail::getInstance();
            if ($from === 'groupe' && $photo->getIdGroupe()) {
                $trail->addStep("Groupes", "/groupes/")
                    ->addStep($groupe->getName(), $groupe->getUrl());
            } elseif ($from === 'profil' && $photo->getIdContact()) {
                $trail->addStep("Zone Membre", "/membres/");
            } elseif ($from === 'event' && $photo->getIdEvent()) {
                $trail->addStep("Agenda", "/events/")
                    ->addStep($event->getName(), $event->getUrl());
            } elseif ($from === 'lieu' && $photo->getIdLieu()) {
                $trail->addStep("Lieux", "/lieux/")
                    ->addStep($lieu->getName(), $lieu->getUrl());
            } else {
                $trail->addStep("Média", "/medias/");
            }
            $trail->addStep($photo->getName());

            // photo issu d'un album live ?
            if ($photo->getIdEvent() && $photo->getIdLieu()) {
                $playlist = Photo::getPhotos(
                    [
                        'online' => true,
                        'event'  => $photo->getIdEvent(),
                        'lieu'   => $photo->getIdLieu(),
                        'sort'   => 'id',
                        'sens'   => 'ASC',
                        'limit'  => 200,
                    ]
                );

                // calcul photo suivante/précente
                $idx = 0;
                $count = count($playlist);
                foreach ($playlist as $_idx => $_playlist) {
                    if ((int) $_playlist['id'] === (int) $photo->getId()) {
                        $idx_photo = $_idx;
                        if ($_idx < ($count - 1)) {
                            $next = $_idx + 1;
                        } else {
                            $next = 0;
                        }
                        if ($_idx > 0) {
                            $prev = $_idx - 1;
                        } else {
                            $prev = $count - 1;
                        }
                    }
                }
                $smarty->assign('next', Photo::getUrlById((int) $playlist[$next]['id']));
                $smarty->assign('prev', Photo::getUrlById((int) $playlist[$prev]['id']));

                $smarty->assign('idx_photo', $idx_photo + 1);
                $smarty->assign('nb_photos', $count);
                $meta_title .= ' - ' . ($idx_photo + 1) . '/' . $count;
                $smarty->assign('playlist', $playlist);
            }

            $smarty->assign('title', $meta_title);
            $smarty->assign('description', $meta_description);

            $smarty->assign(
                'comments', Comment::getComments(
                    [
                        'type'       => 'p',
                        'id_content' => $photo->getId(),
                        'online'     => true,
                        'sort'       => 'created_on',
                        'sens'       => 'ASC',
                    ]
                )
            );

        } else {

            // pas en ligne, pas les droits
            $smarty->assign('unknown_photo', true);

        }

        return $smarty->fetch('photos/show.tpl');
    }

    /**
     * @return string
     */
    static function create(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        if (Tools::isSubmit('form-photo-create')) {
            $data = [
                'name' => trim((string) Route::params('name')),
                'credits' => trim((string) Route::params('credits')),
                'id_groupe' => (int) Route::params('id_groupe'),
                'id_lieu' => (int) Route::params('id_lieu'),
                'id_event' => (int) Route::params('id_event'),
                'id_contact' => (int) $_SESSION['membre']->getId(),
                'id_structure' => 0,
                'online' => (bool) Route::params('online'),
            ];
            $errors = [];

            if (self::_validatePhotoCreateForm($data, $errors)) {

                $photo = Photo::init()
                    ->setName($data['name'])
                    ->setCredits($data['credits'])
                    ->setIdGroupe($data['id_groupe'])
                    ->setIdLieu($data['id_lieu'])
                    ->setIdEvent($data['id_event'])
                    ->setIdContact($data['id_contact'])
                    ->setIdStructure($data['id_structure'])
                    ->setOnline($data['online'])
                    ->setCreatedNow();

                $photo->save();

                if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                    (new Image($_FILES['file']['tmp_name']))
                        ->setType(IMAGETYPE_JPEG)
                        ->setMaxWidth(1024)
                        ->setMaxHeight(768)
                        ->setDestFile(Photo::getBasePath() . '/' . $photo->getId() . '.jpg')
                        ->write();
                }

                Log::action(Log::ACTION_PHOTO_CREATE, $photo->getId());

                Tools::redirect('/medias/?create=1');

            } else {

                $errors['generic'] = true;

            }
        }

        Trail::getInstance()
            ->addStep("Tableau de bord", "/membres/tableau-de-bord")
            ->addStep("Mes Photos", "/photos/my")
            ->addStep("Ajouter une photo");

        $smarty = new AdHocSmarty();

        $smarty->enqueue_script('/js/photo-create.js');

        $id_groupe = (int) Route::params('id_groupe');
        if ($id_groupe) {
            $groupe = Groupe::getInstance($id_groupe);
            $smarty->assign('groupe', $groupe);
        } else {
            $smarty->assign(
                'groupes', Groupe::getGroupes(
                    [
                        'sort'   => 'name',
                        'sens'   => 'ASC',
                        'online' => true,
                    ]
                )
            );
        }

        $id_lieu = (int) Route::params('id_lieu');
        if ($id_lieu) {
            $lieu = Lieu::getInstance($id_lieu);
            $smarty->assign('lieu', $lieu);
            $smarty->assign(
                'events', Event::getEvents(
                    [
                        'online' => true,
                        'datfin' => date('Y-m-d H:i:s'),
                        'lieu'   => $lieu->getId(),
                        'sort'   => 'date',
                        'sens'   => 'ASC',
                        'limit'  => 100,
                    ]
                )
            );
        } else {
            $smarty->assign('dep', Departement::getHashTable());
            $smarty->assign('lieux', Lieu::getLieuxByDep());
        }

        $id_event = (int) Route::params('id_event');
        if ($id_event) {
            $event = Event::getInstance($id_event);
            $smarty->assign('event', $event);
            $lieu = Lieu::getInstance($event->getIdLieu());
            $smarty->assign('lieu', $lieu);
        }

        return $smarty->fetch('photos/create.tpl');
    }

    /**
     * @return string
     */
    static function import(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        if (Tools::isSubmit('form-photo-import')) {

            //@TODO A DEBUGGER
            die('a debuguer');

            set_time_limit(0); // l'import peut prendre du temps !

            // creation repertoire temporaire
            if (!file_exists(PHOTOS_EXTRACT_DIR)) {
                mkdir(PHOTOS_EXTRACT_DIR);
                Log::write('photo', "création rep tmp");
            }

            // extensions à traiter
            $exts = ['jpg', 'jpeg', 'JPG', 'JPEG'];

            // à sécuriser
            $zip_name = PHOTOS_IMPORT_DIR . '/' . trim((string) Route::params('file'));

            // extraction de l'archive
            $zip = new ZipArchive();
            if ($zip->open($zip_name) === true) {
                $zip->extractTo(PHOTOS_EXTRACT_DIR);
                $zip->close();
                Log::write('photo', "extraction archive ok");
            } else {
                Log::write('photo', "échec à l'extraction de l'archive");
            }

            $nb = 0;

            // boucle des extensions
            foreach ($exts as $ext) {
                Log::write('photo', "boucle " . $ext);

                // boucle des fichiers
                foreach (glob(PHOTOS_EXTRACT_DIR . "/*." . $ext) as $filename) {
                    Log::write('photo', "traitement " . $filename . " (" . filesize($filename) . ") octets");

                    $data = [
                        'name' => trim((string) Route::params('name')),
                        'credits' => trim((string) Route::params('credits')),
                        'id_groupe' => (int) Route::params('id_groupe'),
                        'id_lieu' => (int) Route::params('id_lieu'),
                        'id_event' => (int) Route::params('id_event'),
                        'id_contact' => (int) $_SESSION['membre']->getId(),
                        'id_structure' => 1,
                        'online' => true,
                    ];
                    $errors = [];

                    self::_validatePhotoCreateForm($data, $errors);

                    if (empty($errors)) {

                        $photo = Photo::init()
                            ->setName($data['name'])
                            ->setCredits($data['credits'])
                            ->setIdGroupe($data['id_groupe'])
                            ->setIdLieu($data['id_lieu'])
                            ->setIdEvent($data['id_event'])
                            ->setIdContact($data['id_contact'])
                            ->setIdStructure($data['id_structure'])
                            ->setOnline($data['online'])
                            ->setCreatedNow();

                        $photo->save();

                        Log::write('photo', "création image " . $photo->getId());

                        (new Image($filename))
                            ->setType(IMAGETYPE_JPEG)
                            ->setMaxWidth(1024)
                            ->setMaxHeight(768)
                            ->setDestFile(ADHOC_ROOT_PATH . '/static/media/photo/' . $photo->getId() . '.jpg')
                            ->write();

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

        Trail::getInstance()
            ->addStep("Tableau de bord", "/membres/tableau-de-bord")
            ->addStep("Mes Photos", "/photos/my")
            ->addStep("Importer des photos");

        $smarty = new AdHocSmarty();

        $id_groupe = (int) Route::params('id_groupe');
        if ($id_groupe) {
            $groupe = Groupe::getInstance($id_groupe);
            $smarty->assign('groupe', $groupe);
        } else {
            $smarty->assign(
                'groupes', Groupe::getGroupes(
                    [
                        'sort'   => 'name',
                        'sens'   => 'ASC',
                    ]
                )
            );
        }

        $id_lieu = (int) Route::params('id_lieu');
        if ($id_lieu) {
            $lieu = Lieu::getInstance($id_lieu);
            $smarty->assign('lieu', $lieu);
            $smarty->assign(
                'events', Event::getEvents(
                    [
                        'online' => true,
                        'datfin' => date('Y-m-d H:i:s'),
                        'lieu'   => $lieu->getId(),
                        'sort'   => 'date',
                        'sens'   => 'ASC',
                        'limit'  => 100,
                    ]
                )
            );
        } else {
            $smarty->assign('dep', Departement::getHashTable());
            $smarty->assign('lieux', Lieu::getLieuxByDep());
        }

        $id_event = (int) Route::params('id_event');
        if ($id_event) {
            $event = Event::getInstance($id_event);
            $smarty->assign('event', $event);
            $lieu = Lieu::getInstance($event->getIdLieu());
            $smarty->assign('lieu', $lieu);
        }

        return $smarty->fetch('photos/import.tpl');
    }

    /**
     * @return string
     */
    static function edit(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        $smarty->enqueue_script('/js/photo-edit.js');

        Trail::getInstance()
            ->addStep("Tableau de bord", "/membres/tableau-de-bord")
            ->addStep("Mes Photos", "/photos/my")
            ->addStep("Editer une photo");

        try {
            $photo = Photo::getInstance($id);
        } catch (Exception $e) {
            Route::set_http_code('404');
            $smarty->assign('unknown_photo', true);
            return $smarty->fetch('photos/edit.tpl');
        }

        if (Tools::isSubmit('form-photo-edit')) {
            $data = [
                'id' => (int) $photo->getId(),
                'name' => (string) Route::params('name'),
                'credits' => (string) Route::params('credits'),
                'id_groupe' => (int) Route::params('id_groupe'),
                'id_lieu' => (int) Route::params('id_lieu'),
                'id_event' => (int) Route::params('id_event'),
                'id_contact' => (int) Route::params('id_contact'),
                'online' => (bool) Route::params('online'),
            ];
            $errors = [];

            if (self::_validatePhotoEditForm($data, $errors)) {

                $photo->setName($data['name'])
                    ->setCredits($data['credits'])
                    ->setIdGroupe($data['id_groupe'])
                    ->setIdLieu($data['id_lieu'])
                    ->setIdEvent($data['id_event'])
                    ->setOnline($data['online'])
                    ->setModifiedNow();

                if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                    (new Image($_FILES['file']['tmp_name']))
                        ->setType(IMAGETYPE_JPEG)
                        ->setMaxWidth(1024)
                        ->setMaxHeight(768)
                        ->setDestFile(Photo::getBasePath() . '/' . $photo->getId() . '.jpg')
                        ->write();

                    Photo::invalidatePhotoInCache($photo->getId(),  80,  80, '000000', false,  true);
                    Photo::invalidatePhotoInCache($photo->getId(), 130, 130, '000000', false, false);
                    Photo::invalidatePhotoInCache($photo->getId(), 400, 300, '000000', false, false);
                    Photo::invalidatePhotoInCache($photo->getId(), 680, 600, '000000', false, false);
                }

                if ($photo->save()) {
                    Log::action(Log::ACTION_PHOTO_EDIT, $photo->getId());
                    Tools::redirect('/medias/?edit=1');
                }

            } else {

                $errors['generic'] = true;

            }
        }

        $smarty->assign('photo', $photo);

        $smarty->assign(
            'groupes', Groupe::getGroupes(
                [
                    'sort'   => 'name',
                    'sens'   => 'ASC',
                ]
            )
        );

        $smarty->assign('dep', Departement::getHashTable());
        $smarty->assign('lieux', Lieu::getLieuxByDep());

        if ($photo->getIdEvent()) {
            $event = Event::getInstance($photo->getIdEvent());
            $smarty->assign('event', $event);
            $lieu = Lieu::getInstance($event->getIdLieu());
            $smarty->assign('lieu', $lieu);
        }

        return $smarty->fetch('photos/edit.tpl');
    }

    /**
     * @return string
     */
    static function ajax_update(): string
    {
        if (!Tools::isAuth()) {
            return 'KO';
        }

        $id = (int) Route::params('id');
        $name = trim((string) Route::params('name'));
        $credits = trim((string) Route::params('credits'));

        try {
            $photo = Photo::getInstance($id);
        } catch (Exception $e) {
            return 'KO';
        }

        if ($name) {
            $photo->setName($name);
        }
        if ($credits) {
            $photo->setCredits($credits);
        }

        if ($photo->save()) {
            return 'OK';
        }

        return 'KO';
    }

    /**
     * @return string
     */
    static function delete(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        Trail::getInstance()
            ->addStep("Tableau de bord", "/membres/tableau-de-bord")
            ->addStep("Mes Photos", "/photos/my")
            ->addStep("Supprimer une photo");

        try {
            $photo = Photo::getInstance($id);
        } catch (Exception $e) {
            Route::set_http_code('404');
            $smarty->assign('unknown_photo', true);
            return $smarty->fetch('photos/delete.tpl');
        }

        if (Tools::isSubmit('form-photo-delete')) {
            if ($photo->delete()) {
                Log::action(Log::ACTION_PHOTO_DELETE, $photo->getId());
                Tools::redirect('/medias/?delete=1');
            }
        }

        $smarty->assign('photo', $photo);

        if ($photo->getIdGroupe()) {
            $smarty->assign('groupe', Groupe::getInstance($photo->getIdGroupe()));
        }
        if ($photo->getIdEvent()) {
            $smarty->assign('event', Event::getInstance($photo->getIdEvent()));
        }
        if ($photo->getIdLieu()) {
            $smarty->assign('lieu', Lieu::getInstance($photo->getIdLieu()));
        }

        return $smarty->fetch('photos/delete.tpl');
    }

    /**
     * Validation du formulaire de création photo
     *
     * @param array $data   tableau des données
     * @param array $errors tableau des erreurs (par référence)
     *
     * @return bool
     */
    private static function _validatePhotoCreateForm(array $data, array &$errors): bool
    {
        if (empty($data['name'])) {
            $errors['name'] = "Vous devez saisir un titre pour la photo.";
        }
        if (empty($data['credits'])) {
            $errors['credits'] = "Vous devez saisir le nom du photographe";
        }
        if (count($errors)) {
            return false;
        }
        return true;
    }

    /**
     * Validation du formulaire de modification photo
     *
     * @param array $data   tableau des données
     * @param array $errors tableau des erreurs (par référence)
     *
     * @return bool
     */
    private static function _validatePhotoEditForm(array $data, array &$errors): bool
    {
        if (empty($data['name'])) {
            $errors['name'] = "Vous devez saisir un titre pour la photo.";
        }
        if (empty($data['credits'])) {
            $errors['credits'] = "Vous devez saisir le nom du photographe";
        }
        if (count($errors)) {
            return false;
        }
        return true;
    }
}
