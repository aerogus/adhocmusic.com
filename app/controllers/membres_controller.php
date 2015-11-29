<?php

class Controller
{
    static function show()
    {
        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'membres');

        $trail = Trail::getInstance();
        $trail->addStep("Membres", "/membres/");

        try {
            $membre = Membre::getInstance($id);
        } catch(AdHocUserException $e) {
            Route::set_http_code('404');
            $smarty->assign('unknown_member', true);
            return $smarty->fetch('membres/show.tpl');
        }

        $smarty->assign('membre', $membre);
        $trail->addStep($membre->getPseudo());

        $smarty->assign('title', "♫ Profil de " . $membre->getPseudo());
        $smarty->assign('description', "♫ Profil de " . $membre->getPseudo());

        $smarty->assign('groupes', $membre->getGroupes());

        $ids_photo = Membre::getTaggedPhotos($membre->getId());
        if(mb_strlen($ids_photo) > 0) {
            $smarty->assign('photos', Photo::getPhotos(array(
                'online' => true,
                'sort'   => 'random',
                'limit'  => 500,
                'id'     => $ids_photo,
            )));
        }

        return $smarty->fetch('membres/show.tpl');
    }

    static function create()
    {
        if(Tools::isAuth()) {
            Tools::redirect('/');
        }

        $smarty = new AdHocSmarty();

        $smarty->enqueue_script('/js/membre-create.js');

        $smarty->assign('title', "Inscription à l'association AD'HOC");
        $smarty->assign('description', "Association oeuvrant pour le développement de la vie musicale en Essonne depuis 1996. Promotion d'artistes, Pédagogie musicale, Agenda concerts, Communauté de musiciens ...");

        $smarty->assign('menuselected', 'membres');

        $trail = Trail::getInstance();
        $trail->addStep("Membres", "/membres/");
        $trail->addStep("Inscription");

        $smarty->assign('create', (bool) Route::params('create'));

        // valeurs par défaut
        $data = array(
            'pseudo'         => '',
            'email'          => '',
            'last_name'      => '',
            'first_name'     => '',
            'address'        => '',
            'cp'             => '',
            'city'           => '',
            'country'        => '',
            'id_country'     => 'FR', // France
            'id_region'      => 'A8', // Ile-de-France
            'id_departement' => '91', // Essonne
            'id_city'        => '',
            'tel'            => '',
            'port'           => '',
            'site'           => '',
            'mailing'        => true,
            'text'           => '',
            'facebook_profile_id' => 0,
            'facebook_auto_login' => true,
            'csrf'           => '',
        );

        if(Tools::isSubmit('form-member-create'))
        {
            $cp = '';
            $city = '';

            $country = WorldCountry::getName((string) Route::params('id_country'));
            if(((string) Route::params('id_country') == 'FR') && ((int) Route::params('id_city') > 0)) {
                $cp = City::getCp((int) Route::params('id_city'));
                $city = City::getName((int) Route::params('id_city'));
            }

            $data = array(
                'pseudo'         => trim((string) Route::params('pseudo')),
                'email'          => trim(strtolower((string) Route::params('email'))),
                'last_name'      => trim((string) Route::params('last_name')),
                'first_name'     => trim((string) Route::params('first_name')),
                'address'        => trim((string) Route::params('address')),
                'cp'             => $cp,
                'id_city'        => (int) Route::params('id_city'),
                'city'           => $city,
                'id_country'     => trim((string) Route::params('id_country')),
                'country'        => $country,
                'id_region'      => trim((string) Route::params('id_region')),
                'id_departement' => trim((string) Route::params('id_departement')),
                'tel'            => trim((string) Route::params('tel')),
                'port'           => trim((string) Route::params('port')),
                'site'           => trim((string) Route::params('site')),
                'text'           => trim((string) Route::params('text')),
                'mailing'        => (bool)Route::params('mailing'),
                'facebook_profile_id' => (string) Route::params('facebook_profile_id'),
                'facebook_auto_login' => (bool) Route::params('facebook_auto_login'),
                'csrf'           => '',
            );

            if(self::_validate_form_member_create($data, $errors)) {

                $data['password'] = Membre::generatePassword(8);

                if(empty($errors)) {

                    $membre = Membre::init();
                    $membre->setPseudo($data['pseudo']);
                    $membre->setPassword($data['password']);
                    $membre->setLastName($data['last_name']);
                    $membre->setFirstName($data['first_name']);
                    $membre->setAddress($data['address']);
                    $membre->setCp($data['cp']);
                    $membre->setCity($data['city']);
                    $membre->setCountry($data['country']);
                    $membre->setIdCity($data['id_city']);
                    $membre->setIdDepartement($data['id_departement']);
                    $membre->setIdRegion($data['id_region']);
                    $membre->setIdCountry($data['id_country']);
                    $membre->setTel($data['tel']);
                    $membre->setPort($data['port']);
                    $membre->setText($data['text']);
                    $membre->setEmail($data['email']);
                    $membre->setSite($data['site']);
                    $membre->setMailing($data['mailing']);
                    $membre->setLevel(Membre::TYPE_STANDARD);
                    //$membre->setFacebookProfileId($data['facebook_profile_id']);
                    //$membre->setFacebookAutoLogin($data['facebook_auto_login']);
                    $membre->setCreatedNow();

                    if($membre->save()) {
                        Email::send($data['email'], "Inscription à l'Association AD'HOC", 'member-create', $data);
                        Log::action(Log::ACTION_MEMBER_CREATE, $membre->getId());
                        Tools::redirect('/membres/create?create=1');
                    } else {
                        $errors['generic'] = true;
                    }

                }

            }

            if (!empty($errors)) {
                foreach($errors as $k => $v) {
                    $smarty->assign('error_' . $k, $v);
                }
            }

        }

        $smarty->assign('countries', WorldCountry::getHashTable());
        $smarty->assign('data', $data);

        return $smarty->fetch('membres/create.tpl');
    }

    /**
     * validation du formulaire de création membre
     * @param array $data
     * @param array &$errors
     * @return bool
     */
    protected static function _validate_form_member_create($data, &$errors)
    {
        $errors = array();
        if (empty($data['pseudo'])) {
            $errors['pseudo'] = true;
        }
        if(!Membre::isPseudoAvailable($data['pseudo'])) {
            $errors['pseudo_unavailable'] = true;
        }
        if($id_contact = Contact::getIdByEmail($data['email'])) {
            if($pseudo = Membre::getPseudoById($id_contact)) {
                $errors['already_member'] = $pseudo;
            }
        }
        if (empty($data['email'])) {
            $errors['email'] = true;
        } elseif(!Email::validate($data['email'])) {
            $errors['email'] = true;
        }
        if (empty($data['last_name'])) {
            $errors['last_name'] = true;
        }
        if (empty($data['first_name'])) {
            $errors['first_name'] = true;
        }
        if (empty($data['id_country'])) {
            $errors['id_country'] = true;
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

        if($id != $_SESSION['membre']->getId()) {
            Tools::auth(Membre::TYPE_STANDARD);
        }

        $trail = Trail::getInstance();
        $trail->addStep('Tableau de bord', '/membres/tableau-de-bord');
        $trail->addStep('Mes Infos Persos');

        $smarty = new AdHocSmarty();

        $smarty->enqueue_script('/js/membre-edit.js');

        if(Tools::isSubmit('form-member-edit'))
        {
            $member = $_SESSION['membre'];

            $data = array(
                'last_name' => trim((string) Route::params('last_name')),
                'first_name' => trim((string) Route::params('first_name')),
                'address' => trim((string) Route::params('address')),
                'cp' => trim((string) Route::params('cp')),
                'city' => trim((string) Route::params('city')),
                'country' => trim((string) Route::params('country')),
                'id_city' => (int) Route::params('id_city'),
                'id_departement' => trim((string) Route::params('id_departement')),
                'id_region' => trim((string) Route::params('id_region')),
                'id_country' => trim((string) Route::params('id_country')),
                'tel' => trim((string) Route::params('tel')),
                'port' => trim((string) Route::params('port')),
                'text' => trim((string) Route::params('text')),
                'email' => trim((string) Route::params('email')),
                'site' => trim((string) Route::params('site')),
                'mailing' => (bool) Route::params('mailing'),
            );

            if(self::_validate_form_member_edit($data, $errors)) {

                $member->setLastName($data['last_name']);
                $member->setFirstName($data['first_name']);
                $member->setAddress($data['address']);
                $member->setCp($data['cp']);
                $member->setCity($data['city']);
                $member->setCountry($data['country']);
                $member->setIdCity($data['id_city']);
                $member->setIdDepartement($data['id_departement']);
                $member->setIdRegion($data['id_region']);
                $member->setIdCountry($data['id_country']);
                $member->setTel($data['tel']);
                $member->setPort($data['port']);
                $member->setText($data['text']);
                $member->setEmail($data['email']);
                $member->setSite($data['site']);
                $member->setMailing($data['mailing']);
                $member->setModifiedNow();

                $member->save();

                if($member->isInterne()) {
                    $forum = Route::params('forum');
                    ForumPrive::delAllSubscriptions($member->getId());
                    if(is_array($forum)) {
                        foreach($forum as $f => $val) {
                            if($val == 'on') {
                                ForumPrive::addSubscriberToForum($member->getId(), $f);
                            }
                        }
                    }
                }

                /* traitement de la photo officielle envoyée (112*174) */
                if($member->isInterne()) {
                    if(is_uploaded_file($_FILES['photo']['tmp_name'])) {
                        $img = new Image($_FILES['photo']['tmp_name']);
                        $img->setType(IMAGETYPE_JPEG);
                        $img->setMaxWidth(112);
                        $img->setMaxHeight(174);
                        $img->setDestFile(ADHOC_ROOT_PATH . '/static/media/membre/ca/' . $_SESSION['membre']->getId() . '.jpg');
                        $img->write();
                        $img = null;
                    }
                }

                /* traitement de l'avatar (112*---) */
                if(is_uploaded_file($_FILES['avatar']['tmp_name'])) {
                    $img = new Image($_FILES['avatar']['tmp_name']);
                    $img->setType(IMAGETYPE_JPEG);
                    $img->setMaxWidth(112);
                    $img->setMaxHeight(250);
                    $img->setDestFile(ADHOC_ROOT_PATH . '/static/media/membre/' . $_SESSION['membre']->getId() . '.jpg');
                    $img->write();
                    $img = null;
                }

                Log::action(Log::ACTION_MEMBER_EDIT, $member->getId());

                $smarty->assign('updated_ok', true);

            } else {

                if (!empty($errors)) {
                    foreach($errors as $k => $v) {
                        $smarty->assign('error_' . $k, $v);
                    }
                }

            }
        }

        if($_SESSION['membre']->getFacebookProfileId() > 0) {
            $fb_me = json_decode(file_get_contents('http://graph.facebook.com/' . $_SESSION['membre']->getFacebookProfileId()));
            $fb_me->avatar = 'http://graph.facebook.com/' . $_SESSION['membre']->getFacebookProfileId() . '/picture';
            $smarty->assign('fb_me', $fb_me);
        }

        $smarty->assign('membre', $_SESSION['membre']);

        if($_SESSION['membre']->isInterne()) {
            $smarty->assign('forum', ForumPrive::getSubscribedForums($_SESSION['membre']->getId()));
        }

        $smarty->assign('countries', WorldCountry::getHashTable());

        return $smarty->fetch('membres/edit.tpl');
    }

    /**
     * validation du formulaire de modification membre
     * @param array $data
     * @param array &$errors
     * @return bool
     */
    protected static function _validate_form_member_edit($data, &$errors)
    {
        $errors = array();
        if (empty($data['email'])) {
            $errors['email'] = true;
        } elseif(!Email::validate($data['email'])) {
            $errors['email'] = true;
        }
        if (empty($data['last_name'])) {
            $errors['last_name'] = true;
        }
        if (empty($data['first_name'])) {
            $errors['first_name'] = true;
        }
        if (empty($data['id_country'])) {
            $errors['id_country'] = true;
        }
        if(count($errors)) {
            return false;
        }
        return true;
    }

    static function delete()
    {
        Tools::auth(Membre::TYPE_ADMIN);

        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        try {
            $membre = Membre::getInstance($id);
        } catch(AdHocUserException $e) {
            Route::set_http_code('404');
            $smarty->assign('unknown_member', true);
            return $smarty->fetch('membres/delete.tpl');
        }

        if(Tools::isSubmit('form-member-delete'))
        {
            if($membre->delete()) {
                Log::action(Log::ACTION_MEMBER_DELETE, $id);
                Tools::redirect('/?delete-member=ok');
            }
        }

        $smarty->assign('membre', $membre);

        return $smarty->fetch('membres/delete.tpl');
    }

    static function autocomplete_pseudo()
    {
        $q = trim((string) Route::params('q'));

        if(strlen($q) < 1) {
            return array();
        }

        $db = DataBase::getInstance();

        $sql = "SELECT `id_contact`, `pseudo` "
             . "FROM `adhoc_membre` "
             . "WHERE `pseudo` LIKE '" . $db->escape($q) . "%' "
             . "ORDER BY `pseudo` ASC "
             . "LIMIT 0, 10";

        $res = $db->queryWithFetch($sql);

        return $res;
    }

    static function fb_link()
    {
        Tools::auth(Membre::TYPE_STANDARD);

        if(Tools::isSubmit('form-fb-link'))
        {
            $fbid = 0;
            if(!empty($_SESSION['fb'])) {
                $fb_me = json_decode(file_get_contents('http://graph.facebook.com/' . $_SESSION['fb']->getUser()));
                $fbid = $fb_me->id;
            }

            $membre = $_SESSION['membre'];
            $membre->setFacebookProfileId($fbid);
            $membre->setFacebookAutoLogin(true);
            $membre->save();

            Tools::redirect('/membres/edit/' . $membre->getId());
        }

        $smarty = new AdHocSmarty();

        if($_SESSION['membre']->getFacebookProfileId()) {
            $smarty->assign('err_link', true);
        } else {
            if(!empty($_SESSION['fb'])) {
                $fb_me = json_decode(file_get_contents('http://graph.facebook.com/' . $_SESSION['fb']->getUser()));
                $smarty->assign('fb_me', $fb_me);
            } else {
                // recup info compte fb ?
            }
        }
        return $smarty->fetch('membres/fb-link.tpl');
    }

    static function fb_unlink()
    {
        Tools::auth(Membre::TYPE_STANDARD);

        if(Tools::isSubmit('form-fb-unlink'))
        {
            $membre = $_SESSION['membre'];
            $membre->setFacebookProfileId(0);
            $membre->setFacebookAutoLogin(false);
            $membre->save();

            Tools::redirect('/membres/edit/' . $membre->getId());
        }

        $smarty = new AdHocSmarty();

        if(!$_SESSION['membre']->getFacebookProfileId()) {
            $smarty->assign('err_unlink', true);
        } else {
            $fb_me = json_decode(file_get_contents('http://graph.facebook.com/' . $_SESSION['membre']->getFacebookProfileId()));
            $fb_me->avatar = 'http://graph.facebook.com/' . $_SESSION['membre']->getFacebookProfileId() . '/picture';
            $smarty->assign('fb_me', $fb_me);
        }
        return $smarty->fetch('membres/fb-unlink.tpl');
    }

    static function tableau_de_bord()
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $trail = Trail::getInstance();
        $trail->addStep("Tableau de bord", "/membres/tableau-de-bord");

        $smarty = new AdHocSmarty();

        $smarty->assign('groupes', Groupe::getMyGroupes());

        $smarty->assign('photos', Photo::getPhotos(array(
            'contact' => $_SESSION['membre']->getId(),
            'limit'   => 4,
            'debut'   => 0,
            'sort'    => 'id',
            'sens'    => 'DESC',
        )));
        $smarty->assign('nb_photos', Photo::getMyPhotosCount());

        $smarty->assign('videos', Video::getVideos(array(
            'contact' => $_SESSION['membre']->getId(),
            'limit'   => 4,
            'debut'   => 0,
            'sort'    => 'id',
            'sens'    => 'DESC',
        )));
        $smarty->assign('nb_videos', Video::getMyVideosCount());

        $smarty->assign('audios', Audio::getAudios(array(
            'contact' => $_SESSION['membre']->getId(),
            'debut'   => 0,
            'limit'   => 5,
            'sort'    => 'id',
            'sens'    => 'DESC',
        )));
        $smarty->assign('nb_audios', Audio::getMyAudiosCount());

        $db = DataBase::getInstance();

        $sql = "SELECT `p`.`id_pm` AS `id`, `m`.`pseudo`, `p`.`from`, `p`.`date`, `p`.`read`, `p`.`text` "
             . "FROM `adhoc_messagerie` `p`, `adhoc_membre` `m` "
             . "WHERE `p`.`from` = `m`.`id_contact` "
             . "AND `p`.`to` = " . (int) $_SESSION['membre']->getId() . " "
             . "AND `p`.`del_to` = FALSE "
             . "ORDER BY `p`.`date` DESC "
             . "LIMIT 0, 5";

        $smarty->assign('inbox', $db->queryWithFetch($sql));

        $smarty->assign('alerting_groupes', Alerting::getGroupesAlertingByIdContact($_SESSION['membre']->getId()));
        $smarty->assign('alerting_lieux', Alerting::getLieuxAlertingByIdContact($_SESSION['membre']->getId()));
        $smarty->assign('alerting_events', Alerting::getEventsAlertingByIdContact($_SESSION['membre']->getId()));

        return $smarty->fetch('membres/tableau-de-bord.tpl');
    }
}
