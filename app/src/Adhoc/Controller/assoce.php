<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\Event;
use Adhoc\Model\MembreAdhoc;
use Adhoc\Utils\AdHocTwig;
use Adhoc\Utils\Email;
use Adhoc\Utils\Route;
use Adhoc\Utils\Tools;
use Adhoc\Utils\Trail;

final class Controller
{
    /**
     * @return string
     */
    public static function assoce(): string
    {
        $twig = new AdHocTwig();

        Trail::getInstance()->addStep("L'Association");

        return $twig->render('assoce/presentation.twig');
    }

    /**
     * @return string
     */
    public static function concerts(): string
    {
        $twig = new AdHocTwig();

        Trail::getInstance()->addStep("Concerts");

        $twig->enqueueScript('/static/library/masonry@4.2.2/masonry.min.js');
        $twig->enqueueScript('/js/imagesloaded-4.1.4.min.js');

        $twig->enqueueScript('/js/assoce-concerts.js');

        // tri antéchrono des saisons
        $twig->assign('events', array_reverse(Event::getAdHocEventsBySeason()));

        return $twig->render('assoce/concerts.twig');
    }

    /**
     * @return string
     */
    public static function afterworks(): string
    {
        $twig = new AdHocTwig();

        Trail::getInstance()->addStep("Afterworks");

        return $twig->render('assoce/afterworks.twig');
    }

    /**
     * @return string
     */
    public static function afterworksInscription(): string
    {
        $twig = new AdHocTwig();

        $twig->enqueueScript('/js/assoce/afterworks/inscription.js');

        Trail::getInstance()
            ->addStep("Afterworks")
            ->addStep("Inscription");

        if (!Tools::isSubmit('form-afterworks')) {
            $twig->assign('show_form', true);

            // valeurs par défaut
            $data = [
                'name' => '',
                'email' => '',
                'date' => '',
                'h1930-2030' => '',
                'h2030-2130' => '',
                'h2130-2230' => '',
                'creneaux' => '',
                'instrument' => '',
                'text' => '',
                'check' => Tools::getCSRFToken(),
            ];

            // si identifié, préremplissage de certains champs
            if (isset($_SESSION['membre'])) {
                if ($_SESSION['membre']->getFirstName() || $_SESSION['membre']->getLastName()) {
                    $data['name'] = $_SESSION['membre']->getFirstName() . ' ' . $_SESSION['membre']->getLastName() . ' (' . $_SESSION['membre']->getPseudo() . ')';
                } else {
                    $data['name'] = $_SESSION['membre']->getPseudo();
                }
                $data['email'] = $_SESSION['membre']->getEmail();
            }
        } else {
            $data = [
                'name'    => trim((string) Route::params('name')),
                'email'   => trim((string) Route::params('email')),
                'date' => trim((string) Route::params('date')),
                'h1930-2030' => trim((string) Route::params('h1930-2030')),
                'h2030-2130' => trim((string) Route::params('h2030-2130')),
                'h2130-2230' => trim((string) Route::params('h2130-2230')),
                'instrument' => trim((string) Route::params('instrument')),
                'text'    => trim((string) Route::params('text')),
                'check'   => (string) Route::params('check'),
            ];
            $data['creneaux'] = [];
            if ($data['h1930-2030']) {
                $data['creneaux'][] = '19h30-20h30';
            }
            if ($data['h2030-2130']) {
                $data['creneaux'][] = '20h30-21h30';
            }
            if ($data['h2130-2230']) {
                $data['creneaux'][] = '21h30-22h30';
            }
            $data['creneaux'] = implode(', ', $data['creneaux']);

            $errors = self::validateAfterworksForm($data);
            if (count($errors) === 0) {
                $data['photo_url'] = '';
                if (is_uploaded_file($_FILES['photo']['tmp_name'])) {
                    $outputFile = MEDIA_PATH . "/afterworks/" . md5($data['email']) . "-" . time() . ".jpg";
                    $data['photo_url'] = MEDIA_URL . "/afterworks/" . md5($data['email']) . "-" . time() . ".jpg";
                    $twig->assign('photo_url', $data['photo_url']);
                    move_uploaded_file($_FILES['photo']['tmp_name'], $outputFile);
                }

                // 1. envoi du mail aux destinataires
                $data['email_reply_to'] = $data['email'];
                $data['subject'] = "Inscription Afterwork S5E6 - online";
                if (Email::send(CONTACT_FORM_TO, $data['subject'], 'form-afterworks-to', $data)) {
                    $twig->assign('sent_ok', true);
                } else {
                    $twig->assign('sent_ko', true);
                }

                // 2. envoi de la copie à l'expéditeur
                $data['email_reply_to'] = 'contact@adhocmusic.com';
                if (Email::send($data['email'], "[cc] " . $data['subject'], 'form-afterworks-cc', $data)) {
                }
            } else {
                // erreur dans le form
                $twig->assign('sent_ko', true);
                $twig->assign('show_form', true);
                foreach ($errors as $k => $v) {
                    $twig->assign('error_' . $k, $v);
                }
            }
        }

        $twig->assign('name', $data['name']);
        $twig->assign('email', $data['email']);
        $twig->assign('date', $data['date']);
        $twig->assign('h1930-2030', $data['h1930-2030']);
        $twig->assign('h2030-2130', $data['h2030-2130']);
        $twig->assign('h2130-2230', $data['h2130-2230']);
        $twig->assign('creneaux', $data['creneaux']);
        $twig->assign('instrument', $data['instrument']);
        $twig->assign('text', $data['text']);
        $twig->assign('check', $data['check']);

        return $twig->render('assoce/afterworks/inscription.twig');
    }

    /**
     * @return string
     */
    public static function festival(): string
    {
        $twig = new AdHocTwig();

        Trail::getInstance()->addStep("Festival");

        return $twig->render('assoce/festival.twig');
    }

    /**
     * @return string
     */
    public static function equipe(): string
    {
        $twig = new AdHocTwig();

        Trail::getInstance()->addStep("Équipe");

        $twig->assign('membres', MembreAdhoc::getStaff(true));

        return $twig->render('assoce/equipe.twig');
    }

    /**
     * Routine de validation des données du formulaire
     *
     * @param array<string,mixed> $data tableau des données
     *
     * @return array<string,string>
     */
    private static function validateAfterworksForm(array $data): array
    {
        $errors = [];

        if (empty($data['name'])) {
            $errors['name'] = "Vous devez renseigner votre nom";
        }
        if (empty($data['email'])) {
            $errors['email'] = "Vous devez préciser votre email";
        } elseif (!Email::validate($data['email'])) {
            $errors['email'] = "Votre email semble invalide ...";
        }
        if (empty($data['date'])) {
            $errors['subject'] = "Vous devez saisir une date";
        }
        if (
               empty($data['h1930-2030'])
            && empty($data['h2030-2130'])
            && empty($data['h2130-2230'])
        ) {
            $errors['hour'] = "Vous devez saisir au moins un créneau";
        }
        if (!Tools::checkCSRFToken($data['check'])) {
            $errors['check'] = "Code de vérification invalide";
        }

        return $errors;
    }
}
