<?php

/**
 * adhocmusic
 * Gestion des Vidéos
 */

define('NB_VIDEOS_PER_PAGE', 48);

class Controller
{
    /**
     * Liste de mes vidéos
     */
    static function my()
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $trail = Trail::getInstance();
        $trail->addStep("Tableau de bord", "/membres/tableau-de-bord");
        $trail->addStep("Mes Vidéos");

        $page = (int) Route::params('page');

        if($_SESSION['membre']->getId() == 1) {
            $videos = Video::getVideos(array(
                'limit' => NB_VIDEOS_PER_PAGE,
                'debut' => $page * NB_VIDEOS_PER_PAGE,
                'sort'  => 'id',
                'sens'  => 'ASC',
            ));
            $nb_videos = Video::getVideosCount();
        } else {
            $videos = Video::getVideos(array(
                'contact' => $_SESSION['membre']->getId(),
                'limit'   => NB_VIDEOS_PER_PAGE,
                'debut'   => $page * NB_VIDEOS_PER_PAGE,
                'sort'    => 'id',
                'sens'    => 'ASC',
            ));
            $nb_videos = Video::getMyVideosCount();
        }

        $smarty = new AdHocSmarty();

        // pagination
        $smarty->assign('nb_items', $nb_videos);
        $smarty->assign('nb_items_per_page', NB_VIDEOS_PER_PAGE);
        $smarty->assign('page', $page);

        $smarty->assign('videos', $videos);

        return $smarty->fetch('videos/my.tpl');
    }

    /**
     * Visualisation d'une vidéo
     */
    static function show()
    {
        $id = (int) Route::params('id');
        $from = (string) Route::params('from');

        $smarty = new AdHocSmarty();

        $smarty->enqueue_style('/mediaelement/mediaelementplayer.css');
        $smarty->enqueue_script('/mediaelement/mediaelement-and-player.min.js');
        $smarty->enqueue_script('/js/video-show.js');
        $smarty->enqueue_script('/js/comments-box.js');

        $trail = Trail::getInstance();

        try {
            $video = Video::getInstance($id);
        } catch(Exception $e) {
            Route::set_http_code('404');
            $smarty->assign('unknown_video', true);
            return $smarty->fetch('videos/show.tpl');
        }

        $meta_description = "Titre : " . $video->getName();

        if($video->getOnline()) {

            $smarty->assign('video', $video);
            $smarty->assign('from', $from);
            $smarty->assign('title', "♫ " . $video->getName());
            $smarty->assign('description', $video->getName());
            $smarty->assign('og_image', HOME_URL . '/media/video/' . $video->getId() . '.jpg');
            $smarty->assign('og_type', 'video.movie');

            $og_video = array(
                'url' => Video::getFlashUrl($video->getIdHost(), $video->getReference()),
                'width' => $video->getWidth(),
                'height' => $video->getHeight(),
                'type' => "application/x-shockwave-flash",
            );
            $smarty->assign('og_video', $og_video);

            if($video->getIdGroupe()) {
                $groupe = Groupe::getInstance($video->getIdGroupe());
                $smarty->assign('groupe', $groupe);
                $smarty->assign('title', "♫ " . $video->getName() . " (" . $groupe->getName() . ")");
                $meta_description .= " | Groupe : " . $groupe->getName();
            }
            if($video->getIdEvent()) {
                $event = Event::getInstance($video->getIdEvent());
                $smarty->assign('event', $event);
                $meta_description .= " | Evénement : " . $event->getName() . " (" . Date::mysql_datetime($event->getDate(), "d/m/Y") . ")";
            }
            if($video->getIdLieu()) {
                $lieu = Lieu::getInstance($video->getIdLieu());
                $smarty->assign('lieu', $lieu);
                $meta_description .= " | Lieu : " . $lieu->getName() . " (" . $lieu->getIdDepartement() . " - " . $lieu->getCity() . ")";
            }
            if($video->getIdContact()) {
                $membre = Membre::getInstance($video->getIdContact());
                $smarty->assign('membre', $membre);
            }

            // menu et fil d'ariane
            if($from === 'groupe' && $video->getIdGroupe()) {
                $smarty->assign('menuselected', 'groupe');
                $trail->addStep("Groupes", "/groupes/");
                $trail->addStep($groupe->getName(), $groupe->getUrl());
            } elseif($from === 'profil' && $video->getIdContact()) {
                $trail->addStep("Zone Membre", "/membres/");
            } elseif($from === 'event' && $video->getIdEvent()) {
                $smarty->assign('menuselected', 'event');
                $trail->addStep("Agenda", "/events/");
                $trail->addStep($event->getName(), "/events/" . $event->getId());
            } elseif($from === 'lieu' && $video->getIdLieu()) {
                $smarty->assign('menuselected', 'lieux');
                $trail->addStep("Lieux", "/lieux/");
                $trail->addStep($lieu->getName(), "/lieux/" . $lieu->getId());
            } else {
                $smarty->assign('menuselected', 'media');
                $trail->addStep("Média", "/medias/");
            }
            $trail->addStep($video->getName());

            // vidéos et photos liées à l'événement/lieu
            if($video->getIdEvent() && $video->getIdLieu()) {
                $smarty->assign('photos', Photo::getPhotos(array(
                    'event'  => $video->getIdEvent(),
                    'groupe' => $video->getIdGroupe(),
                    'online' => true,
                    'sort'   => 'random',
                    'limit'  => 30,
                )));
                $smarty->assign('videos', Video::getVideos(array(
                    'event'  => $video->getIdEvent(),
                    'groupe' => $video->getIdGroupe(),
                    'online' => true,
                    'sort'   => 'random',
                    'limit'  => 30,
                )));
            }

            $smarty->assign('description', $meta_description);

            $smarty->assign('comments', Comment::getComments(array(
                'type'       => 'v',
                'id_content' => $video->getId(),
                'online'     => true,
                'sort'       => 'created_on',
                'sens'       => 'ASC',
            )));

        } else {

            $smarty->assign('unknown_video', true);

        }

        return $smarty->fetch('videos/show.tpl');
    }

    /**
     * Code playr embarqué
     */
    static function embed()
    {
        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        try {
            $video = Video::getInstance($id);
        } catch(Exception $e) {
            Route::set_http_code('404');
            $smarty->assign('unknown_video', true);
            return $smarty->fetch('videos/embed.tpl');
        }

        if($video->getOnline()) {
            $smarty->assign('video', $video);
         } else {
            $smarty->assign('unknown_video', true);
        }

        return $smarty->fetch('videos/embed.tpl');
    }

    /**
     * Ajout d'une vidéo
     */
    static function create()
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $smarty = new AdHocSmarty();

        $smarty->enqueue_script('/js/video-create.js');

        if(Tools::isSubmit('form-video-create'))
        {
            $data = array(
                'name' => (string) Route::params('name'),
                'id_groupe' => (int) Route::params('id_groupe'),
                'id_lieu' => (int) Route::params('id_lieu'),
                'id_event' => (int) Route::params('id_event'),
                'id_structure' => 0,
                'id_contact' => $_SESSION['membre']->getId(),
                'online' => true,
                'id_host' => (int) Route::params('id_host'),
                'code' => (string) Route::params('code'),
                'reference' => (string) Route::params('reference'),
            );

            if(self::_validate_form_video_create($data, $errors)) {

                if($data['id_host'] !== Video::HOST_ADHOC) {
                    $info = Video::parseStringForVideoUrl($data['code']);
                    $data['id_host'] = $info['id_host'];
                    $data['reference'] = $info['reference'];
                } else {
                    $data['reference'] = time();
                }

                $video = Video::init();
                $video->setName($data['name']);
                $video->setIdGroupe($data['id_groupe']);
                $video->setIdLieu($data['id_lieu']);
                $video->setIdEvent($data['id_event']);
                $video->setIdStructure($data['id_structure']);
                $video->setIdContact($data['id_contact']);
                $video->setOnline($data['online']);
                $video->setIdHost($data['id_host']);
                $video->setReference($data['reference']);
                $video->setCreatedNow();
                $video->save();

                if($vignette = Video::getRemoteThumbnail($video->getIdHost(), $video->getReference())) {
                    $video->storeThumbnail($vignette);
                }

                Log::action(Log::ACTION_VIDEO_CREATE, $video->getId());

                Tools::redirect('/medias/?create=1');

            } else {

                foreach($errors as $k => $v) {
                    $smarty->assign('error_' . $k, $v);
                }

            }
        }

        $trail = Trail::getInstance();
        $trail->addStep("Tableau de bord", "/membres/tableau-de-bord");
        $trail->addStep("Mes Vidéos", "/videos/my");
        $trail->addStep("Ajouter une vidéo");

        $hosts = Video::getVideoHosts();
        $smarty->assign('hosts', $hosts);

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

        $id_event  = (int) Route::params('id_event');
        if($id_event) {
            $event = Event::getInstance($id_event);
            $smarty->assign('event', $event);
            $lieu = Lieu::getInstance($event->getIdLieu());
            $smarty->assign('lieu', $lieu);
        }

        return $smarty->fetch('videos/create.tpl');
    }

    /**
     * validation du formulaire de modification vidéo
     *
     * @param array $data
     * @param array &$errors
     * @return bool
     */
    protected static function _validate_form_video_create($data, &$errors)
    {
        $errors = array();
        if(empty($data['name'])) {
            $errors['name'] = "Vous devez saisir un titre pour la vidéo.";
        }
        if($data['id_host'] !== Video::HOST_ADHOC) {
            if(empty($data['code'])) {
                $errors['code'] = "Vous devez copier/coller un code de vidéo Youtube ou Dailymotion";
            } elseif(Video::parseStringForVideoUrl($data['code']) === false) {
                $errors['unknown_host'] = "Code de la vidéo non reconnu ou hébergeur incompatible";
            }
        }
        if(count($errors)) {
            return false;
        }
        return true;
    }

    /**
     * Édition d'une vidéo
     */
    static function edit()
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $id = (int) Route::params('id');
        $page = (int) Route::params('page');

        $smarty = new AdHocSmarty();

        $smarty->enqueue_script('/js/videos-edit.js');

        try {
            $video = Video::getInstance($id);
        } catch(Exception $e) {
            Route::set_http_code('404');
            $smarty->assign('unknown_video', true);
            return $smarty->fetch('videos/edit.tpl');
        }

        if(Tools::isSubmit('form-video-edit'))
        {
            $data = array(
                'id' => (int) Route::params('id'),
                'name' => (string) Route::params('name'),
                'id_lieu' => (int) Route::params('id_lieu'),
                'id_event' => (int) Route::params('id_event'),
                'id_groupe' => (int) Route::params('id_groupe'),
                'online' => (bool) Route::params('online'),
            );

            if(self::_validate_form_video_edit($data, $errors)) {

                $video->setName($data['name']);
                $video->setIdLieu($data['id_lieu']);
                $video->setIdEvent($data['id_event']);
                $video->setIdGroupe($data['id_groupe']);
                $video->setOnline($data['online']);
                $video->save();

                if($vignette = Video::getRemoteThumbnail($video->getIdHost(), $video->getReference())) {
                    $video->storeThumbnail($vignette);
                    Video::invalidateVideoThumbInCache($video->getId(), 80, 80, '000000', false, true);
                }

                Log::action(Log::ACTION_VIDEO_EDIT, $video->getId());

                Tools::redirect('/medias/?edit=1');

            } else {

                foreach($errors as $k => $v) {
                    $smarty->assign('error_' . $k, $v);
                }

            }
        }

        $trail = Trail::getInstance();
        $trail->addStep("Tableau de bord", "/membres/tableau-de-bord");
        $trail->addStep("Mes Vidéos", "/videos/my");
        $trail->addStep("Editer une vidéo");

        $smarty->assign('video', $video);

        $smarty->assign('groupes', Groupe::getGroupes(array(
            'sort'   => 'name',
            'sens'   => 'ASC',
         )));

        $smarty->assign('dep', Departement::getHashTable());
        $smarty->assign('lieux', Lieu::getLieuxByDep());

        $smarty->assign('page', $page);

        if($video->getIdEvent()) {
            $event = Event::getInstance($video->getIdEvent());
            $smarty->assign('event', $event);
            $lieu = Lieu::getInstance($video->getIdLieu());
            $smarty->assign('lieu', $lieu);
        }

        return $smarty->fetch('videos/edit.tpl');
    }

    /**
     * validation du formulaire de modification vidéo
     *
     * @param array $data
     * @param array &$errors
     * @return bool
     */
    protected static function _validate_form_video_edit($data, &$errors)
    {
        $errors = array();
        if(empty($data['name'])) {
            $errors['name'] = "Vous devez saisir un titre pour la vidéo.";
        }
        if(count($errors)) {
            return false;
        }
        return true;
    }

    /**
     * Suppression d'une vidéo
     */
    static function delete()
    {
        Tools::auth(Membre::TYPE_ADMIN);

        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Tableau de bord", "/membres/tableau-de-bord");
        $trail->addStep("Mes Vidéos", "/videos/my");
        $trail->addStep("Supprimer une vidéo");

        try {
            $video = Video::getInstance($id);
        } catch(Exception $e) {
            Route::set_http_code('404');
            $smarty->assign('unknown_video', true);
            return $smarty->fetch('videos/delete.tpl');
        }

        if(Tools::isSubmit('form-video-delete'))
        {
            if($video->delete()) {
                Log::action(Log::ACTION_VIDEO_DELETE, $video->getId());
                Tools::redirect('/medias/?delete=1');
            }
        }

        $smarty->assign('video', $video);

        if($video->getIdGroupe()) {
            $smarty->assign('groupe', Groupe::getInstance($video->getIdGroupe()));
        }
        if($video->getIdEvent()) {
            $smarty->assign('event', Event::getInstance($video->getIdEvent()));
        }
        if($video->getIdLieu()) {
            $smarty->assign('lieu', Lieu::getInstance($video->getIdLieu()));
        }

        return $smarty->fetch('videos/delete.tpl');
    }

    /**
     * Récupère des infos sur une vidéo
     */
    static function get_meta()
    {
        $code = (string) Route::params('code');

        if($info = Video::parseStringForVideoUrl($code)) {
            $out = array(
                'status' => 'OK',
                'data' => $info,
            );
            $out['data']['thumb'] = Video::getRemoteThumbnail($out['data']['id_host'], $out['data']['reference']);
            $out['data']['title'] = Video::getRemoteTitle($out['data']['id_host'], $out['data']['reference']);
        } else {
            $out = array(
                'status' => 'KO',
            );
        }

        return $out;
    }
}
