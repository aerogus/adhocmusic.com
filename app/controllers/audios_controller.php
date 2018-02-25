<?php

// Note : on retire liens vers events, structures et lieux du formulaire
// pour plus de lisibilité, temporairement !

define('NB_AUDIOS_PER_PAGE', 80);

class Controller
{
    static function my()
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Tableau de bord", "/membres/tableau-de-bord");
        $trail->addStep("Mes Musiques");

        $page = (int) Route::params('page');;
        $id = (int) Route::params('id');
        $online = (bool) Route::params('online');

        if ($id) {
            $audio = Audio::getInstance($id);
            $audio->setOnline($online);
            $audio->save();
        }

        if ($_SESSION['membre']->getId() == 1) {
            $audios = Audio::getAudios([
                'debut'   => $page * NB_AUDIOS_PER_PAGE,
                'limit'   => NB_AUDIOS_PER_PAGE,
                'sort'    => 'id',
                'sens'    => 'ASC',
            ]);
            $nb_audios = Audio::getAudiosCount();
        } else {
            $audios = Audio::getAudios([
                'contact' => $_SESSION['membre']->getId(),
                'debut'   => $page * NB_AUDIOS_PER_PAGE,
                'limit'   => NB_AUDIOS_PER_PAGE,
                'sort'    => 'id',
                'sens'    => 'ASC',
            ]);
            $nb_audios = Audio::getMyAudiosCount();
        }
        $smarty->assign('audios', $audios);

        $smarty->assign('del', Route::params('del'));

        // pagination
        $smarty->assign('nb_items', $nb_audios);
        $smarty->assign('nb_items_per_page', NB_AUDIOS_PER_PAGE);
        $smarty->assign('page', $page);

        return $smarty->fetch('audios/my.tpl');
    }

    static function show()
    {
        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        try {
            $audio = Audio::getInstance($id);
        } catch (Exception $e) {
            Route::set_http_code('404');
            $smarty->assign('unknown_audio', true);
            return $smarty->fetch('audios/show.tpl');
        }

        $smarty->enqueue_style('/js/jplayer.blue.monday/jplayer.blue.monday.css');
        $smarty->enqueue_script('/js/jquery.jplayer.min.js');
        $smarty->enqueue_script('/js/audio-show.js');

        $trail = Trail::getInstance();

        $meta_description = "Titre : " . $audio->getName();

        $smarty->assign('og_type', 'adhocmusic:song');
        $smarty->assign('og_push_listen_to_song', true);

        if ($audio->getIdGroupe()) {
            $groupe = Groupe::getInstance($audio->getIdGroupe());
            $smarty->assign('groupe', $groupe);
            $smarty->assign('title', $audio->getName() . ' - ' . $groupe->getName());
            $meta_description .= " | Groupe : " . $groupe->getName();
            $trail->addStep("Groupes", "/groupes/");
            $trail->addStep($groupe->getName(), $groupe->getUrl());
            $smarty->assign('og_image', $groupe->getMiniPhoto());
            $smarty->assign('og_audio', [
                'url' => $audio->getDirectUrl(),
                'title' => $audio->getName(),
                'artist' => $groupe->getName(),
                'type' => "application/mp3",
            ]);
        } else {
            $trail->addStep("Média", "/medias/");
        }

        if ($audio->getIdEvent()) {
            $event = Event::getInstance($audio->getIdEvent());
            $smarty->assign('event', $event);
            $meta_description .= " | Evénement : " . $event->getName() . " (" . Date::mysql_datetime($event->getDate(), "d/m/Y") . ")";
            $smarty->assign('photos', Photo::getPhotos([
                'event'  => $event->getId(),
                'groupe' => $audio->getIdGroupe(),
                'online' => true,
                'sort'   => 'random',
                'limit'  => 100,
            ]));
            $smarty->assign('videos', Video::getVideos([
                'event'  => $event->getId(),
                'groupe' => $audio->getIdGroupe(),
                'online' => true,
                'sort'   => 'random',
                'limit'  => 100,
            ]));
        }

        if ($audio->getIdLieu()) {
            $lieu = Lieu::getInstance($audio->getIdLieu());
            $meta_description .= " | Lieu : " . $lieu->getName() . " (" . $lieu->getIdDepartement() . " - " . $lieu->getCity() . ")";
            $smarty->assign('lieu', $lieu);
        }

        $trail->addStep($audio->getName());

        $smarty->assign('description', $meta_description);

        $smarty->assign('audio', $audio);

        $smarty->assign('comments', Comment::getComments([
            'type'       => 's',
            'id_content' => $audio->getId(),
            'online'     => true,
            'sort'       => 'created_on',
            'sens'       => 'ASC',
        ]));

        return $smarty->fetch('audios/show.tpl');
    }

    static function create()
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $smarty = new AdHocSmarty();

        $smarty->enqueue_script('/js/audio-create.js');

        $trail = Trail::getInstance();
        $trail->addStep("Tableau de bord", "/membres/tableau-de-bord");
        $trail->addStep("Mes Musiques", "/audios/my");
        $trail->addStep("Ajouter une musique");

        if (Tools::isSubmit('form-audio-create'))
        {
            set_time_limit(0); // l'upload peut prendre du temps !

            $data = [
                'name'         => trim((string) Route::params('name')),
                'id_groupe'    => (int) Route::params('id_groupe'),
                'id_lieu'      => (int) Route::params('id_lieu'),
                'id_event'     => (int) Route::params('id_event'),
                'id_contact'   => (int) $_SESSION['membre']->getId(),
                'id_structure' => 0,
                'text'         => '',
                'online'       => true,
            ];

            if (self::_validate_form_audio_create($data, $errors)) {
                $audio = Audio::init();
                $audio->setName($data['name']);
                $audio->setIdGroupe($data['id_groupe']);
                $audio->setIdLieu($data['id_lieu']);
                $audio->setIdEvent($data['id_event']);
                $audio->setIdContact($data['id_contact']);
                $audio->setIdStructure($data['id_structure']);
                $audio->setOnline($data['online']);
                $audio->setCreatedNow();
                if ($audio->save()) {
                    if ($content = Route::params('file')) {
                        file_put_contents(ADHOC_ROOT_PATH . '/media/audio/' . $audio->getId() . '.mp3', $content);
                    } else {
                        mail(DEBUG_EMAIL, 'bug audio create', 'bug audio create');
                    }
                    Log::action(Log::ACTION_AUDIO_CREATE, $audio->getId());
                    Tools::redirect('/medias/?create=1');
                } else {
                    $smarty->assign('error_generic', true);
                }
            } else {
                foreach ($errors as $k => $v) {
                    $smarty->assign('error_' . $k, $v);
                }
                $smarty->assign('data', $data);
            }
        }

        $id_groupe = (int) Route::params('id_groupe');
        if ($id_groupe) {
            $groupe = Groupe::getInstance($id_groupe);
            $smarty->assign('groupe', $groupe);
        } else {
            $smarty->assign('groupes', Groupe::getGroupes([
                'sort'   => 'name',
                'sens'   => 'ASC',
            ]));
        }

        $id_lieu = (int) Route::params('id_lieu');
        if ($id_lieu) {
            $lieu = Lieu::getInstance($id_lieu);
            $smarty->assign('lieu', $lieu);
            $smarty->assign('events', Event::getEvents([
               'online' => true,
               'datfin' => date('Y-m-d H:i:s'),
               'lieu'   => $lieu->getId(),
               'sort'   => 'date',
               'sens'   => 'ASC',
               'limit'  => 100,
            ]));
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

        $smarty->assign('id_lieu', $id_lieu);

        return $smarty->fetch('audios/create.tpl');
    }

    /**
     * validation du formulaire de création audio
     * @param array $data
     * @param array &$errors
     * @return bool
     */
    protected static function _validate_form_audio_create($data, &$errors)
    {
        $errors = [];
        if (empty($data['name'])) {
            $errors['name'] = true;
        }
        if ($data['id_groupe'] == 0) {
            $errors['id_groupe'] = true;
        }
        if (count($errors)) {
            return false;
        }
        return true;
    }

    static function edit()
    {
        $id = (int) Route::params('id');
        $page = (int) Route::params('page');

        Tools::auth(Membre::TYPE_STANDARD);

        $smarty = new AdHocSmarty();

        $smarty->enqueue_script('/js/audio-edit.js');

        $trail = Trail::getInstance();
        $trail->addStep("Tableau de bord", "/membres/tableau-de-bord");
        $trail->addStep("Mes Musiques", "/audios/my");
        $trail->addStep("Editer une musique");

        try {
            $audio = Audio::getInstance($id);
        } catch (Exception $e) {
            Route::set_http_code('404');
            $smarty->assign('unknown_audio', true);
            return $smarty->fetch('audios/edit.tpl');
        }

        $smarty->assign('audio', $audio);

        if (Tools::isSubmit('form-audio-edit'))
        {
            set_time_limit(0); // l'upload peut prendre du temps !

            $data = [
                'name' => (string) Route::params('name'),
                'id_lieu' => (int) Route::params('id_lieu'),
                'id_contact' => (int) $_SESSION['membre']->getId(),
                'id_event' => (int) Route::params('id_event'),
                /*'id_structure' => (int) Route::params('id_structure'),*/
                'id_groupe' => (int) Route::params('id_groupe'),
                'online' => (bool) Route::params('online'),
            ];

            if (self::_validate_form_audio_edit($data, $errors)) {

                $file = Route::params('file');

                $audio->setName($data['name']);
                $audio->setIdLieu($data['id_lieu']);
                $audio->setIdContact($data['id_contact']);
                $audio->setIdEvent($data['id_event']);
                //$audio->setIdStructure($data['id_structure']);
                $audio->setIdGroupe($data['id_groupe']);
                $audio->setOnline($data['online']);
                $audio->setModifiedNow();

                if ($audio->save()) {
                    if ($content = Route::params('file')) {
                        file_put_contents(ADHOC_ROOT_PATH . '/media/audio/' . $audio->getId() . '.mp3', $content);
                    }
                    Log::action(Log::ACTION_AUDIO_EDIT, $audio->getId());
                    Tools::redirect('/medias/?edit=1');
                } else {
                    $smarty->assign('error_generic', true);
                }

            } else {

                foreach ($errors as $k => $v) {
                    $smarty->assign('error_' . $k, $v);
                }

            }

        }

        $smarty->assign('groupes', Groupe::getGroupes([
            'sort'   => 'name',
            'sens'   => 'ASC',
        ]));

        $smarty->assign('dep', Departement::getHashTable());
        $smarty->assign('lieux', Lieu::getLieuxByDep());

        $smarty->assign('page', $page);

        if ($audio->getIdEvent()) {
            $event = Event::getInstance($audio->getIdEvent());
            $smarty->assign('event', $event);
            $lieu = Lieu::getInstance($event->getIdLieu());
            $smarty->assign('lieu', $lieu);
        }

        if ($audio->getIdContact()) {
            $smarty->assign('membre', Membre::getInstance($audio->getIdContact()));
        }

        return $smarty->fetch('audios/edit.tpl');
    }

    /**
     * validation du formulaire de modification audio
     * @param array $data
     * @param array &$errors
     * @return bool
     */
    protected static function _validate_form_audio_edit($data, &$errors)
    {
        $errors = [];
        if (empty($data['name'])) {
            $errors['name'] = true;
        }
        if ($data['id_groupe'] == 0) {
            $errors['id_groupe'] = true;
        }
        if (count($errors)) {
            return false;
        }
        return true;
    }

    static function delete()
    {
        $id = (int) Route::params('id');

        Tools::auth(Membre::TYPE_STANDARD);

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Tableau de bord", "/membres/tableau-de-bord");
        $trail->addStep("Mes Musiques", "/audios/my");
        $trail->addStep("Supprimer une musique");

        try {
            $audio = Audio::getInstance($id);
        } catch (Exception $e) {
            Route::set_http_code('404');
            $smarty->assign('unknown_audio', true);
            return $smarty->fetch('audios/delete.tpl');
        }

        if (Tools::isSubmit('form-audio-delete'))
        {
            if ($audio->delete()) {
                Log::action(Log::ACTION_AUDIO_DELETE, $audio->getId());
                Tools::redirect('/medias/?delete=1');
            } else {
                $errors['generic'] = true;
            }
        }

        $smarty->assign('audio', $audio);
        if ($audio->getIdGroupe()) {
            try {
                $smarty->assign('groupe', Groupe::getInstance($audio->getIdGroupe()));
            } catch (Exception $e) {
            }
        }
        if ($audio->getIdEvent()) {
            $smarty->assign('event', Event::getInstance($audio->getIdEvent()));
        }
        if ($audio->getIdLieu()) {
            $smarty->assign('lieu', Lieu::getInstance($audio->getIdLieu()));
        }
        if ($audio->getIdContact()) {
            $smarty->assign('membre', Membre::getInstance($audio->getIdContact()));
        }

        return $smarty->fetch('audios/delete.tpl');
    }
}
