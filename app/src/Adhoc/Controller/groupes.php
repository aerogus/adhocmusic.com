<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\Audio;
use Adhoc\Model\Event;
use Adhoc\Model\Groupe;
use Adhoc\Model\Membre;
use Adhoc\Model\Photo;
use Adhoc\Model\Reference\TypeMusicien;
use Adhoc\Model\Video;
use Adhoc\Utils\AdHocTwig;
use Adhoc\Utils\Image;
use Adhoc\Utils\Log;
use Adhoc\Utils\Route;
use Adhoc\Utils\Tools;
use Adhoc\Utils\Trail;

define('GROUPE_MINI_PHOTO_SIZE', 128);

final class Controller
{
    /**
     * Listing des groupes
     *
     * @return string
     */
    public static function index(): string
    {
        $twig = new AdHocTwig();

        $twig->assign('title', "♫ Les groupes de la communauté musicale AD'HOC");
        $twig->assign('description', "Association oeuvrant pour le développement de la vie musicale en Essonne");

        Trail::getInstance()
            ->addStep("Groupes");

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

        return $twig->render('groupes/index.twig');
    }

    /**
     * @return string
     */
    public static function my(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $twig = new AdHocTwig();

        $twig->assign('title', "AD'HOC Music : Les Musiques actuelles en Essonne");
        $twig->assign('description', "Association oeuvrant pour le développement de la vie musicale en Essonne");

        Trail::getInstance()
            ->addStep('Tableau de bord', '/membres/tableau-de-bord')
            ->addStep('Mes groupes');

        $twig->assign('delete', (bool) Route::params('delete'));

        $twig->assign(
            'groupes',
            Groupe::find(
                ['id_contact' => $_SESSION['membre']->getId()]
            )
        );

        return $twig->render('groupes/my.twig');
    }

    /**
     * @return string
     */
    public static function show(): string
    {
        $id = (int) Route::params('id');

        $twig = new AdHocTwig();

        $twig->enqueueStyle('/css/baguetteBox-1.11.1.min.css');

        $twig->enqueueScript('/js/masonry-4.2.2.min.js');
        $twig->enqueueScript('/js/imagesloaded-4.1.4.min.js');
        $twig->enqueueScript('/js/baguetteBox-1.11.1.min.js');

        $twig->enqueueScript('/js/groupes/show.js');

        try {
            $groupe = Groupe::getInstance($id);
            if (!$groupe->getOnline()) {
                throw new \Exception('groupe offline');
            }
        } catch (\Exception $e) {
            Route::setHttpCode(404);
            $twig->assign('unknown_group', true);
            return $twig->render('groupes/show.twig');
        }

        $twig->assign('groupe', $groupe);
        $twig->assign('membres', $groupe->getMembers());

        Trail::getInstance()
            ->addStep("Groupes", "/groupes")
            ->addStep($groupe->getName());

        $twig->assign('title', '♫ ' . $groupe->getName() . ' (' . $groupe->getStyle() . ')');
        $twig->assign('description', Tools::tronc($groupe->getMiniText(), 175));
        $twig->assign('og_type', 'band');

        $twig->assign('is_loggued', !empty($_SESSION['membre']));

        $twig->assign(
            'videos',
            Video::find(
                [
                    'id_groupe' => $groupe->getIdGroupe(),
                    'online' => true,
                    'limit' => 30,
                ]
            )
        );

        $twig->assign(
            'audios',
            Audio::find(
                [
                    'id_groupe' => $groupe->getIdGroupe(),
                    'online' => true,
                    'order_by' => 'id_audio',
                    'sort' => 'DESC',
                    'limit' => 30,
                ]
            )
        );

        $twig->assign('og_image', $groupe->getMiniPhoto());

        if (!empty($_SESSION['membre'])) {
            if ($_SESSION['membre']->isInterne()) {
                $twig->assign('show_mot_adhoc', true);
            }
        }

        $twig->assign(
            'photos',
            Photo::find(
                [
                    'id_groupe' => $groupe->getIdGroupe(),
                    'online' => true,
                    'order_by' => 'random',
                    'limit' => 100,
                ]
            )
        );

        // concerts à venir
        $twig->assign(
            'f_events',
            Event::find(
                [
                    'id_groupe' => $groupe->getIdGroupe(),
                    'datdeb' => date('Y-m-d H:i:s'),
                    'online' => true,
                    'order_by' => 'date',
                    'sort' => 'ASC',
                    'limit' => 50,
                ]
            )
        );

        // concerts passés
        $twig->assign(
            'p_events',
            Event::find(
                [
                    'id_groupe' => $groupe->getIdGroupe(),
                    'datfin' => date('Y-m-d H:i:s'),
                    'online' => true,
                    'order_by' => 'date',
                    'sort' => 'DESC',
                    'limit' => 50,
                ]
            )
        );

        // alerting
        /*
        if (Tools::isAuth()) {
            if (!Alerting::getIdByIds($_SESSION['membre']->getId(), 'g', $groupe->getId())) {
                $twig->assign('alerting_sub_url', HOME_URL . '/alerting/sub?type=g&id_content=' . $groupe->getId());
            } else {
                $twig->assign('alerting_unsub_url', HOME_URL . '/alerting/unsub?type=g&id_content=' . $groupe->getId());
            }
        } else {
            $twig->assign('alerting_auth_url', HOME_URL . '/auth/auth');
        }
        */

        return $twig->render('groupes/show.twig');
    }

    /**
     * Formulaire de création d'un groupe
     *
     * @return string
     */
    public static function create(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $twig = new AdHocTwig();

        $twig->enqueueScript('/js/groupes/create.js');

        Trail::getInstance()
            ->addStep('Tableau de bord', '/membres/tableau-de-bord')
            ->addStep('Mes groupes', '/groupes/my')
            ->addStep('Inscription');

        // valeurs par défaut
        $data = [
            'name'             => '',
            'style'            => '',
            'influences'       => '',
            'lineup'           => '',
            'mini_text'        => '',
            'text'             => '',
            'site'             => '',
            'facebook_page_id' => '',
            'twitter_id'       => '',
        ];

        if (Tools::isSubmit('form-groupe-create')) {
            $data = [
                'name'             => (string) Route::params('name'),
                'style'            => (string) Route::params('style'),
                'influences'       => (string) Route::params('influences'),
                'lineup'           => (string) Route::params('lineup'),
                'mini_text'        => (string) Route::params('mini_text'),
                'text'             => (string) Route::params('text'),
                'site'             => Route::params('site') ? (string) Route::params('site') : null,
                'facebook_page_id' => Route::params('facebook_page_id') ? (string) Route::params('facebook_page_id') : null,
                'twitter_id'       => Route::params('twitter_id') ? (string) Route::params('twitter_id') : null,
                'id_type_musicien' => (int) Route::params('id_type_musicien'),
            ];

            $errors = self::validateGroupeCreateForm($data);
            if (count($errors) === 0) {
                $groupe = (new Groupe())
                    ->setName($data['name'])
                    ->setAlias(Tools::genAlias($data['name']))
                    ->setStyle($data['style'])
                    ->setInfluences($data['influences'])
                    ->setLineup($data['lineup'])
                    ->setMiniText($data['mini_text'])
                    ->setText($data['text'])
                    ->setSite($data['site'])
                    ->setFacebookPageId($data['facebook_page_id'])
                    ->setTwitterId($data['twitter_id'])
                    ->setEtat(Groupe::ETAT_ACTIF)
                    ->setOnline(true);

                if ($groupe->save()) {
                    if (is_uploaded_file($_FILES['lelogo']['tmp_name'])) {
                        (new Image($_FILES['lelogo']['tmp_name']))
                            ->setType(IMAGETYPE_JPEG)
                            ->setKeepRatio(true)
                            ->setMaxWidth(400)
                            ->setMaxHeight(400)
                            ->setDestFile(Groupe::getBasePath() . '/l' . $groupe->getId() . '.jpg')
                            ->write();
                    }

                    if (is_uploaded_file($_FILES['photo']['tmp_name'])) {
                        (new Image($_FILES['photo']['tmp_name']))
                            ->setType(IMAGETYPE_JPEG)
                            ->setKeepRatio(true)
                            ->setMaxWidth(400)
                            ->setMaxHeight(400)
                            ->setDestFile(Groupe::getBasePath() . '/p' . $groupe->getId() . '.jpg')
                            ->write();
                    }

                    if (is_uploaded_file($_FILES['mini_photo']['tmp_name'])) {
                        (new Image($_FILES['mini_photo']['tmp_name']))
                            ->setType(IMAGETYPE_JPEG)
                            ->setKeepRatio(false)
                            ->setMaxWidth(GROUPE_MINI_PHOTO_SIZE)
                            ->setMaxHeight(GROUPE_MINI_PHOTO_SIZE)
                            ->setDestFile(Groupe::getBasePath() . '/m' . $groupe->getId() . '.jpg')
                            ->write();
                    }

                    $groupe->linkMember($_SESSION['membre']->getId(), $data['id_type_musicien']);
                    $groupe->save();

                    Log::action(Log::ACTION_GROUP_CREATE, $groupe->getAlias());

                    Tools::redirect('/groupes/my');
                }
            }

            if (!empty($errors)) {
                foreach ($errors as $k => $v) {
                    $twig->assign('error_' . $k, $v);
                }
            }
        }

        $twig->assign('data', $data);
        $twig->assign('types_musicien', TypeMusicien::findAll());

        return $twig->render('groupes/create.twig');
    }

    /**
     * Formulaire d'édition d'un groupe
     *
     * @return string
     */
    public static function edit(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $id = (int) Route::params('id');

        $twig = new AdHocTwig();

        $twig->enqueueScript('/js/groupes/edit.js');

        try {
            $groupe = Groupe::getInstance($id);
        } catch (\Exception $e) {
            Route::setHttpCode(404);
            $twig->assign('unknown_groupe', true);
            return $twig->render('groupes/edit.twig');
        }

        Trail::getInstance()
            ->addStep('Tableau de bord', '/membres/tableau-de-bord')
            ->addStep('Mes groupes', '/groupes/my')
            ->addStep($groupe->getName());

        $twig->assign('groupe', $groupe);
        if (($id_type_musicien = $groupe->isMember($_SESSION['membre']->getId())) === false) {
            if (!$_SESSION['membre']->isAdmin()) {
                $twig->assign('not_my_groupe', true);
            }
        }

        $data = [
            'id_groupe'        => $groupe->getId(),
            'style'            => $groupe->getStyle(),
            'influences'       => $groupe->getInfluences(),
            'lineup'           => $groupe->getLineup(),
            'mini_text'        => $groupe->getMiniText(),
            'text'             => $groupe->getText(),
            'site'             => $groupe->getSite(),
            'facebook_page_id' => $groupe->getFacebookPageId(),
            'twitter_id'       => $groupe->getTwitterId(),
            'id_type_musicien' => $id_type_musicien,
        ];

        if (Tools::isSubmit('form-groupe-edit')) {
            $data = [
                'id_groupe'        => $groupe->getId(),
                'style'            => (string) Route::params('style'),
                'influences'       => (string) Route::params('influences'),
                'lineup'           => (string) Route::params('lineup'),
                'mini_text'        => (string) Route::params('mini_text'),
                'text'             => (string) Route::params('text'),
                'site'             => Route::params('site') ? (string) Route::params('site') : null,
                'facebook_page_id' => Route::params('facebook_page_id') ? (string) Route::params('facebook_page_id') : null,
                'twitter_id'       => Route::params('twitter_id') ? (string) Route::params('twitter_id') : null,
                'id_type_musicien' => (int) Route::params('id_type_musicien'),
            ];

            $errors = self::validateGroupeEditForm($data);
            if (count($errors) === 0) {
                if (!$groupe->isMember($_SESSION['membre']->getId()) && !$_SESSION['membre']->isAdmin()) {
                    return 'edition du groupe non autorisée';
                }

                $groupe->setStyle($data['style'])
                    ->setInfluences($data['influences'])
                    ->setLineup($data['lineup'])
                    ->setMiniText($data['mini_text'])
                    ->setText($data['text'])
                    ->setSite($data['site'])
                    ->setFacebookPageId($data['facebook_page_id'])
                    ->setTwitterId($data['twitter_id']);

                $groupe->save();

                $groupe->updateMember($_SESSION['membre']->getId(), $data['id_type_musicien']);

                if (is_uploaded_file($_FILES['lelogo']['tmp_name'])) {
                    (new Image($_FILES['lelogo']['tmp_name']))
                        ->setType(IMAGETYPE_JPEG)
                        ->setKeepRatio(true)
                        ->setMaxWidth(400)
                        ->setMaxHeight(400)
                        ->setDestFile(Groupe::getBasePath() . '/l' . $groupe->getId() . '.jpg')
                        ->write();
                }

                if (is_uploaded_file($_FILES['photo']['tmp_name'])) {
                    (new Image($_FILES['photo']['tmp_name']))
                        ->setType(IMAGETYPE_JPEG)
                        ->setKeepRatio(true)
                        ->setMaxWidth(400)
                        ->setMaxHeight(400)
                        ->setDestFile(Groupe::getBasePath() . '/p' . $groupe->getId() . '.jpg')
                        ->write();
                }

                if (is_uploaded_file($_FILES['mini_photo']['tmp_name'])) {
                    (new Image($_FILES['mini_photo']['tmp_name']))
                        ->setType(IMAGETYPE_JPEG)
                        ->setKeepRatio(false)
                        ->setMaxWidth(128)
                        ->setMaxHeight(128)
                        ->setDestFile(Groupe::getBasePath() . '/m' . $groupe->getId() . '.jpg')
                        ->write();
                }

                Log::action(Log::ACTION_GROUP_EDIT, $groupe->getId());

                Tools::redirect('/groupes/my');
            }

            if (!empty($errors)) {
                foreach ($errors as $k => $v) {
                    $twig->assign('error_' . $k, $v);
                }
            }
        }

        $twig->assign('data', $data);
        $twig->assign('types_musicien', TypeMusicien::findAll());

        return $twig->render('groupes/edit.twig');
    }

    /**
     * Formulaire de suppression d'un groupe
     *
     * @return string
     */
    public static function delete(): string
    {
        $id = (int) Route::params('id');

        Tools::auth(Membre::TYPE_STANDARD);

        $twig = new AdHocTwig();

        try {
            $groupe = Groupe::getInstance($id);
        } catch (\Exception $e) {
            Route::setHttpCode(404);
            $twig->assign('unknown_groupe', true);
            return $twig->render('groupes/delete.twig');
        }

        $can_delete = true;
        if ($_SESSION['membre']->isAdmin() === false) { // seul un admin peut supprimer un groupe
            if ($groupe->isMember($_SESSION['membre']->getId()) === false) { // seul un membre du groupe peut supprimer son groupe
                $twig->assign('not_my_groupe', true);
                $can_delete = false;
            }
        }

        if (Tools::isSubmit('form-groupe-delete')) {
            if ($can_delete) {
                if ($groupe->delete()) {
                    Log::action(Log::ACTION_GROUP_DELETE, $groupe->getId());
                }
                Tools::redirect('/groupes/my?delete=1');
            }
        }

        $twig->assign('groupe', $groupe);

        return $twig->render('groupes/delete.twig');
    }

    /**
     * Affiche un listing de groupes
     *
     * @return array<int,string>
     */
    public static function apiGroupes(): array
    {
        $groupes = Groupe::find([
            'online' => true,
            'order_by' => 'name',
            'sort' => 'ASC',
            'search_name' => (string) Route::params('s'),
        ]);

        $export = [];
        foreach ($groupes as $groupe) {
            $export[$groupe->getId()] = $groupe->getName();
        }
        return $export;
    }

    /**
     * Validation du formulaire de création groupe
     *
     * @param array<string,mixed> $data tableau des données
     *
     * @return array<string,true>
     */
    private static function validateGroupeCreateForm(array $data): array
    {
        $errors = [];

        if (empty($data['name'])) {
            $errors['name'] = true;
        }
        if (empty($data['style'])) {
            $errors['style'] = true;
        }
        if (empty($data['lineup'])) {
            $errors['lineup'] = true;
        }
        if (empty($data['mini_text'])) {
            $errors['mini_text'] = true;
        } elseif (mb_strlen($data['mini_text']) > 255) {
            $errors['mini_text'] = true;
        }
        if (empty($data['text'])) {
            $errors['text'] = true;
        }

        return $errors;
    }

    /**
     * Validation du formulaire de modification groupe
     *
     * @param array<string,mixed> $data tableau des données
     *
     * @return array<string,true>
     */
    private static function validateGroupeEditForm(array $data): array
    {
        $errors = [];

        if (empty($data['style'])) {
            $errors['style'] = true;
        }
        if (empty($data['lineup'])) {
            $errors['lineup'] = true;
        }
        if (empty($data['mini_text'])) {
            $errors['mini_text'] = true;
        } elseif (mb_strlen($data['mini_text']) > 255) {
            $errors['mini_text'] = true;
        }
        if (empty($data['text'])) {
            $errors['text'] = true;
        }

        return $errors;
    }
}
