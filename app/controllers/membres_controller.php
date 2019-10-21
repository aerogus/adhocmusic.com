<?php declare(strict_types=1);

/**
 * Controlleur Membre
 */
final class Controller
{
    /**
     * Profil d'un membre
     *
     * @return string
     */
    static function show(): string
    {
        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance()
            ->addStep("Membres", "/membres/");

        try {
            $membre = Membre::getInstance($id);
        } catch (Exception $e) {
            Route::set_http_code('404');
            $smarty->assign('unknown_member', true);
            return $smarty->fetch('membres/show.tpl');
        }

        $smarty->assign('membre', $membre);
        $trail->addStep($membre->getPseudo());

        $smarty->assign('title', "♫ Profil de " . $membre->getPseudo());
        $smarty->assign('description', "♫ Profil de " . $membre->getPseudo());

        $smarty->assign('groupes', $membre->getGroupes());

        return $smarty->fetch('membres/show.tpl');
    }

    /**
     * Création d'un compte membre
     *
     * @return string
     */
    static function create(): string
    {
        if (Tools::isAuth()) {
            Tools::redirect('/');
        }

        $smarty = new AdHocSmarty();

        //$smarty->enqueue_script('/js/geopicker.js');
        $smarty->enqueue_script('/js/membre-create.js');

        $smarty->assign('title', "Inscription à l'association AD'HOC");
        $smarty->assign('description', "Association oeuvrant pour le développement de la vie musicale en Essonne depuis 1996. Promotion d'artistes, Pédagogie musicale, Agenda concerts, Communauté de musiciens ...");

        Trail::getInstance()
            ->addStep("Inscription");

        $smarty->assign('create', (bool) Route::params('create'));

        // valeurs par défaut
        $data = [
            'pseudo'         => '',
            'email'          => '',
            'mailing'        => true,
            'csrf'           => '',
        ];

        if (Tools::isSubmit('form-member-create')) {

            $data = [
                'pseudo'         => trim((string) Route::params('pseudo')),
                'email'          => trim(strtolower((string) Route::params('email'))),
                'mailing'        => (bool) Route::params('mailing'),
                'csrf'           => '',
            ];
            $errors = [];

            if (self::_validateMemberCreateForm($data, $errors)) {

                $data['password'] = Tools::generatePassword(12);

                if (empty($errors)) {

                    $membre = Membre::init()
                        ->setEmail($data['email'])
                        ->setPseudo($data['pseudo'])
                        ->setPassword($data['password'])
                        ->setMailing($data['mailing'])
                        ->setLevel(Membre::TYPE_STANDARD);

                    if ($membre->save()) {
                        Log::action(Log::ACTION_MEMBER_CREATE, $membre->getId());
                        if (Email::send($data['email'], "Inscription à l'Association AD'HOC", 'member-create', $data)) {
                            Tools::redirect('/membres/create?create=1');
                        } else {
                            $smarty->assign('password', $data['password']); // DEBUG ONLY
                            $errors['generic'] = true;
                        }
                    } else {
                        $errors['generic'] = true;
                    }

                }

            }

            if (!empty($errors)) {
                foreach ($errors as $k => $v) {
                    $smarty->assign('error_' . $k, $v);
                }
            }

        }

        $smarty->assign('data', $data);

        return $smarty->fetch('membres/create.tpl');
    }

    /**
     * Édition d'un membre
     *
     * @return string
     */
    static function edit(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $id = $_SESSION['membre']->getId();
        
        Trail::getInstance()
            ->addStep('Tableau de bord', '/membres/tableau-de-bord')
            ->addStep('Mes Infos Persos');

        $smarty = new AdHocSmarty();

        $smarty->enqueue_script('/js/geopicker.js');
        $smarty->enqueue_script('/js/membre-edit.js');

        if (Tools::isSubmit('form-member-edit')) {
            $member = $_SESSION['membre'];

            $data = [
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
            ];
            $errors = [];

            if (self::_validateMemberEditForm($data, $errors)) {

                $member->setLastName($data['last_name'])
                    ->setFirstName($data['first_name'])
                    ->setAddress($data['address'])
                    ->setCp($data['cp'])
                    ->setCity($data['city'])
                    ->setCountry($data['country'])
                    ->setIdCity($data['id_city'])
                    ->setIdDepartement($data['id_departement'])
                    ->setIdRegion($data['id_region'])
                    ->setIdCountry($data['id_country'])
                    ->setTel($data['tel'])
                    ->setPort($data['port'])
                    ->setText($data['text'])
                    ->setEmail($data['email'])
                    ->setSite($data['site'])
                    ->setMailing($data['mailing']);

                $member->save();

                if ($member->isInterne()) {
                    $forum = Route::params('forum');
                    ForumPrive::delAllSubscriptions($member->getId());
                    if (is_array($forum)) {
                        foreach ($forum as $f => $val) {
                            if ($val === 'on') {
                                ForumPrive::addSubscriberToForum($member->getId(), $f);
                            }
                        }
                    }
                }

                /* traitement de la photo officielle envoyée (112*174) */
                if ($member->isInterne()) {
                    if (is_uploaded_file($_FILES['photo']['tmp_name'])) {
                        (new Image($_FILES['photo']['tmp_name']))
                            ->setType(IMAGETYPE_JPEG)
                            ->setMaxWidth(112)
                            ->setMaxHeight(174)
                            ->setDestFile(Membre::getBasePath() . '/ca/' . $_SESSION['membre']->getId() . '.jpg')
                            ->write();
                    }
                }

                /* traitement de l'avatar (112*---) */
                if (is_uploaded_file($_FILES['avatar']['tmp_name'])) {
                    (new Image($_FILES['avatar']['tmp_name']))
                        ->setType(IMAGETYPE_JPEG)
                        ->setMaxWidth(112)
                        ->setMaxHeight(250)
                        ->setDestFile(Membre::getBasePath() . '/' . $_SESSION['membre']->getId() . '.jpg')
                        ->write();
                }

                Log::action(Log::ACTION_MEMBER_EDIT, $member->getId());

                $smarty->assign('updated_ok', true);

            } else {

                if (!empty($errors)) {
                    foreach ($errors as $k => $v) {
                        $smarty->assign('error_' . $k, $v);
                    }
                }

            }
        }

        $smarty->assign('membre', $_SESSION['membre']);

        if ($_SESSION['membre']->isInterne()) {
            $smarty->assign('forum', ForumPrive::getSubscribedForums($_SESSION['membre']->getId()));
        }

        return $smarty->fetch('membres/edit.tpl');
    }

    /**
     * Suppression d'un membre
     *
     * @return string
     */
    static function delete(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $id = $_SESSION['membre']->getId();

        $smarty = new AdHocSmarty();

        try {
            $membre = Membre::getInstance($id);
        } catch (Exception $e) {
            Route::set_http_code('404');
            $smarty->assign('unknown_member', true);
            return $smarty->fetch('membres/delete.tpl');
        }

        if (Tools::isSubmit('form-member-delete')) {
            // effacement du membre
            if ($membre->delete()) {
                Log::action(Log::ACTION_MEMBER_DELETE, $id);

                // destruction de la session
                $_SESSION = [];
                if (ini_get("session.use_cookies")) {
                    $params = session_get_cookie_params();
                    setcookie(
                        session_name(), '', time() - 42000,
                        $params["path"], $params["domain"],
                        $params["secure"], $params["httponly"]
                    );
                }
                session_destroy();

                Tools::redirect('/?member-deleted');
            }
        }

        $smarty->assign('membre', $membre);

        return $smarty->fetch('membres/delete.tpl');
    }

    /**
     * Retourne un tableau de pseudos vérifiant un pattern
     *
     * @return array
     */
    static function autocompletePseudo(): array
    {
        $q = trim((string) Route::params('q'));

        if (strlen($q) < 1) {
            return [];
        }

        $db = DataBase::getInstance();

        $sql = "SELECT `id_contact`, `pseudo` "
             . "FROM `adhoc_membre` "
             . "WHERE `pseudo` LIKE '" . $db->escape($q) . "%' "
             . "ORDER BY `pseudo` ASC "
             . "LIMIT 0, 10";

        return $db->queryWithFetch($sql);
    }

    /**
     * Tableau de bord
     *
     * @return string
     */
    static function tableauDeBord(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        Trail::getInstance()
            ->addStep('Tableau de bord');

        $smarty = new AdHocSmarty();

        $smarty->assign('groupes', Groupe::getMyGroupes());

        $smarty->assign(
            'photos', Photo::getPhotos(
                [
                    'contact' => $_SESSION['membre']->getId(),
                    'limit'   => 4,
                    'debut'   => 0,
                    'sort'    => 'id',
                    'sens'    => 'DESC',
                ]
            )
        );
        $smarty->assign('nb_photos', Photo::getMyPhotosCount());

        $smarty->assign(
            'videos', Video::getVideos(
                [
                    'contact' => $_SESSION['membre']->getId(),
                    'limit'   => 4,
                    'debut'   => 0,
                    'sort'    => 'id',
                    'sens'    => 'DESC',
                ]
            )
        );
        $smarty->assign('nb_videos', Video::getMyVideosCount());

        $smarty->assign(
            'audios', Audio::getAudios(
                [
                    'contact' => $_SESSION['membre']->getId(),
                    'debut'   => 0,
                    'limit'   => 5,
                    'sort'    => 'id',
                    'sens'    => 'DESC',
                ]
            )
        );
        $smarty->assign('nb_audios', Audio::getMyAudiosCount());

        $db = DataBase::getInstance();

        $sql = "SELECT `p`.`id_pm` AS `id`, `m`.`pseudo`, `p`.`id_from`, `p`.`date`, `p`.`read_to`, `p`.`text` "
             . "FROM `adhoc_messagerie` `p`, `adhoc_membre` `m` "
             . "WHERE `p`.`id_from` = `m`.`id_contact` "
             . "AND `p`.`id_to` = " . (int) $_SESSION['membre']->getId() . " "
             . "AND `p`.`del_to` = FALSE "
             . "ORDER BY `p`.`date` DESC "
             . "LIMIT 0, 5";

        $smarty->assign('inbox', $db->queryWithFetch($sql));

        $smarty->assign('alerting_groupes', Alerting::getGroupesAlertingByIdContact($_SESSION['membre']->getId()));
        $smarty->assign('alerting_lieux', Alerting::getLieuxAlertingByIdContact($_SESSION['membre']->getId()));
        $smarty->assign('alerting_events', Alerting::getEventsAlertingByIdContact($_SESSION['membre']->getId()));

        return $smarty->fetch('membres/tableau-de-bord.tpl');
    }

    /**
     * Validation du formulaire de création membre
     *
     * @param array $data   tableau des données
     * @param array $errors tableau des erreurs (par référence)
     *
     * @return bool
     */
    private static function _validateMemberCreateForm(array $data, array &$errors): bool
    {
        if (empty($data['email'])) {
            $errors['email'] = true;
        } elseif (!Email::validate($data['email'])) {
            $errors['email'] = true;
        }

        if (empty($data['pseudo'])) {
            $errors['pseudo'] = true;
        } elseif (!Membre::isPseudoAvailable($data['pseudo'])) {
            $errors['pseudo_unavailable'] = true;
        }
        if ($id_contact = Contact::getIdByEmail($data['email'])) {
            // si déjà Contact, pas un problème
            if ($pseudo = Membre::getPseudoById($id_contact)) {
                // si déjà Membre oui
                $errors['already_member'] = $pseudo;
            }
        }
        if (count($errors)) {
            return false;
        }
        return true;
    }

    /**
     * Validation du formulaire de modification membre
     *
     * @param array $data   tableau des données
     * @param array $errors tableau des erreurs (par référence)
     *
     * @return bool
     */
    private static function _validateMemberEditForm(array $data, array &$errors): bool
    {
        if (empty($data['email'])) {
            $errors['email'] = true;
        } elseif (!Email::validate($data['email'])) {
            $errors['email'] = true;
        }
        if (empty($data['id_country'])) {
            $errors['id_country'] = true;
        }
        if (count($errors)) {
            return false;
        }
        return true;
    }
}
