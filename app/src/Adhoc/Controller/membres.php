<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\AdHocSmarty;

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
    public static function show(): string
    {
        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance()
            ->addStep('Membres', '/membres');

        try {
            $membre = Membre::getInstance($id);
        } catch (\Exception $e) {
            Route::setHttpCode(404);
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
    public static function create(): string
    {
        if (Tools::isAuth()) {
            Tools::redirect('/');
        }

        $smarty = new AdHocSmarty();

        $smarty->enqueueScript('/js/membres/create.js');

        $smarty->assign('title', "Inscription à l'association AD'HOC");
        $smarty->assign('description', "Association oeuvrant pour le développement de la vie musicale en Essonne depuis 1996. Promotion d'artistes, Pédagogie musicale, Agenda concerts, Communauté de musiciens ...");

        Trail::getInstance()
            ->addStep('Créer un compte');

        $smarty->assign('create', (bool) Route::params('create'));

        // valeurs par défaut
        $data = [
            'pseudo'  => '',
            'email'   => '',
            'mailing' => false,
            'csrf'    => '',
        ];

        if (Tools::isSubmit('form-member-create')) {
            $data = [
                'pseudo'  => trim((string) Route::params('pseudo')),
                'email'   => trim(strtolower((string) Route::params('email'))),
                'mailing' => (bool) Route::params('mailing'),
                'csrf'    => '',
            ];
            $errors = [];

            if (self::validateMemberCreateForm($data, $errors)) {
                $data['password'] = Tools::generatePassword(12);

                if (empty($errors)) {
                    $membre = (new Membre())
                        ->setEmail($data['email'])
                        ->setPseudo($data['pseudo'])
                        ->setPassword($data['password'])
                        ->setMailing($data['mailing'])
                        ->setLevel(Membre::TYPE_STANDARD);

                    if ($membre->save()) {
                        Log::action(Log::ACTION_MEMBER_CREATE, $membre->getId());
                        if (Email::send($data['email'], "Inscription à l'association AD'HOC", 'member-create', $data)) {
                            Tools::redirect('/membres/create?create=1');
                        } else {
                            $smarty->assign('password', $data['password']); // DEBUG ONLY
                            $errors['generic'] = true;
                        }
                    } else {
                        $errors['generic'] = true;
                    }
                } else {
                    Log::action(Log::ACTION_MEMBER_CREATE, print_r($data, true));
                }
            } else {
                Log::action(Log::ACTION_MEMBER_CREATE, print_r($data, true));
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
    public static function edit(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $id = $_SESSION['membre']->getId();

        Trail::getInstance()
            ->addStep('Tableau de bord', '/membres/tableau-de-bord')
            ->addStep('Mes Infos Persos');

        $smarty = new AdHocSmarty();

        $smarty->enqueueScript('/js/geopicker.js');
        $smarty->enqueueScript('/js/membres/edit.js');

        if (Tools::isSubmit('form-member-edit')) {
            $member = $_SESSION['membre'];

            $data = [
                'last_name' => trim((string) Route::params('last_name')),
                'first_name' => trim((string) Route::params('first_name')),
                'address' => trim((string) Route::params('address')),
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

            if (self::validateMemberEditForm($data, $errors)) {
                $member->setLastName($data['last_name'])
                    ->setFirstName($data['first_name'])
                    ->setAddress($data['address'])
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

        $smarty->enqueueScriptVars(
            [
                'id_lieu' => 0,
                'id_country' => $_SESSION['membre']->getIdCountry(),
                'id_region' => $_SESSION['membre']->getIdRegion(),
                'id_departement' => $_SESSION['membre']->getIdDepartement(),
                'id_city' => $_SESSION['membre']->getIdCity(),
            ]
        );

        return $smarty->fetch('membres/edit.tpl');
    }

    /**
     * Suppression d'un membre
     *
     * @return string
     */
    public static function delete(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $id = $_SESSION['membre']->getId();

        $smarty = new AdHocSmarty();

        try {
            $membre = Membre::getInstance($id);
        } catch (\Exception $e) {
            Route::setHttpCode(404);
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
                        session_name(),
                        '',
                        time() - 42000,
                        $params["path"],
                        $params["domain"],
                        $params["secure"],
                        $params["httponly"]
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
    public static function autocompletePseudo(): array
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
    public static function tableauDeBord(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        Trail::getInstance()
            ->addStep('Tableau de bord');

        $smarty = new AdHocSmarty();

        $db = DataBase::getInstance();

        $sql = "SELECT `p`.`id_pm` AS `id`, `m`.`pseudo`, `p`.`id_from`, `p`.`date`, `p`.`read_to`, `p`.`text` "
             . "FROM `adhoc_messagerie` `p`, `adhoc_membre` `m` "
             . "WHERE `p`.`id_from` = `m`.`id_contact` "
             . "AND `p`.`id_to` = " . (int) $_SESSION['membre']->getId() . " "
             . "AND `p`.`del_to` = FALSE "
             . "ORDER BY `p`.`date` DESC "
             . "LIMIT 0, 5";

        $smarty->assign('inbox', $db->queryWithFetch($sql));

        $myAlerting = Alerting::find(['id_contact' => $_SESSION['membre']->getId()]);
        $myAlertingLieu = $myAlertingGroupe = $myAlertingEvent =  [];
        foreach ($myAlerting as $ma) {
            if ($ma->getIdLieu()) {
                $myAlertingLieu[] = Lieu::getInstance($ma->getIdLieu());
            } elseif ($ma->getIdGroupe()) {
                $myAlertingGroupe[] = Groupe::getInstance($ma->getIdGroupe());
            } elseif ($ma->getIdEvent()) {
                $myAlertingEvent[] = Event::getInstance($ma->getIdEvent());
            }
        }

        $smarty->assign('alerting_groupes', $myAlertingGroupe);
        $smarty->assign('alerting_events', $myAlertingEvent);
        $smarty->assign('alerting_lieux', $myAlertingLieu);

        $smarty->assign(
            'groupes',
            Groupe::find(
                ['id_contact' => $_SESSION['membre']->getId()]
            )
        );
        $smarty->assign('nb_photos', Photo::countMy());
        $smarty->assign('nb_videos', Video::countMy());
        $smarty->assign('nb_audios', Audio::countMy());

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
    private static function validateMemberCreateForm(array $data, array &$errors): bool
    {
        if (empty($data['email'])) {
            $errors['email'] = true;
        } elseif (mb_strlen($data['email']) > 50) {
            $errors['email'] = true;
        } elseif (!Email::validate($data['email'])) {
            $errors['email'] = true;
        }

        if (empty($data['pseudo'])) {
            $errors['pseudo'] = true;
        } elseif (mb_strlen($data['pseudo']) > 50) {
            $errors['pseudo'] = true;
        } elseif (!Membre::isPseudoAvailable($data['pseudo'])) {
            $errors['pseudo_unavailable'] = true;
        }

        if (count($errors)) {
            return false;
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
    private static function validateMemberEditForm(array $data, array &$errors): bool
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
