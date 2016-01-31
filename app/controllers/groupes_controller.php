<?php

class Controller
{
    static function index()
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('title', "♫ Les groupes de la communauté musicale AD'HOC");
        $smarty->assign('description', "Association oeuvrant pour le développement de la vie musicale en Essonne depuis 1996. Promotion d'artistes, Pédagogie musicale, Agenda concerts, Communauté de musiciens ...");

        $smarty->assign('menuselected', 'groupes');

        $trail = Trail::getInstance();
        $trail->addStep("Groupes", "/groupes/");

//return sizeof(Groupe::getGroupesByName());
        $smarty->assign('liste_groupes', Groupe::getGroupesByName());

        return $smarty->fetch('groupes/index.tpl');
    }

    static function my()
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $smarty = new AdHocSmarty();

        $smarty->assign('title', "AD'HOC Music : Les Musiques actuelles en Essonne");
        $smarty->assign('description', "Association oeuvrant pour le développement de la vie musicale en Essonne depuis 1996. Promotion d'artistes, Pédagogie musicale, Agenda concerts, Communauté de musiciens ...");

        $trail = Trail::getInstance();
        $trail->addStep("Tableau de bord", "/membres/tableau-de-bord");
        $trail->addStep("Mes Groupes", "/groupes/my");

        $smarty->assign('delete', (bool) Route::params('delete'));
        $smarty->assign('groupes', Groupe::getMyGroupes());

        return $smarty->fetch('groupes/my.tpl');
    }

    static function show()
    {
        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        try {
            $groupe = Groupe::getInstance($id);
        } catch(Exception $e) {
            Route::set_http_code('404');
            $smarty->assign('unknown_group', true);
            return $smarty->fetch('groupes/show.tpl');
        }

        $smarty->assign('groupe', $groupe);
        $smarty->assign('membres', Groupe::getMembersById($groupe->getId()));

        $trail = Trail::getInstance();
        $trail->addStep("Groupes", "/groupes/");
        $trail->addStep($groupe->getName());

        $smarty->assign('title', "♫ ".$groupe->getName()." (".$groupe->getStyle().")");
        $smarty->assign('description', Tools::tronc($groupe->getMiniText(), 175));
        $smarty->assign('og_type', 'band');

        $smarty->assign('menuselected', 'groupes');

        $smarty->assign('is_loggued', !empty($_SESSION['membre']));

        $smarty->assign('videos', Video::getVideos(array(
            'online' => true,
            'groupe' => (int) $groupe->getId(),
            'limit'  => 30,
        )));

        $audios = Audio::getAudios(array(
            'groupe' => (int) $groupe->getId(),
            'online' => true,
            'limit'  => 30,
            'sort'   => 'id_audio',
            'sens'   => 'DESC',
        ));

        $smarty->assign('audios', $audios);

        $smarty->assign('og_image', $groupe->getMiniPhoto());

        if(!empty($_SESSION['membre'])) {
            if($_SESSION['membre']->isInterne()) {
                $smarty->assign('show_mot_adhoc', true);
            }
        }

        $smarty->assign('photos', Photo::getPhotos(array(
            'sort'   => 'random',
            'limit'  => 100,
            'groupe' => (int) $groupe->getId(),
            'online' => true,
        )));

        // concerts à venir
        $smarty->assign('f_events', Event::getEvents(array(
            'datdeb' => date('Y-m-d H:i:s'),
            'sort'   => 'date',
            'sens'   => 'ASC',
            'groupe' => (int) $groupe->getId(),
            'online' => true,
            'limit'  => 50,
        )));

        // concerts passés
        $smarty->assign('p_events', Event::getEvents(array(
            'datfin' => date('Y-m-d H:i:s'),
            'sort'   => 'date',
            'sens'   => 'DESC',
            'groupe' => (int) $groupe->getId(),
            'online' => true,
            'limit'  => 50,
        )));

        $groupe->addVisite();

        // alerting
        if(Tools::isAuth()) {
            if(!Alerting::getIdByIds($_SESSION['membre']->getId(), 'g', $groupe->getId())) {
                $smarty->assign('alerting_sub_url', 'http://www.adhocmusic.com/alerting/sub?type=g&id_content='.$groupe->getId());
            } else {
                $smarty->assign('alerting_unsub_url', 'http://www.adhocmusic.com/alerting/unsub?type=g&id_content='.$groupe->getId());
            }
        } else {
            $smarty->assign('alerting_auth_url', 'http://www.adhocmusic.com/auth/login');
        }

        return $smarty->fetch('groupes/show.tpl');
    }

    static function create()
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Groupes", "/groupes/");
        $trail->addStep("Inscription", "/groupes/create");

        // valeurs par défaut
        $data = array(
            'name'             => '',
            'style'            => '',
            'influences'       => '',
            'lineup'           => '',
            'mini_text'        => '',
            'text'             => '',
            'site'             => '',
            'myspace'          => '',
            'facebook_page_id' => '',
            'twitter_id'       => '',
        );

        if(Tools::isSubmit('form-groupe-create'))
        {
            $data = array(
                'name'             => (string) Route::params('name'),
                'style'            => (string) Route::params('style'),
                'influences'       => (string) Route::params('influences'),
                'lineup'           => (string) Route::params('lineup'),
                'mini_text'        => (string) Route::params('mini_text'),
                'text'             => (string) Route::params('text'),
                'site'             => (string) Route::params('site'),
                'myspace'          => (string) Route::params('myspace'),
                'facebook_page_id' => (string) Route::params('facebook_page_id'),
                'twitter_id'       => (string) Route::params('twitter_id'),
            );

            if(self::_validate_form_groupe_create($data, $errors)) {

                /* todo: extraire le page id à partir du nom d'utilisateur */
                /*
                $page = file_get_contents('http://graph.facebook.com/thestalls');
                $page = json_decode($page);
                var_dump($page->id);
                */

                $groupe = Groupe::init();
                $groupe->setName($data['name']);
                $groupe->setAlias(Groupe::genAlias($data['name']));
                $groupe->setStyle($data['style']);
                $groupe->setInfluences($data['influences']);
                $groupe->setLineup($data['lineup']);
                $groupe->setMiniText($data['mini_text']);
                $groupe->setText($data['text']);
                $groupe->setSite($data['site']);
                $groupe->setMyspaceId($data['myspace']);
                $groupe->setFacebookPageId($data['facebook_page_id']);
                $groupe->setTwitterId($data['twitter_id']);
                $groupe->setEtat(Groupe::ETAT_ACTIF);
                $groupe->setOnline(true);
                $groupe->setCreatedNow();

                if($groupe->save()) {

                    if(is_uploaded_file($_FILES['lelogo']['tmp_name'])) {
                        $img = new Image($_FILES['lelogo']['tmp_name']);
                        $img->setType(IMAGETYPE_JPEG);
                        $img->setKeepRatio(true);
                        $img->setMaxWidth(400);
                        $img->setMaxHeight(400);
                        $img->setDestFile(Groupe::getBasePath() . '/l' . $groupe->getId() . '.jpg');
                        $img->write();
                        $img = '';
                    }

                    if(is_uploaded_file($_FILES['photo']['tmp_name'])) {
                        $img = new Image($_FILES['photo']['tmp_name']);
                        $img->setType(IMAGETYPE_JPEG);
                        $img->setKeepRatio(true);
                        $img->setMaxWidth(400);
                        $img->setMaxHeight(400);
                        $img->setDestFile(Groupe::getBasePath() . '/p' . $groupe->getId() . '.jpg');
                        $img->write();
                        $img = '';
                    }

                    if(is_uploaded_file($_FILES['mini_photo']['tmp_name'])) {
                        $img = new Image($_FILES['mini_photo']['tmp_name']);
                        $img->setType(IMAGETYPE_JPEG);
                        $img->setKeepRatio(false);
                        $img->setMaxWidth(64);
                        $img->setMaxHeight(64);
                        $img->setDestFile(Groupe::getBasePath() . '/m' . $groupe->getId() . '.jpg');
                        $img->write();
                        $img = '';
                    }

                    $groupe->linkMember($_SESSION['membre']->getId());
                    $groupe->setModifiedNow();
                    $groupe->save();

                    Log::action(Log::ACTION_GROUP_CREATE, $groupe->getAlias());

                    Tools::redirect('/' . $groupe->getAlias());

                }
            }

            if (!empty($errors)) {
                foreach($errors as $k => $v) {
                    $smarty->assign('error_' . $k, $v);
                }
            }

        }

        $smarty->assign('data', $data);
        $smarty->assign('types_musicien', Membre::getTypesMusicien());

        return $smarty->fetch('groupes/create.tpl');
    }

    /**
     * validation du formulaire de création groupe
     * @param array $data
     * @param array &$errors
     * @return bool
     */
    protected static function _validate_form_groupe_create($data, &$errors)
    {
        $errors = array();
        if(empty($data['name'])) {
            $errors['name'] = true;
        }
        if(empty($data['style'])) {
            $errors['style'] = true;
        }
        if(empty($data['influences'])) {
            $errors['influences'] = true;
        }
        if(empty($data['lineup'])) {
            $errors['lineup'] = true;
        }
        if(empty($data['mini_text'])) {
            $errors['mini_text'] = true;
        }
        if(empty($data['text'])) {
            $errors['text'] = true;
        }
        if(count($errors)) {
            return false;
        }
        return true;
    }

    static function edit()
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        try {
            $groupe = Groupe::getInstance($id);
        } catch(Exception $e) {
            Route::set_http_code('404');
            $smarty->assign('unknown_groupe', true);
            return $smarty->fetch('groupes/edit.tpl');
        }

        $trail = Trail::getInstance();
        $trail->addStep("Mes Groupes", "/groupes/my");
        $trail->addStep($groupe->getName());

        $smarty->assign('groupe', $groupe);
        if(($id_type_musicien = $groupe->isMember($_SESSION['membre']->getId())) === false) {
            $smarty->assign('not_my_groupe', true);
        }

        $data = array(
            'id_groupe'        => $groupe->getId(),/*
            'name'             => $groupe->getName(),*/
            'style'            => $groupe->getStyle(),
            'influences'       => $groupe->getInfluences(),
            'lineup'           => $groupe->getLineup(),
            'mini_text'        => $groupe->getMiniText(),
            'text'             => $groupe->getText(),
            'site'             => $groupe->getSite(),
            'myspace'          => $groupe->getMyspace(),
            'facebook_page_id' => $groupe->getFacebookPageId(),
            'twitter_id'       => $groupe->getTwitterId(),
        );

        if(Tools::isSubmit('form-groupe-edit'))
        {
            $data = array(
                'id_groupe'        => $groupe->getId(),
                'style'            => (string) Route::params('style'),
                'influences'       => (string) Route::params('influences'),
                'lineup'           => (string) Route::params('lineup'),
                'mini_text'        => (string) Route::params('mini_text'),
                'text'             => (string) Route::params('text'),
                'site'             => (string) Route::params('site'),
                'myspace'          => (string) Route::params('myspace'),
                'facebook_page_id' => (string) Route::params('facebook_page_id'),
                'twitter_id'       => (string) Route::params('twitter_id'),
                'id_type_musicien' => (int) Route::params('id_type_musicien'),
            );

            if(self::_validate_form_groupe_edit($data, $errors)) {

                if($groupe->isMember($_SESSION['membre']->getId()) === false) {
                    return 'edition du groupe non autorisée';
                }

                $groupe->setStyle($data['style']);
                $groupe->setInfluences($data['influences']);
                $groupe->setLineup($data['lineup']);
                $groupe->setMiniText($data['mini_text']);
                $groupe->setText($data['text']);
                $groupe->setSite($data['site']);
                $groupe->setMyspaceId($data['myspace']);
                $groupe->setFacebookPageId($data['facebook_page_id']);
                $groupe->setTwitterId($data['twitter_id']);
                $groupe->setModifiedNow();
                $groupe->save();

                $groupe->updateMember($_SESSION['membre']->getId(), $data['id_type_musicien']);

                if(is_uploaded_file($_FILES['lelogo']['tmp_name'])) {
                    $img = new Image($_FILES['lelogo']['tmp_name']);
                    $img->setType(IMAGETYPE_JPEG);
                    $img->setKeepRatio(true);
                    $img->setMaxWidth(400);
                    $img->setMaxHeight(400);
                    $img->setDestFile(Groupe::getBasePath() . '/l' . $groupe->getId() . '.jpg');
                    $img->write();
                    $img = '';
                }

                if(is_uploaded_file($_FILES['photo']['tmp_name'])) {
                    $img = new Image($_FILES['photo']['tmp_name']);
                    $img->setType(IMAGETYPE_JPEG);
                    $img->setKeepRatio(true);
                    $img->setMaxWidth(400);
                    $img->setMaxHeight(400);
                    $img->setDestFile(Groupe::getBasePath() . '/p' . $groupe->getId() . '.jpg');
                    $img->write();
                    $img = '';
                }

                if(is_uploaded_file($_FILES['mini_photo']['tmp_name'])) {
                    $img = new Image($_FILES['mini_photo']['tmp_name']);
                    $img->setType(IMAGETYPE_JPEG);
                    $img->setKeepRatio(false);
                    $img->setMaxWidth(64);
                    $img->setMaxHeight(64);
                    $img->setDestFile(Groupe::getBasePath() . '/m' . $groupe->getId() . '.jpg');
                    $img->write();
                    $img = '';
                }

                Log::action(Log::ACTION_GROUP_EDIT, $groupe->getId());

                Tools::redirect('/groupes/my');

            }

            if (!empty($errors)) {
                foreach($errors as $k => $v) {
                    $smarty->assign('error_' . $k, $v);
                }
            }

        }

        $smarty->assign('data', $data);
        $smarty->assign('id_type_musicien', $id_type_musicien);
        $smarty->assign('types_musicien', Membre::getTypesMusicien());

        return $smarty->fetch('groupes/edit.tpl');
    }

    /**
     * validation du formulaire de modification groupe
     * @param array $data
     * @param array &$errors
     * @return bool
     */
    protected static function _validate_form_groupe_edit($data, &$errors)
    {
        $errors = array();
        if(empty($data['style'])) {
            $errors['style'] = true;
        }
        if(empty($data['influences'])) {
            $errors['influences'] = true;
        }
        if(empty($data['lineup'])) {
            $errors['lineup'] = true;
        }
        if(empty($data['mini_text'])) {
            $errors['mini_text'] = true;
        }
        if(empty($data['text'])) {
            $errors['text'] = true;
        }
        if(count($errors)) {
            return false;
        }
        return true;
    }

    static function delete()
    {
        $id = (int) Route::params('id');

        Tools::auth(Membre::TYPE_STANDARD);

        $smarty = new AdHocSmarty();

        try {
            $groupe = Groupe::getInstance($id);
        } catch(Exception $e) {
            Route::set_http_code('404');
            $smarty->assign('unknown_groupe', true);
            return $smarty->fetch('groupes/delete.tpl');
        }

        $can_delete = true;
        if($_SESSION['membre']->isAdmin() === false) {
            if($groupe->isMember($_SESSION['membre']->getId()) !== true) {
                $smarty->assign('not_my_groupe', true);
                $can_delete = false;
            }
        }

        if(Tools::isSubmit('form-groupe-delete'))
        {
            if($can_delete) {
                if($groupe->delete()) {
                    Log::action(Log::ACTION_GROUP_DELETE, $groupe->getId());
                }
                Tools::redirect('/groupes/my?delete=1');
            }
        }

        $smarty->assign('groupe', $groupe);

        return $smarty->fetch('groupes/delete.tpl');
    }

    static function playlist()
    {
        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        $smarty->assign('audios', Audio::getAudios(array(
            'online' => true,
            'groupe' => (int) $id,
            'limit'  => 10,
            'sort'   => 'id_audio',
            'sens'   => 'DESC',
        )));

        return $smarty->fetch('groupes/playlist.tpl');
    }
}
