<?php declare(strict_types=1);

use \Reference\TypeMusicien;

define('GROUPE_MINI_PHOTO_SIZE', 128);

final class Controller
{
    /**
     * Listing des groupes
     *
     * @return string
     */
    static function index(): string
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('title', "♫ Les groupes de la communauté musicale AD'HOC");
        $smarty->assign('description', "Association oeuvrant pour le développement de la vie musicale en Essonne depuis 1996. Promotion d'artistes, Pédagogie musicale, Agenda concerts, Communauté de musiciens ...");

        Trail::getInstance()
            ->addStep("Groupes");

        $smarty->assign(
            'groupes', Groupe::find(
                [
                    'online' => true,
                    'order_by' => 'name',
                    'sort' => 'ASC',
                ]
            )
        );

        return $smarty->fetch('groupes/index.tpl');
    }

    /**
     * @return string
     */
    static function my(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $smarty = new AdHocSmarty();

        $smarty->assign('title', "AD'HOC Music : Les Musiques actuelles en Essonne");
        $smarty->assign('description', "Association oeuvrant pour le développement de la vie musicale en Essonne depuis 1996. Promotion d'artistes, Pédagogie musicale, Agenda concerts, Communauté de musiciens ...");

        Trail::getInstance()
            ->addStep('Tableau de bord', '/membres/tableau-de-bord')
            ->addStep('Mes groupes');

        $smarty->assign('delete', (bool) Route::params('delete'));

        $smarty->assign(
            'groupes', Groupe::find(
                ['id_contact' => $_SESSION['membre']->getId()]
            )
        );

        return $smarty->fetch('groupes/my.tpl');
    }

    /**
     * @return string
     */
    static function show(): string
    {
        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        $smarty->enqueue_style('/css/baguetteBox.min.css');

        $smarty->enqueue_script('/js/masonry-4.2.2.min.js');
        $smarty->enqueue_script('/js/imagesloaded-4.1.4.min.js');
        $smarty->enqueue_script('/js/baguetteBox-1.11.0.min.js');

        $smarty->enqueue_script('/js/groupe-show.js');

        try {
            $groupe = Groupe::getInstance($id);
            if (!$groupe->getOnline()) {
                throw new Exception('groupe offline');
            }
        } catch (Exception $e) {
            Route::set_http_code(404);
            $smarty->assign('unknown_group', true);
            return $smarty->fetch('groupes/show.tpl');
        }

        $smarty->assign('groupe', $groupe);
        $smarty->assign('membres', $groupe->getMembers());

        Trail::getInstance()
            ->addStep("Groupes", "/groupes")
            ->addStep($groupe->getName());

        $smarty->assign('title', "♫ ".$groupe->getName()." (".$groupe->getStyle().")");
        $smarty->assign('description', Tools::tronc($groupe->getMiniText(), 175));
        $smarty->assign('og_type', 'band');

        $smarty->assign('is_loggued', !empty($_SESSION['membre']));

        $smarty->assign(
            'videos', Video::find(
                [
                    'id_groupe' => $groupe->getIdGroupe(),
                    'online' => true,
                    'limit' => 30,
                ]
            )
        );

        $smarty->assign(
            'audios', Audio::find(
                [
                    'id_groupe' => $groupe->getIdGroupe(),
                    'online' => true,
                    'order_by' => 'id_audio',
                    'sort' => 'DESC',
                    'limit' => 30,
                ]
            )
        );

        $smarty->assign('og_image', $groupe->getMiniPhoto());

        if (!empty($_SESSION['membre'])) {
            if ($_SESSION['membre']->isInterne()) {
                $smarty->assign('show_mot_adhoc', true);
            }
        }

        $smarty->assign(
            'photos', Photo::find(
                [
                    'id_groupe' => $groupe->getIdGroupe(),
                    'online' => true,
                    'order_by' => 'random',
                    'limit' => 100,
                ]
            )
        );

        // concerts à venir
        $smarty->assign(
            'f_events', Event::find(
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
        $smarty->assign(
            'p_events', Event::find(
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
                $smarty->assign('alerting_sub_url', HOME_URL . '/alerting/sub?type=g&id_content='.$groupe->getId());
            } else {
                $smarty->assign('alerting_unsub_url', HOME_URL . '/alerting/unsub?type=g&id_content='.$groupe->getId());
            }
        } else {
            $smarty->assign('alerting_auth_url', HOME_URL . '/auth/login');
        }
        */

        return $smarty->fetch('groupes/show.tpl');
    }

    /**
     * Formulaire de création d'un groupe
     *
     * @return string
     */
    static function create(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $smarty = new AdHocSmarty();

        $smarty->enqueue_script('/js/groupe-create.js');

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
            $errors = [];

            if (self::_validateGroupeCreateForm($data, $errors)) {

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
                    $smarty->assign('error_' . $k, $v);
                }
            }

        }

        $smarty->assign('data', $data);
        $smarty->assign('types_musicien', TypeMusicien::findAll());

        return $smarty->fetch('groupes/create.tpl');
    }

    /**
     * Formulaire d'édition d'un groupe
     *
     * @return string
     */
    static function edit(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        $smarty->enqueue_script('/js/groupe-edit.js');

        try {
            $groupe = Groupe::getInstance($id);
        } catch (Exception $e) {
            Route::set_http_code(404);
            $smarty->assign('unknown_groupe', true);
            return $smarty->fetch('groupes/edit.tpl');
        }

        Trail::getInstance()
            ->addStep('Tableau de bord', '/membres/tableau-de-bord')
            ->addStep('Mes groupes', '/groupes/my')
            ->addStep($groupe->getName());

        $smarty->assign('groupe', $groupe);
        if (($id_type_musicien = $groupe->isMember($_SESSION['membre']->getId())) === false) {
            if (!$_SESSION['membre']->isAdmin()) {
                $smarty->assign('not_my_groupe', true);
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
            $errors = [];

            if (self::_validateGroupeEditForm($data, $errors)) {

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
                    $smarty->assign('error_' . $k, $v);
                }
            }

        }

        $smarty->assign('data', $data);
        $smarty->assign('types_musicien', TypeMusicien::findAll());

        return $smarty->fetch('groupes/edit.tpl');
    }

    /**
     * Formulaire de suppression d'un groupe
     *
     * @return string
     */
    static function delete(): string
    {
        $id = (int) Route::params('id');

        Tools::auth(Membre::TYPE_STANDARD);

        $smarty = new AdHocSmarty();

        try {
            $groupe = Groupe::getInstance($id);
        } catch (Exception $e) {
            Route::set_http_code(404);
            $smarty->assign('unknown_groupe', true);
            return $smarty->fetch('groupes/delete.tpl');
        }

        $can_delete = true;
        if ($_SESSION['membre']->isAdmin() === false) { // protection seul un admin peut supprimer un groupe
            if ($groupe->isMember($_SESSION['membre']->getId()) === false) { // protection seul un membre du groupe peut supprimer son groupe
                $smarty->assign('not_my_groupe', true);
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

        $smarty->assign('groupe', $groupe);

        return $smarty->fetch('groupes/delete.tpl');
    }

    /**
     * Validation du formulaire de création groupe
     *
     * @param array $data   tableau des données
     * @param array $errors tableau des erreurs (par référence)
     *
     * @return bool
     */
    private static function _validateGroupeCreateForm(array $data, array &$errors): bool
    {
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
        if (count($errors)) {
            return false;
        }
        return true;
    }

    /**
     * Validation du formulaire de modification groupe
     *
     * @param array $data   tableau des données
     * @param array $errors tableau des erreurs (par référence)
     *
     * @return bool
     */
    private static function _validateGroupeEditForm(array $data, array &$errors): bool
    {
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
        if (count($errors)) {
            return false;
        }
        return true;
    }
}
