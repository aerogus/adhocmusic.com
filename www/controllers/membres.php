<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\Alerting;
use Adhoc\Model\Audio;
use Adhoc\Model\Contact;
use Adhoc\Model\Event;
use Adhoc\Model\Groupe;
use Adhoc\Model\ForumPrive;
use Adhoc\Model\Lieu;
use Adhoc\Model\Membre;
use Adhoc\Model\Photo;
use Adhoc\Model\Video;
use Adhoc\Utils\AdHocTwig;
use Adhoc\Utils\DataBase;
use Adhoc\Utils\Email;
use Adhoc\Utils\Image;
use Adhoc\Utils\Log;
use Adhoc\Utils\Route;
use Adhoc\Utils\Tools;

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

        $twig = new AdHocTwig();

        $breadcrumb = [
            ['title' => '🏠', 'link' => '/'],
            ['title' => 'Membres', 'link' => '/membres'],
        ];

        try {
            $membre = Membre::getInstance($id);
        } catch (\Exception $e) {
            Route::setHttpCode(404);
            $twig->assign('unknown_member', true);
            return $twig->render('membres/show.twig');
        }

        $twig->assign('membre', $membre);
        $breadcrumb[] = $membre->getPseudo();

        $twig->assign('breadcrumb', $breadcrumb);
        $twig->assign('title', "♫ Profil de " . $membre->getPseudo());
        $twig->assign('description', "♫ Profil de " . $membre->getPseudo());

        $twig->assign('groupes', $membre->getGroupes());

        return $twig->render('membres/show.twig');
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

        $twig = new AdHocTwig();

        $twig->enqueueScript('/js/membres/create.js');

        $twig->assign('title', "Inscription à l'association AD'HOC");
        $twig->assign('description', "Association oeuvrant pour le développement de la vie musicale en Essonne depuis 1996. Promotion d'artistes, Pédagogie musicale, Agenda concerts, Communauté de musiciens ...");

        $twig->assign('breadcrumb', [
            ['title' => '🏠', 'link' => '/'],
            'Créer un compte',
        ]);

        $twig->assign('create', (bool) Route::params('create'));

        // valeurs par défaut
        $data = [
            'pseudo' => '',
            'email' => '',
            'mailing' => false,
            'csrf' => '',
        ];

        if (Tools::isSubmit('form-member-create')) {
            $data = [
                'pseudo' => trim((string) Route::params('pseudo')),
                'email' => trim(strtolower((string) Route::params('email'))),
                'mailing' => (bool) Route::params('mailing'),
                'csrf' => '',
            ];

            $errors = self::validateMemberCreateForm($data);
            if (count($errors) === 0) {
                $data['password'] = Tools::generatePassword(12);

                $id_contact = Contact::getIdByEmail($data['email']);
                if ($id_contact === false) {
                    $contact = new Contact();
                    $contact->setEmail($data['email']);
                    $contact->save();
                    $id_contact = $contact->getIdContact();
                }
                $membre = (new Membre())
                    ->setIdContact($id_contact)
                    ->setPseudo($data['pseudo'])
                    ->setPassword($data['password'])
                    ->setMailing($data['mailing'])
                    ->setLevel(Membre::TYPE_STANDARD);

                if ($membre->save()) {
                    try {
                        if (Email::send($data['email'], "Inscription à l'association AD'HOC", 'member-create', $data)) {
                            Log::success("Création d'un compte membre: " . $membre->getIdContact());
                            Tools::redirect('/membres/create?create=1');
                        } else {
                            $errors['generic'] = true;
                            Log::error('membre create error 1');
                        }
                    } catch (\Exception $e) {
                        $errors['generic'] = true;
                        Log::error($e->getMessage());
                    }
                } else {
                    $errors['generic'] = true;
                    Log::error('membre create error 2');
                }
            } else {
                Log::error("Création d'un compte membre. " . print_r($data, true));
            }

            if (count($errors) > 0) {
                foreach ($errors as $k => $v) {
                    $twig->assign('error_' . $k, $v);
                }
            }
        }

        $twig->assign('data', $data);

        return $twig->render('membres/create.twig');
    }

    /**
     * Édition d'un membre
     *
     * @return string
     */
    public static function edit(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $id = $_SESSION['membre']->getIdContact();

        $twig = new AdHocTwig();

        $twig->assign('breadcrumb', [
            ['title' => '🏠', 'link' => '/'],
            ['title' => 'Tableau de bord', 'link' => '/membres/tableau-de-bord'],
            'Mes Infos Persos',
        ]);

        $twig->enqueueScript('/js/geopicker.js');
        $twig->enqueueScript('/js/membres/edit.js');

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

            $errors = self::validateMemberEditForm($data);
            if (count($errors) === 0) {
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
                    ->setSite($data['site'])
                    ->setMailing($data['mailing'])
                    ->save();

                $member->getContact()
                    ->setEmail($data['email'])
                    ->save();

                if ($member->isInterne()) {
                    $forum = Route::params('forum');
                    ForumPrive::delAllSubscriptions($member->getIdContact());
                    if (is_array($forum)) {
                        foreach ($forum as $f => $val) {
                            if ($val === 'on') {
                                ForumPrive::addSubscriberToForum($member->getIdContact(), $f);
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
                            ->setDestFile(Membre::getBasePath() . '/ca/' . $_SESSION['membre']->getIdContact() . '.jpg')
                            ->write();
                    }
                }

                /* traitement de l'avatar (112*---) */
                if (is_uploaded_file($_FILES['avatar']['tmp_name'])) {
                    (new Image($_FILES['avatar']['tmp_name']))
                        ->setType(IMAGETYPE_JPEG)
                        ->setMaxWidth(112)
                        ->setMaxHeight(250)
                        ->setDestFile(Membre::getBasePath() . '/' . $_SESSION['membre']->getIdContact() . '.jpg')
                        ->write();
                }

                Log::info("Édition d'un compte membre: " . $member->getIdContact());

                $twig->assign('updated_ok', true);
            } else {
                foreach ($errors as $k => $v) {
                    $twig->assign('error_' . $k, $v);
                }
            }
        }

        $twig->assign('membre', $_SESSION['membre']);

        if ($_SESSION['membre']->isInterne()) {
            $twig->assign('forum', ForumPrive::getSubscribedForums($_SESSION['membre']->getIdContact()));
        }

        $twig->enqueueScriptVars(
            [
                'id_lieu' => 0,
                'id_country' => $_SESSION['membre']->getIdCountry(),
                'id_region' => $_SESSION['membre']->getIdRegion(),
                'id_departement' => $_SESSION['membre']->getIdDepartement(),
                'id_city' => $_SESSION['membre']->getIdCity(),
            ]
        );

        return $twig->render('membres/edit.twig');
    }

    /**
     * Suppression d'un membre
     *
     * @return string
     */
    public static function delete(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $id = $_SESSION['membre']->getIdContact();

        $twig = new AdHocTwig();

        try {
            $membre = Membre::getInstance($id);
        } catch (\Exception $e) {
            Route::setHttpCode(404);
            $twig->assign('unknown_member', true);
            return $twig->render('membres/delete.twig');
        }

        if (Tools::isSubmit('form-member-delete')) {
            // effacement du membre
            if ($membre->delete()) {
                Log::info("Suppression d'un membre: " . $id);

                $membre->getContact()->delete();

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

        $twig->assign('membre', $membre);

        return $twig->render('membres/delete.twig');
    }

    /**
     * Retourne un tableau de pseudos vérifiant un pattern
     *
     * @return array<array<string,mixed>>
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
             . "WHERE `pseudo` LIKE '" . $q . "%' "
             . "ORDER BY `pseudo` ASC "
             . "LIMIT 0, 10";

        return $db->pdo->query($sql)->fetchAll();
    }

    /**
     * Tableau de bord
     *
     * @return string
     */
    public static function tableauDeBord(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $twig = new AdHocTwig();

        $twig->assign('breadcrumb', [
            ['title' => '🏠', 'link' => '/'],
            'Tableau de bord',
        ]);

        $db = DataBase::getInstance();

        $sql = "SELECT `p`.`id_message` AS `id`, `m`.`pseudo`, `p`.`id_from`, `p`.`date`, `p`.`read_to`, `p`.`text` "
             . "FROM `adhoc_messagerie` `p`, `adhoc_membre` `m` "
             . "WHERE `p`.`id_from` = `m`.`id_contact` "
             . "AND `p`.`id_to` = " . (int) $_SESSION['membre']->getIdContact() . " "
             . "AND `p`.`del_to` = FALSE "
             . "ORDER BY `p`.`date` DESC "
             . "LIMIT 0, 5";

        $inbox = $db->pdo->query($sql)->fetchAll();
        $twig->assign('inbox', $inbox);

        $myAlerting = Alerting::find([
            'id_contact' => $_SESSION['membre']->getIdContact(),
        ]);
        $myAlertingLieu = $myAlertingGroupe = $myAlertingEvent =  [];
        foreach ($myAlerting as $ma) {
            if (!is_null($ma->getIdLieu())) {
                $myAlertingLieu[] = Lieu::getInstance($ma->getIdLieu());
            } elseif (!is_null($ma->getIdGroupe())) {
                $myAlertingGroupe[] = Groupe::getInstance($ma->getIdGroupe());
            } elseif (!is_null($ma->getIdEvent())) {
                $myAlertingEvent[] = Event::getInstance($ma->getIdEvent());
            }
        }

        $twig->assign('alerting_groupes', $myAlertingGroupe);
        $twig->assign('alerting_events', $myAlertingEvent);
        $twig->assign('alerting_lieux', $myAlertingLieu);

        $twig->assign(
            'groupes',
            Groupe::find(
                ['id_contact' => $_SESSION['membre']->getIdContact()]
            )
        );
        $twig->assign('nb_photos', Photo::countMy());
        $twig->assign('nb_videos', Video::countMy());
        $twig->assign('nb_audios', Audio::countMy());

        return $twig->render('membres/tableau-de-bord.twig');
    }

    /**
     * Validation du formulaire de création membre
     *
     * @param array<string,mixed> $data tableau des données
     *
     * @return array<string,mixed>
     */
    private static function validateMemberCreateForm(array $data): array
    {
        $errors = [];

        if (!isset($data['email'])) {
            $errors['email'] = true;
        } elseif (mb_strlen($data['email']) < 3) {
            $errors['email'] = true;
        } elseif (mb_strlen($data['email']) > 50) {
            $errors['email'] = true;
        } elseif (!Email::validate($data['email'])) {
            $errors['email'] = true;
        }

        if (!isset($data['pseudo'])) {
            $errors['pseudo'] = true;
        } elseif (mb_strlen($data['pseudo']) === 0) {
            $errors['pseudo'] = true;
        } elseif (mb_strlen($data['pseudo']) > 50) {
            $errors['pseudo'] = true;
        } elseif (!Membre::isPseudoAvailable($data['pseudo'])) {
            $errors['pseudo_unavailable'] = true;
        }

        if (count($errors) > 0) {
            return $errors;
        }

        if ($id_contact = Contact::getIdByEmail($data['email'])) {
            // si déjà Contact, pas un problème
            if ($pseudo = Membre::getPseudoById($id_contact)) {
                // si déjà Membre oui
                $errors['already_member'] = $pseudo;
            }
        }

        return $errors;
    }

    /**
     * Validation du formulaire de modification membre
     *
     * @param array<string,mixed> $data tableau des données
     *
     * @return array<string,true>
     */
    private static function validateMemberEditForm(array $data): array
    {
        $errors = [];

        if (!isset($data['email'])) {
            $errors['email'] = true;
        } elseif (strlen($data['email']) === 0) {
            $errors['email'] = true;
        } elseif (!Email::validate($data['email'])) {
            $errors['email'] = true;
        }

        if (!isset($data['id_country'])) {
            $errors['id_country'] = true;
        } elseif (strlen($data['id_country']) === 0) {
            $errors['id_country'] = true;
        }

        return $errors;
    }
}
