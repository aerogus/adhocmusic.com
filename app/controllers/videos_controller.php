<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Reference\Departement;

define('NB_VIDEOS_PER_PAGE', 48);

final class Controller
{
    /**
     * Liste de mes vidéos
     *
     * @return string
     */
    public static function my(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        Trail::getInstance()
            ->addStep('Tableau de bord', '/membres/tableau-de-bord')
            ->addStep('Mes vidéos');

        $page = (int) Route::params('page');

        if ($_SESSION['membre']->getId() === 1) {
            $videos = Video::find(
                [
                    'order_by' => 'id_video',
                    'sort' => 'ASC',
                    'start' => $page * NB_VIDEOS_PER_PAGE,
                    'limit' => NB_VIDEOS_PER_PAGE,
                ]
            );
            $nb_videos = Video::count();
        } else {
            $videos = Video::find(
                [
                    'id_contact' => $_SESSION['membre']->getId(),
                    'order_by' => 'id_video',
                    'sort' => 'ASC',
                    'start' => $page * NB_VIDEOS_PER_PAGE,
                    'limit' => NB_VIDEOS_PER_PAGE,
                ]
            );
            $nb_videos = Video::countMy();
        }

        $smarty = new AdHocSmarty();

        $smarty->assign('robots', 'noindex,nofollow');

        $smarty->enqueue_script('/js/masonry-4.2.2.min.js');
        $smarty->enqueue_script('/js/imagesloaded-4.1.4.min.js');
        $smarty->enqueue_script('/js/baguetteBox-1.11.1.min.js');

        $smarty->enqueue_script('/js/videos/my.js');

        // pagination
        $smarty->assign('nb_items', $nb_videos);
        $smarty->assign('nb_items_per_page', NB_VIDEOS_PER_PAGE);
        $smarty->assign('page', $page);

        $smarty->assign('videos', $videos);

        return $smarty->fetch('videos/my.tpl');
    }

    /**
     * Visualisation d'une vidéo
     *
     * @return string
     */
    public static function show(): string
    {
        $id = (int) Route::params('id');
        $from = (string) Route::params('from');

        $smarty = new AdHocSmarty();

        $smarty->enqueue_style('/css/baguetteBox-1.11.1.min.css');

        $smarty->enqueue_script('/js/masonry-4.2.2.min.js');
        $smarty->enqueue_script('/js/imagesloaded-4.1.4.min.js');
        $smarty->enqueue_script('/js/baguetteBox-1.11.1.min.js');

        $smarty->enqueue_script('/js/videos/show.js');

        try {
            $video = Video::getInstance($id);
        } catch (Exception $e) {
            Route::set_http_code(404);
            $smarty->assign('unknown_video', true);
            return $smarty->fetch('videos/show.tpl');
        }

        $meta_description = "Titre : " . $video->getName();

        if ($video->getOnline()) {
            $smarty->assign('video', $video);
            $smarty->assign('from', $from);
            $smarty->assign('title', "♫ " . $video->getName());
            $smarty->assign('description', $video->getName());
            $smarty->assign('og_image', MEDIA_URL . '/video/' . $video->getId() . '.jpg');
            $smarty->assign('og_type', 'video.movie');

            // @see https://developers.facebook.com/docs/sharing/webmasters?locale=fr_FR
            // mais la preview live ne marche pas/plus sur FB...
            $og_video = [
                'url' => $video->getDirectMp4Url(),
                'secure_url' => $video->getDirectMp4Url(),
                'type' => 'video/mp4',
                'width' => 1280, // fake
                'height' => 720, // fake
            ];
            $smarty->assign('og_video', $og_video);

            if ($video->getGroupes()) {
                $groupe = Groupe::getInstance($video->getGroupes()[0]->getId());
                $smarty->assign('groupe', $groupe);
                $smarty->assign('title', "♫ " . $video->getName() . " (" . $groupe->getName() . ")");
                $meta_description .= " | Groupe : " . $groupe->getName();
            }
            if ($video->getIdEvent()) {
                $event = Event::getInstance($video->getIdEvent());
                $smarty->assign('event', $event);
                $meta_description .= " | Evénement : " . $event->getName() . " (" . Date::mysqlDatetime($event->getDate(), "d/m/Y") . ")";
            }
            if ($video->getIdLieu()) {
                $lieu = Lieu::getInstance($video->getIdLieu());
                $smarty->assign('lieu', $lieu);
                $meta_description .= " | Lieu : " . $lieu->getName() . " (" . $lieu->getIdDepartement() . " - " . $lieu->getCity()->getName() . ")";
            }
            if ($video->getIdContact()) {
                $membre = Membre::getInstance($video->getIdContact());
                $smarty->assign('membre', $membre);
            }

            // menu et fil d'ariane
            if ($from === 'groupe' && $video->getGroupes()) {
                Trail::getInstance()
                    ->addStep("Groupes", "/groupes")
                    ->addStep($groupe->getName(), $groupe->getUrl());
            } elseif ($from === 'profil' && $video->getIdContact()) {
                Trail::getInstance()
                    ->addStep("Zone Membre", "/membres");
            } elseif ($from === 'event' && $video->getIdEvent()) {
                Trail::getInstance()
                    ->addStep("Agenda", "/events")
                    ->addStep($event->getName(), "/events/" . $event->getId());
            } elseif ($from === 'lieu' && $video->getIdLieu()) {
                Trail::getInstance()
                    ->addStep("Lieux", "/lieux")
                    ->addStep($lieu->getName(), "/lieux/" . $lieu->getId());
            } else {
                Trail::getInstance()
                    ->addStep("Média", "/medias");
            }
            Trail::getInstance()
                ->addStep($video->getName());

            // vidéos et photos liées à l'événement/lieu
            if ($video->getIdEvent() && $video->getIdLieu()) {
                $smarty->assign(
                    'photos',
                    Photo::find(
                        [
                            'id_event' => $video->getIdEvent(),
                            'online' => true,
                            'order_by' => 'random',
                            'limit' => 30,
                        ]
                    )
                );
                $smarty->assign(
                    'videos',
                    Video::find(
                        [
                            'id__not_in' => [$video->getIdVideo()],
                            'id_event' => $video->getIdEvent(),
                            'online' => true,
                            'order_by' => 'random',
                            'limit' => 30,
                        ]
                    )
                );
            }

            $smarty->assign('description', $meta_description);
        } else {
            $smarty->assign('unknown_video', true);
        }

        return $smarty->fetch('videos/show.tpl');
    }

    /**
     * Code player embarqué
     *
     * @return string
     */
    public static function embed(): string
    {
        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        try {
            $video = Video::getInstance($id);
        } catch (Exception $e) {
            Route::set_http_code(404);
            $smarty->assign('unknown_video', true);
            return $smarty->fetch('videos/embed.tpl');
        }

        if ($video->getOnline()) {
            $smarty->assign('video', $video);
        } else {
            $smarty->assign('unknown_video', true);
        }

        return $smarty->fetch('videos/embed.tpl');
    }

    /**
     * Ajout d'une vidéo
     *
     * @return string
     */
    public static function create(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $smarty = new AdHocSmarty();

        $smarty->assign('robots', 'noindex,nofollow');

        $smarty->enqueue_script('/js/videos/create.js');

        if (Tools::isSubmit('form-video-create')) {
            $data = [
                'name' => (string) Route::params('name'),
                'id_groupe' => Route::params('id_groupe') ? (int) Route::params('id_groupe') : null,
                'id_lieu' => Route::params('id_lieu') ? (int) Route::params('id_lieu') : null,
                'id_event' => Route::params('id_event') ? (int) Route::params('id_event') : null,
                'id_contact' => $_SESSION['membre']->getId(),
                'online' => (bool) Route::params('online'),
                'code' => (string) Route::params('code'),
                'reference' => (string) Route::params('reference'),
            ];

            $errors = [];

            if (self::validateVideoCreateForm($data, $errors)) {
                $info = Video::parseStringForVideoUrl($data['code']);
                $data['id_host'] = $info['id_host'];
                $data['reference'] = $info['reference'];

                $video = (new Video())
                    ->setName($data['name'])
                    ->setIdGroupe($data['id_groupe']) // deprecated
                    ->setIdLieu($data['id_lieu'])
                    ->setIdEvent($data['id_event'])
                    ->setIdContact($data['id_contact'])
                    ->setOnline($data['online'])
                    ->setIdHost($data['id_host'])
                    ->setReference($data['reference']);

                $video->save();

                foreach (Route::params('ids_groupe') as $id_groupe) {
                    $id_groupe = (int) $id_groupe;
                    if ($id_groupe) {
                        $video->linkGroupe((int) $id_groupe);
                    }
                }

                // création du répertoire de stockage si inexistant
                if (!is_dir(Video::getBasePath())) {
                    mkdir(Video::getBasePath(), 0755, true);
                }

                // récupération de la vignette distante
                if ($vignette = Video::getRemoteThumbnail($video->getIdHost(), $video->getReference())) {
                    $video->storeThumbnail($vignette);
                }

                $confVideo = Conf::getInstance()->get('video');
                foreach ($confVideo['thumb_width'] as $maxWidth) {
                    $video->genThumb($maxWidth);
                }

                Log::action(Log::ACTION_VIDEO_CREATE, $video->getId());

                Tools::redirect('/videos/my');
            } else {
                foreach ($errors as $k => $v) {
                    $smarty->assign('error_' . $k, $v);
                }
            }
        }

        Trail::getInstance()
            ->addStep('Tableau de bord', '/membres/tableau-de-bord')
            ->addStep('Mes vidéos', '/videos/my')
            ->addStep('Ajouter une vidéo');

        // préselection d'un groupe
        $id_groupe = (int) Route::params('id_groupe');
        $smarty->assign('id_groupe', $id_groupe);

        $smarty->assign(
            'groupes',
            Groupe::find(
                [
                    'online' => true,
                    'order_by' => 'name',
                    'sort' => 'ASC',
                ]
            )
        );

        $id_lieu = (int) Route::params('id_lieu');
        if ($id_lieu) {
            $lieu = Lieu::getInstance($id_lieu);
            $smarty->assign('lieu', $lieu);
            $smarty->assign(
                'events',
                Event::find(
                    [
                        'online' => true,
                        'datfin' => date('Y-m-d H:i:s'),
                        'id_lieu' => $lieu->getIdLieu(),
                        'order_by' => 'date',
                        'sort' => 'ASC',
                        'limit' => 100,
                    ]
                )
            );
        } else {
            $smarty->assign('deps', Departement::findAll());
            $smarty->assign('lieux', Lieu::getLieuxByDep());
        }

        $id_event  = (int) Route::params('id_event');
        if ($id_event) {
            $event = Event::getInstance($id_event);
            $lieu = Lieu::getInstance($event->getIdLieu());
            $smarty->assign('event', $event);
            $smarty->assign('lieu', $lieu);
        }

        return $smarty->fetch('videos/create.tpl');
    }

    /**
     * Édition d'une vidéo
     *
     * @return string
     */
    public static function edit(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $id = (int) Route::params('id');
        $page = (int) Route::params('page');

        $smarty = new AdHocSmarty();

        $smarty->assign('robots', 'noindex,nofollow');

        $smarty->enqueue_script('/js/videos/edit.js');

        try {
            $video = Video::getInstance($id);
        } catch (Exception $e) {
            Route::set_http_code(404);
            $smarty->assign('unknown_video', true);
            return $smarty->fetch('videos/edit.tpl');
        }

        if (Tools::isSubmit('form-video-edit')) {
            $data = [
                'id' => (int) Route::params('id'),
                'name' => (string) Route::params('name'),
                'id_groupe' => Route::params('id_groupe') ? (int) Route::params('id_groupe') : null,
                'id_lieu' => Route::params('id_lieu') ? (int) Route::params('id_lieu') : null,
                'id_event' => Route::params('id_event') ? (int) Route::params('id_event') : null,
                'online' => (bool) Route::params('online'),
                'thumbnail_fetch' => (bool) Route::params('thumbnail_fetch'),
            ];
            $errors = [];

            if (self::validateVideoEditForm($data, $errors)) {
                $video->setName($data['name'])
                    ->setIdLieu($data['id_lieu'])
                    ->setIdEvent($data['id_event'])
                    ->setIdGroupe($data['id_groupe']) // deprecated
                    ->setOnline($data['online']);
                $video->save();

                $video->unlinkGroupes();
                foreach (Route::params('ids_groupe') as $id_groupe) {
                    $id_groupe = (int) $id_groupe;
                    if ($id_groupe) {
                        $video->linkGroupe((int) $id_groupe);
                    }
                }

                if (!is_dir(Video::getBasePath())) {
                    mkdir(Video::getBasePath(), 0755, true);
                }

                // Permet le reset de la vignette
                if ($data['thumbnail_fetch']) {
                    if ($vignette = Video::getRemoteThumbnail($video->getIdHost(), $video->getReference())) {
                        $video->storeThumbnail($vignette);
                        $confVideo = Conf::getInstance()->get('video');
                        foreach ($confVideo['thumb_width'] as $maxWidth) {
                            $video->clearThumb($maxWidth);
                            $video->genThumb($maxWidth);
                        }
                    }
                }

                Log::action(Log::ACTION_VIDEO_EDIT, $video->getId());

                Tools::redirect('/videos/my');
            } else {
                foreach ($errors as $k => $v) {
                    $smarty->assign('error_' . $k, $v);
                }
            }
        }

        Trail::getInstance()
            ->addStep('Tableau de bord', '/membres/tableau-de-bord')
            ->addStep('Mes vidéos', '/videos/my')
            ->addStep('Éditer une vidéo');

        $smarty->assign('video', $video);

        $smarty->assign(
            'groupes',
            Groupe::find(
                [
                    'online' => true,
                    'order_by' => 'name',
                    'sort' => 'ASC',
                ]
            )
        );

        $smarty->assign('deps', Departement::findAll());
        $smarty->assign('lieux', Lieu::getLieuxByDep());

        $smarty->assign('page', $page);

        if ($video->getIdEvent()) {
            $event = Event::getInstance($video->getIdEvent());
            $lieu = Lieu::getInstance($event->getIdLieu());
            $smarty->assign('event', $event);
            $smarty->assign('lieu', $lieu);
        } elseif ($video->getIdLieu()) {
            $lieu = Lieu::getInstance($video->getIdLieu());
            $smarty->assign('lieu', $lieu);
        }

        return $smarty->fetch('videos/edit.tpl');
    }

    /**
     * Suppression d'une vidéo
     *
     * @return string
     */
    public static function delete(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        $smarty->assign('robots', 'noindex,nofollow');

        $smarty->enqueue_script('/js/videos/delete.js');

        Trail::getInstance()
            ->addStep('Tableau de bord', '/membres/tableau-de-bord')
            ->addStep('Mes vidéos', '/videos/my')
            ->addStep('Supprimer une vidéo');

        try {
            $video = Video::getInstance($id);
        } catch (Exception $e) {
            Route::set_http_code(404);
            $smarty->assign('unknown_video', true);
            return $smarty->fetch('videos/delete.tpl');
        }

        if (Tools::isSubmit('form-video-delete')) {
            if ($video->delete()) {
                Log::action(Log::ACTION_VIDEO_DELETE, $video->getId());
                Tools::redirect('/videos/my');
            }
        }

        $smarty->assign('video', $video);

        if ($video->getGroupes()) {
            $smarty->assign('groupe', $video->getGroupes()[0]);
        }
        if ($video->getIdEvent()) {
            $smarty->assign('event', Event::getInstance($video->getIdEvent()));
        }
        if ($video->getIdLieu()) {
            $smarty->assign('lieu', Lieu::getInstance($video->getIdLieu()));
        }

        return $smarty->fetch('videos/delete.tpl');
    }

    /**
     * Récupère des infos sur une vidéo
     *
     * @return array
     */
    public static function getMeta(): array
    {
        $code = (string) Route::params('code');

        if ($info = Video::parseStringForVideoUrl($code)) {
            $out = [
                'status' => 'OK',
                'data' => $info,
            ];
            $out['data']['thumb'] = Video::getRemoteThumbnail($out['data']['id_host'], $out['data']['reference']);
            $out['data']['title'] = Video::getRemoteTitle($out['data']['id_host'], $out['data']['reference']);
        } else {
            $out = [
                'status' => 'KO',
            ];
        }

        return $out;
    }

    /**
     * Validation du formulaire de modification vidéo
     *
     * @param array $data   tableau des données
     * @param array $errors tableau des erreurs (par référence)
     *
     * @return bool
     */
    private static function validateVideoCreateForm(array $data, array &$errors): bool
    {
        if (empty($data['name'])) {
            $errors['name'] = "Vous devez saisir un titre pour la vidéo.";
        }
        if (empty($data['code'])) {
            $errors['code'] = "Vous devez copier/coller l'url de la vidéo";
        } elseif (Video::parseStringForVideoUrl($data['code']) === false) {
            $errors['unknown_host'] = "Url de la vidéo non reconnue";
        }
        if (count($errors)) {
            return false;
        }
        return true;
    }

    /**
     * Validation du formulaire de modification vidéo
     *
     * @param array $data   tableau des données
     * @param array $errors tableau des erreurs (par référence)
     *
     * @return bool
     */
    private static function validateVideoEditForm(array $data, array &$errors): bool
    {
        if (empty($data['name'])) {
            $errors['name'] = "Vous devez saisir un titre pour la vidéo.";
        }
        if (count($errors)) {
            return false;
        }
        return true;
    }
}
