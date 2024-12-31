<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\Groupe;
use Adhoc\Model\Event;
use Adhoc\Model\Lieu;
use Adhoc\Model\Membre;
use Adhoc\Model\Photo;
use Adhoc\Model\Video;
use Adhoc\Utils\AdHocTwig;
use Adhoc\Utils\Conf;
use Adhoc\Utils\Date;
use Adhoc\Utils\Log;
use Adhoc\Utils\Route;
use Adhoc\Utils\Tools;
use Adhoc\Model\Departement;

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

        $twig = new AdHocTwig();

        $twig->assign('breadcrumb', [
            ['title' => '🏠', 'link' => '/'],
            ['title' => 'Tableau de bord', 'link' => '/membres/tableau-de-bord'],
            'Mes vidéos',
        ]);

        $page = (int) Route::params('page');

        if ($_SESSION['membre']->getIdContact() === 1) {
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
                    'id_contact' => $_SESSION['membre']->getIdContact(),
                    'order_by' => 'id_video',
                    'sort' => 'ASC',
                    'start' => $page * NB_VIDEOS_PER_PAGE,
                    'limit' => NB_VIDEOS_PER_PAGE,
                ]
            );
            $nb_videos = Video::countMy();
        }

        $twig->assign('robots', 'noindex,nofollow');

        $twig->enqueueScript('/static/library/masonry@4.2.2/masonry.min.js');
        $twig->enqueueScript('/static/library/imagesloaded@4.1.4/imagesloaded.min.js');
        $twig->enqueueScript('/static/library/baguetteBox@1.11.1/baguetteBox.min.js');

        $twig->enqueueScript('/js/videos/my.js');

        // pagination
        $twig->assign('nb_items', $nb_videos);
        $twig->assign('nb_items_per_page', NB_VIDEOS_PER_PAGE);
        $twig->assign('page', $page);

        $twig->assign('videos', $videos);

        return $twig->render('videos/my.twig');
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

        $twig = new AdHocTwig();

        $breadcrumb = [
            ['title' => '🏠', 'link' => '/'],
        ];

        $twig->enqueueStyle('/static/library/baguetteBox@1.11.1/baguetteBox.min.css');

        $twig->enqueueScript('/static/library/masonry@4.2.2/masonry.min.js');
        $twig->enqueueScript('/static/library/imagesloaded@4.1.4/imagesloaded.min.js');
        $twig->enqueueScript('/static/library/baguetteBox@1.11.1/baguetteBox.min.js');

        $twig->enqueueScript('/js/videos/show.js');

        try {
            $video = Video::getInstance($id);
        } catch (\Exception $e) {
            Route::setHttpCode(404);
            $twig->assign('unknown_video', true);
            return $twig->render('videos/show.twig');
        }

        $meta_description = "Titre : " . $video->getName();

        if ($video->getOnline()) {
            $twig->assign('video', $video);
            $twig->assign('from', $from);
            $twig->assign('title', "♫ " . $video->getName());
            $twig->assign('description', $video->getName());
            $twig->assign('og_image', MEDIA_URL . '/video/' . $video->getIdVideo() . '.jpg');
            $twig->assign('og_type', 'video.movie');

            // @see https://developers.facebook.com/docs/sharing/webmasters?locale=fr_FR
            // mais la preview live ne marche pas/plus sur FB...
            $og_video = [
                'url' => $video->getDirectMp4Url(),
                'secure_url' => $video->getDirectMp4Url(),
                'type' => 'video/mp4',
                'width' => 1280, // fake
                'height' => 720, // fake
            ];
            $twig->assign('og_video', $og_video);

            if (count($video->getGroupes()) > 0) {
                $groupe = Groupe::getInstance($video->getGroupes()[0]->getIdGroupe());
                $twig->assign('groupe', $groupe);
                $twig->assign('title', "♫ " . $video->getName() . " (" . $groupe->getName() . ")");
                $meta_description .= " | Groupe : " . $groupe->getName();
            }
            if (!is_null($video->getIdEvent())) {
                $event = Event::getInstance($video->getIdEvent());
                $twig->assign('event', $event);
                $meta_description .= " | Evénement : " . $event->getName() . " (" . Date::mysqlDatetime($event->getDate(), "d/m/Y") . ")";
            }
            if (!is_null($video->getIdLieu())) {
                $lieu = Lieu::getInstance($video->getIdLieu());
                $twig->assign('lieu', $lieu);
                $meta_description .= " | Lieu : " . $lieu->getName() . " (" . $lieu->getIdDepartement() . " - " . $lieu->getCity()->getName() . ")";
            }
            if (!is_null($video->getIdContact())) {
                $membre = Membre::getInstance($video->getIdContact());
                $twig->assign('membre', $membre);
            }

            // menu et fil d'ariane
            if ($from === 'groupe' && count($video->getGroupes()) > 0) {
                $breadcrumb[] = ['title' => 'Groupes', 'link' => '/groupes'];
                $breadcrumb[] = ['title' => $groupe->getName(), 'link' => $groupe->getUrl()];
            } elseif ($from === 'profil' && !is_null($video->getIdContact())) {
                $breadcrumb[] = ['title' => 'Zone membre', 'link' => '/membres'];
            } elseif ($from === 'event' && isset($event)) {
                $breadcrumb[] = ['title' => 'Agenda', 'link' => '/events'];
                $breadcrumb[] = ['title' => $event->getName(), 'link' => "/events/" . $event->getIdEvent()];
            } elseif ($from === 'lieu' && !is_null($video->getIdLieu())) {
                $breadcrumb[] = ['title' => 'Lieux', 'link' => '/lieux'];
                $breadcrumb[] = ['title' => $lieu->getName(), 'link' => "/lieux/" . $lieu->getIdLieu()];
            } else {
                $breadcrumb[] = ['title' => 'Média', 'link' => '/medias'];
            }
            $breadcrumb[] = $video->getName();

            // vidéos et photos liées à l'événement/lieu
            if (!is_null($video->getIdEvent()) && !is_null($video->getIdLieu())) {
                $twig->assign(
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
                $twig->assign(
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

            $twig->assign('description', $meta_description);
        } else {
            $twig->assign('unknown_video', true);
        }

        $twig->assign('breadcrumb', $breadcrumb);

        return $twig->render('videos/show.twig');
    }

    /**
     * Code player embarqué
     *
     * @return string
     */
    public static function embed(): string
    {
        $id = (int) Route::params('id');

        $twig = new AdHocTwig();

        try {
            $video = Video::getInstance($id);
        } catch (\Exception $e) {
            Route::setHttpCode(404);
            $twig->assign('unknown_video', true);
            return $twig->render('videos/embed.twig');
        }

        if ($video->getOnline()) {
            $twig->assign('video', $video);
        } else {
            $twig->assign('unknown_video', true);
        }

        return $twig->render('videos/embed.twig');
    }

    /**
     * Ajout d'une vidéo
     *
     * @return string
     */
    public static function create(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $twig = new AdHocTwig();

        $twig->assign('robots', 'noindex,nofollow');

        $twig->enqueueScript('/js/videos/create.js');

        if (Tools::isSubmit('form-video-create')) {
            $data = [
                'name' => (string) Route::params('name'),
                'id_groupe' => boolval(Route::params('id_groupe')) ? (int) Route::params('id_groupe') : null,
                'id_lieu' => boolval(Route::params('id_lieu')) ? (int) Route::params('id_lieu') : null,
                'id_event' => boolval(Route::params('id_event')) ? (int) Route::params('id_event') : null,
                'id_contact' => $_SESSION['membre']->getIdContact(),
                'online' => (bool) Route::params('online'),
                'code' => (string) Route::params('code'),
                'reference' => (string) Route::params('reference'),
            ];

            $errors = self::validateVideoCreateForm($data);
            if (count($errors) === 0) {
                $info = Video::parseStringForVideoUrl($data['code']);
                $data['id_host'] = (int) $info['id_host'];
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
                    if (intval($id_groupe) > 0) {
                        $video->linkGroupe(intval($id_groupe));
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

                Log::info("Video create " . $video->getIdVideo());

                Tools::redirect('/videos/my');
            } else {
                foreach ($errors as $k => $v) {
                    $twig->assign('error_' . $k, $v);
                }
            }
        }

        $twig->assign('breadcrumb', [
            ['title' => '🏠', 'link' => '/'],
            ['title' => 'Tableau de bord', 'link' => '/membres/tableau-de-bord'],
            ['title' => 'Mes vidéos', 'link' => '/videos/my'],
            'Ajouter une vidéo',
        ]);

        // préselection d'un groupe
        $id_groupe = (int) Route::params('id_groupe');
        $twig->assign('id_groupe', $id_groupe);

        $twig->assign(
            'groupes',
            Groupe::find(
                [
                    'online' => true,
                    'order_by' => 'name',
                    'sort' => 'ASC',
                ]
            )
        );

        if (intval(Route::params('id_lieu')) > 0) {
            $lieu = Lieu::getInstance(intval(Route::params('id_lieu')));
            $twig->assign('lieu', $lieu);
            $twig->assign(
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
            $twig->assign('deps', Departement::findAll());
            $twig->assign('lieux', Lieu::getLieuxByDep());
        }

        $id_event  = (bool) Route::params('id_event') ? (int) Route::params('id_event') : null;
        if (!is_null($id_event)) {
            $event = Event::getInstance($id_event);
            $lieu = Lieu::getInstance($event->getIdLieu());
            $twig->assign('event', $event);
            $twig->assign('lieu', $lieu);
        }

        return $twig->render('videos/create.twig');
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

        $twig = new AdHocTwig();

        $twig->assign('robots', 'noindex,nofollow');

        $twig->enqueueScript('/js/videos/edit.js');

        try {
            $video = Video::getInstance($id);
        } catch (\Exception $e) {
            Route::setHttpCode(404);
            $twig->assign('unknown_video', true);
            return $twig->render('videos/edit.twig');
        }

        if (Tools::isSubmit('form-video-edit')) {
            $data = [
                'id' => (int) Route::params('id'),
                'name' => (string) Route::params('name'),
                'id_groupe' => (bool) Route::params('id_groupe') ? (int) Route::params('id_groupe') : null,
                'id_lieu' => (bool) Route::params('id_lieu') ? (int) Route::params('id_lieu') : null,
                'id_event' => (bool) Route::params('id_event') ? (int) Route::params('id_event') : null,
                'online' => (bool) Route::params('online'),
                'thumbnail_fetch' => (bool) Route::params('thumbnail_fetch'),
            ];

            $errors = self::validateVideoEditForm($data);
            if (count($errors) === 0) {
                $video->setName($data['name'])
                    ->setIdLieu($data['id_lieu'])
                    ->setIdEvent($data['id_event'])
                    ->setIdGroupe($data['id_groupe']) // deprecated
                    ->setOnline($data['online']);
                $video->save();

                $video->unlinkGroupes();
                foreach (Route::params('ids_groupe') as $id_groupe) {
                    if (intval($id_groupe) > 0) {
                        $video->linkGroupe(intval($id_groupe));
                    }
                }

                if (!is_dir(Video::getBasePath())) {
                    mkdir(Video::getBasePath(), 0755, true);
                }

                // Permet le reset de la vignette
                if ($data['thumbnail_fetch']) {
                    if (($vignette = Video::getRemoteThumbnail($video->getIdHost(), $video->getReference())) !== false) {
                        $video->storeThumbnail($vignette);
                        $confVideo = Conf::getInstance()->get('video');
                        foreach ($confVideo['thumb_width'] as $maxWidth) {
                            $video->clearThumb($maxWidth);
                            $video->genThumb($maxWidth);
                        }
                    }
                }

                Log::info("Video edit " . $video->getIdVideo());

                Tools::redirect('/videos/my');
            } else {
                foreach ($errors as $k => $v) {
                    $twig->assign('error_' . $k, $v);
                }
            }
        }

        $twig->assign('breadcrumb', [
            ['title' => '🏠', 'link' => '/'],
            ['title' => 'Tableau de bord', 'link' => '/membres/tableau-de-bord'],
            ['title' => 'Mes vidéos', 'link' => '/videos/my'],
            ['Éditer une vidéo'],
        ]);

        $twig->assign('video', $video);

        $twig->assign(
            'groupes',
            Groupe::find(
                [
                    'online' => true,
                    'order_by' => 'name',
                    'sort' => 'ASC',
                ]
            )
        );

        $twig->assign('deps', Departement::findAll());
        $twig->assign('lieux', Lieu::getLieuxByDep());

        $twig->assign('page', $page);

        if (!is_null($video->getIdEvent())) {
            $event = Event::getInstance($video->getIdEvent());
            $lieu = Lieu::getInstance($event->getIdLieu());
            $twig->assign('event', $event);
            $twig->assign('lieu', $lieu);
        } elseif (!is_null($video->getIdLieu())) {
            $lieu = Lieu::getInstance($video->getIdLieu());
            $twig->assign('lieu', $lieu);
        }

        return $twig->render('videos/edit.twig');
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

        $twig = new AdHocTwig();

        $twig->assign('robots', 'noindex,nofollow');

        $twig->enqueueScript('/js/videos/delete.js');

        $twig->assign('breadcrumb', [
            ['title' => '🏠', 'link' => '/'],
            ['title' => 'Tableau de bord', 'link' => '/membres/tableau-de-bord'],
            ['title' => 'Mes vidéos', 'link' => '/videos/my'],
            ['Supprimer une vidéo'],
        ]);

        try {
            $video = Video::getInstance($id);
        } catch (\Exception $e) {
            Route::setHttpCode(404);
            $twig->assign('unknown_video', true);
            return $twig->render('videos/delete.twig');
        }

        if (Tools::isSubmit('form-video-delete')) {
            if ($video->delete()) {
                Log::info("Video delete " . $video->getIdVideo());
                Tools::redirect('/videos/my');
            }
        }

        $twig->assign('video', $video);

        if (count($video->getGroupes()) > 0) {
            $twig->assign('groupe', $video->getGroupes()[0]);
        }
        if (!is_null($video->getIdEvent())) {
            $twig->assign('event', Event::getInstance($video->getIdEvent()));
        }
        if (!is_null($video->getIdLieu())) {
            $twig->assign('lieu', Lieu::getInstance($video->getIdLieu()));
        }

        return $twig->render('videos/delete.twig');
    }

    /**
     * Récupère des infos sur une vidéo
     *
     * @return array<string,mixed>
     */
    public static function getMeta(): array
    {
        $code = (string) Route::params('code');

        if ($info = Video::parseStringForVideoUrl($code)) {
            $out = [
                'status' => 'OK',
                'data' => $info,
            ];
            $out['data']['thumb'] = Video::getRemoteThumbnail((int) $out['data']['id_host'], $out['data']['reference']);
            $out['data']['title'] = Video::getRemoteTitle((int) $out['data']['id_host'], $out['data']['reference']);
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
     * @param array<string,mixed> $data tableau des données
     *
     * @return array<string,string>
     */
    private static function validateVideoCreateForm(array $data): array
    {
        $errors = [];

        if (!isset($data['name'])) {
            $errors['name'] = "Vous devez saisir un titre pour la vidéo.";
        } elseif (strlen($data['name']) === 0) {
            $errors['name'] = "Vous devez saisir un titre pour la vidéo.";
        }

        if (!isset($data['code'])) {
            $errors['code'] = "Vous devez copier/coller l'url de la vidéo";
        } elseif (strlen($data['code']) === 0) {
            $errors['code'] = "Vous devez copier/coller l'url de la vidéo";
        } elseif (Video::parseStringForVideoUrl($data['code']) === false) {
            $errors['unknown_host'] = "Url de la vidéo non reconnue";
        }

        return $errors;
    }

    /**
     * Validation du formulaire de modification vidéo
     *
     * @param array<string,mixed> $data tableau des données
     *
     * @return array<string,string>
     */
    private static function validateVideoEditForm(array $data): array
    {
        $errors = [];

        if (!isset($data['name'])) {
            $errors['name'] = "Vous devez saisir un titre pour la vidéo.";
        } elseif (strlen($data['name']) === 0) {
            $errors['name'] = "Vous devez saisir un titre pour la vidéo.";
        }

        return $errors;
    }
}
