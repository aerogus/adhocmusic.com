<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\AdHocSmarty;
use Adhoc\Model\Date;
use Adhoc\Model\Groupe;
use Adhoc\Model\Lieu;
use Adhoc\Model\Membre;
use Adhoc\Model\Photo;
use Adhoc\Model\Reference\Departement;
use Adhoc\Model\Route;
use Adhoc\Model\Tools;
use Adhoc\Model\Trail;

define('NB_PHOTOS_PER_PAGE', 48);

/**
 *
 */
final class Controller
{
    /**
     * @return string
     */
    public static function my(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        Trail::getInstance()
            ->addStep('Tableau de bord', '/membres/tableau-de-bord')
            ->addStep('Mes photos');

        $smarty = new AdHocSmarty();

        $smarty->enqueueScript('/js/masonry-4.2.2.min.js');
        $smarty->enqueueScript('/js/imagesloaded-4.1.4.min.js');
        $smarty->enqueueScript('/js/photos/my.js');

        $page = (int) Route::params('page');

        $smarty->assign('create', (bool) Route::params('create'));
        $smarty->assign('edit', (bool) Route::params('edit'));
        $smarty->assign('delete', (bool) Route::params('delete'));

        $photos = Photo::find(
            [
                'id_contact' => $_SESSION['membre']->getIdContact(),
                'order_by' => 'id_photo',
                'sort' => 'ASC',
                'start' => $page * NB_PHOTOS_PER_PAGE,
                'limit' => NB_PHOTOS_PER_PAGE,
            ]
        );
        $nb_photos = Photo::countMy();

        $smarty->assign('photos', $photos);

        $smarty->assign('nb_items', $nb_photos);
        $smarty->assign('nb_items_per_page', NB_PHOTOS_PER_PAGE);
        $smarty->assign('page', $page);

        return $smarty->fetch('photos/my.tpl');
    }

    /**
     * @return string
     */
    public static function show(): string
    {
        $id = (int) Route::params('id');
        $from = (string) Route::params('from');

        $smarty = new AdHocSmarty();

        try {
            $photo = Photo::getInstance($id);
        } catch (\Exception $e) {
            Route::setHttpCode(404);
            $smarty->assign('unknown_photo', true);
            return $smarty->fetch('photos/show.tpl');
        }

        $meta_title = '';
        $meta_description = "Titre : " . $photo->getName();

        if ($photo->getOnline() || (!$photo->getOnline() && Tools::isAuth() && Tools::auth(Membre::TYPE_INTERNE))) {
            $smarty->assign('photo', $photo);
            $smarty->assign('from', $from);
            $smarty->assign('og_image', $photo->getThumbUrl(320));
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
                $meta_title .= " - " . $event->getName() . " (" . Date::mysqlDatetime($event->getDate(), "d/m/Y") . ")";
                $meta_description .= " | Evénement : " . $event->getName() . " (" . Date::mysqlDatetime($event->getDate(), "d/m/Y") . ")";
            }
            if ($photo->getIdLieu()) {
                $lieu = Lieu::getInstance($photo->getIdLieu());
                $smarty->assign('lieu', $lieu);
                $meta_title .= " - " . $lieu->getName();
                $meta_description .= " | Lieu : " . $lieu->getName() . " (" . $lieu->getIdDepartement() . " - " . $lieu->getCity()->getName() . ")";
            }
            if ($photo->getIdContact()) {
                try {
                    $membre = Membre::getInstance($photo->getIdContact());
                    $smarty->assign('membre', $membre);
                } catch (\Exception $e) {
                    mail(DEBUG_EMAIL, "[AD'HOC] Bug : photo avec membre introuvable", print_r($e, true));
                }
            }

            $trail = Trail::getInstance();
            if ($from === 'groupe' && $photo->getIdGroupe()) {
                $trail->addStep("Groupes", "/groupes")
                    ->addStep($groupe->getName(), $groupe->getUrl());
            } elseif ($from === 'profil' && $photo->getIdContact()) {
                $trail->addStep("Zone Membre", "/membres");
            } elseif ($from === 'event' && $photo->getIdEvent()) {
                $trail->addStep("Agenda", "/events")
                    ->addStep($event->getName(), $event->getUrl());
            } elseif ($from === 'lieu' && $photo->getIdLieu()) {
                $trail->addStep("Lieux", "/lieux")
                    ->addStep($lieu->getName(), $lieu->getUrl());
            } else {
                $trail->addStep("Média", "/medias");
            }
            $trail->addStep($photo->getName());

            // photo issu d'un album live ?
            if ($photo->getIdEvent() && $photo->getIdLieu()) {
                $playlist = Photo::find(
                    [
                        'online' => true,
                        'id_event' => $photo->getIdEvent(),
                        'id_lieu' => $photo->getIdLieu(),
                        'order_by' => 'id_photo',
                        'sort' => 'ASC',
                        'limit' => 200,
                    ]
                );

                // calcul photo suivante/précente
                $idx = 0;
                $count = count($playlist);
                foreach ($playlist as $_idx => $_playlist) {
                    if ($_playlist->getIdPhoto() === $photo->getIdPhoto()) {
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
                $smarty->assign('next', $playlist[$next]->getUrl());
                $smarty->assign('prev', $playlist[$prev]->getUrl());

                $smarty->assign('idx_photo', $idx_photo + 1);
                $smarty->assign('nb_photos', $count);
                $meta_title .= ' - ' . ($idx_photo + 1) . '/' . $count;
                $smarty->assign('playlist', $playlist);
            }

            $smarty->assign('title', $meta_title);
            $smarty->assign('description', $meta_description);

            $smarty->assign(
                'comments',
                Comment::find(
                    [
                        'id_type' => 'p',
                        'id_content' => $photo->getIdPhoto(),
                        'online' => true,
                        'order_by' => 'created_at',
                        'sort' => 'ASC',
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
    public static function create(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        if (Tools::isSubmit('form-photo-create')) {
            $data = [
                'name' => trim((string) Route::params('name')),
                'credits' => trim((string) Route::params('credits')),
                'id_groupe' => Route::params('id_groupe') ? (int) Route::params('id_groupe') : null,
                'id_lieu' => Route::params('id_lieu') ? (int) Route::params('id_lieu') : null,
                'id_event' => Route::params('id_event') ? (int) Route::params('id_event') : null,
                'id_contact' => (int) $_SESSION['membre']->getId(),
                'online' => (bool) Route::params('online'),
            ];
            $errors = [];

            if (self::validatePhotoForm($data, $errors)) {
                // cf. max_file_uploads (par défaut 20, les fichiers suivants sont ignorés)
                ini_set('max_file_uploads', '50');

                // 10min max (le calcul de resize est long)
                ini_set('max_execution_time', '600');

                foreach ($_FILES['file']['tmp_name'] as $uploaded_photo_path) {
                    if (is_uploaded_file($uploaded_photo_path)) {
                        $photo = (new Photo())
                            ->setName($data['name'])
                            ->setCredits($data['credits'])
                            ->setIdGroupe($data['id_groupe'])
                            ->setIdLieu($data['id_lieu'])
                            ->setIdEvent($data['id_event'])
                            ->setIdContact($data['id_contact'])
                            ->setOnline($data['online']);

                        if ($photo->save()) {
                            // création du répertoire de stockage si inexistant
                            if (!is_dir(Photo::getBasePath())) {
                                mkdir(Photo::getBasePath(), 0755, true);
                            }

                            // extrait l'EXIF source et applique une éventuelle rotation
                            Photo::fixOrientation($uploaded_photo_path);

                            // le resize HD peut-être long
                            // l'EXIF n'est pas conservé
                            $confPhoto = Conf::getInstance()->get('photo');
                            (new Image($uploaded_photo_path))
                                ->setType(IMAGETYPE_JPEG)
                                ->setMaxWidth($confPhoto['max_width'])
                                ->setMaxHeight($confPhoto['max_height'])
                                ->setDestFile(Photo::getBasePath() . '/' . $photo->getIdPhoto() . '.jpg')
                                ->write();
                            Log::action(Log::ACTION_PHOTO_CREATE, $photo->getIdPhoto());

                            // les générations des thumbs à faire en asynchrone
                            foreach ($confPhoto['thumb_width'] as $maxWidth) {
                                $photo->genThumb($maxWidth);
                            }
                        }
                    }
                }
                Tools::redirect('/photos/my');
            } else {
                $errors['generic'] = true;
            }
        }

        Trail::getInstance()
            ->addStep('Tableau de bord', '/membres/tableau-de-bord')
            ->addStep('Mes photos', '/photos/my')
            ->addStep('Ajouter une photo');

        $smarty = new AdHocSmarty();

        $smarty->assign('robots', 'noindex,nofollow');

        $smarty->enqueueScript('/js/photos/create.js');

        $id_groupe = (int) Route::params('id_groupe');
        if ($id_groupe) {
            $groupe = Groupe::getInstance($id_groupe);
            $smarty->assign('groupe', $groupe);
        } else {
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
        }

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
    public static function edit(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        $smarty->assign('robots', 'noindex,nofollow');

        $smarty->enqueueScript('/js/photos/edit.js');

        Trail::getInstance()
            ->addStep('Tableau de bord', '/membres/tableau-de-bord')
            ->addStep('Mes photos', '/photos/my')
            ->addStep('Éditer une photo');

        try {
            $photo = Photo::getInstance($id);
        } catch (\Exception $e) {
            Route::setHttpCode(404);
            $smarty->assign('unknown_photo', true);
            return $smarty->fetch('photos/edit.tpl');
        }

        if (Tools::isSubmit('form-photo-edit')) {
            $data = [
                'id' => (int) $photo->getId(),
                'name' => (string) Route::params('name'),
                'credits' => (string) Route::params('credits'),
                'id_groupe' => Route::params('id_groupe') ? (int) Route::params('id_groupe') : null,
                'id_lieu' => Route::params('id_lieu') ? (int) Route::params('id_lieu') : null,
                'id_event' => Route::params('id_event') ? (int) Route::params('id_event') : null,
                'id_contact' => (int) Route::params('id_contact'),
                'online' => (bool) Route::params('online'),
                'rotation' => (int) Route::params('rotation')
            ];
            $errors = [];

            if (self::validatePhotoForm($data, $errors)) {
                $confPhoto = Conf::getInstance()->get('photo');

                $photo->setName($data['name'])
                    ->setCredits($data['credits'])
                    ->setIdGroupe($data['id_groupe'])
                    ->setIdLieu($data['id_lieu'])
                    ->setIdEvent($data['id_event'])
                    ->setOnline($data['online']);

                // applique une rotation forcée et regénère les miniatures
                if ($data['rotation']) {
                    Photo::rotate(Photo::getBasePath() . '/' . $photo->getIdPhoto() . '.jpg', $data['rotation']);
                    foreach ($confPhoto['thumb_width'] as $maxWidth) {
                        $photo->clearThumb($maxWidth);
                        $photo->genThumb($maxWidth);
                    }
                }

                if ($photo->save()) {
                    Log::action(Log::ACTION_PHOTO_EDIT, $photo->getId());
                    Tools::redirect('/photos/my');
                }
            } else {
                $errors['generic'] = true;
            }
        }

        $smarty->assign('photo', $photo);

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
    public static function delete(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        $smarty->assign('robots', 'noindex,nofollow');

        $smarty->enqueueScript('/js/photos/delete.js');

        Trail::getInstance()
            ->addStep('Tableau de bord', '/membres/tableau-de-bord')
            ->addStep('Mes photos', '/photos/my')
            ->addStep('Supprimer une photo');

        try {
            $photo = Photo::getInstance($id);
        } catch (\Exception $e) {
            Route::setHttpCode(404);
            $smarty->assign('unknown_photo', true);
            return $smarty->fetch('photos/delete.tpl');
        }

        if (Tools::isSubmit('form-photo-delete')) {
            if ($photo->delete()) {
                Log::action(Log::ACTION_PHOTO_DELETE, $photo->getId());
                Tools::redirect('/photos/my');
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
    private static function validatePhotoForm(array $data, array &$errors): bool
    {
        if (empty($data['name'])) {
            $errors['name'] = "Vous devez saisir un titre pour la photo.";
        }
        if (empty($data['credits'])) {
            $errors['credits'] = "Vous devez saisir le nom du ou de la photographe";
        }
        if (count($errors)) {
            return false;
        }
        return true;
    }
}
