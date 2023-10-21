<?php

declare(strict_types=1);

namespace Adhoc\Controller;

final class Controller
{
    /**
     * @return string
     */
    public static function assoce(): string
    {
        $smarty = new AdHocSmarty();

        Trail::getInstance()->addStep("L'Association");

        return $smarty->fetch('assoce/presentation.tpl');
    }

    /**
     * @return string
     */
    public static function concerts(): string
    {
        $smarty = new AdHocSmarty();

        Trail::getInstance()->addStep("Concerts");

        $smarty->enqueue_script('/js/masonry-4.2.2.min.js');
        $smarty->enqueue_script('/js/imagesloaded-4.1.4.min.js');

        $smarty->enqueue_script('/js/assoce-concerts.js');

        // tri antéchrono des saisons
        $smarty->assign('events', array_reverse(Event::getAdHocEventsBySeason()));

        return $smarty->fetch('assoce/concerts.tpl');
    }

    /**
     * @return string
     */
    public static function afterworks(): string
    {
        $smarty = new AdHocSmarty();

        Trail::getInstance()->addStep("Afterworks");

        return $smarty->fetch('assoce/afterworks.tpl');
    }

    /**
     * @return string
     */
    public static function afterworksInscription(): string
    {
        $smarty = new AdHocSmarty();

        $smarty->enqueue_script('/js/assoce/afterworks/inscription.js');

        Trail::getInstance()
            ->addStep("Afterworks")
            ->addStep("Inscription");

        if (!Tools::isSubmit('form-afterworks')) {
            $smarty->assign('show_form', true);

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
            if (!empty($_SESSION['membre'])) {
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

            $errors = [];

            self::validateAfterworksForm($data, $errors);

            if (empty($errors)) {
                $data['photo_url'] = '';
                if (is_uploaded_file($_FILES['photo']['tmp_name'])) {
                    $outputFile = MEDIA_PATH . "/afterworks/" . md5($data['email']) . "-" . time() . ".jpg";
                    $data['photo_url'] = MEDIA_URL . "/afterworks/" . md5($data['email']) . "-" . time() . ".jpg";
                    $smarty->assign('photo_url', $data['photo_url']);
                    move_uploaded_file($_FILES['photo']['tmp_name'], $outputFile);
                }

                // 1. envoi du mail aux destinataires
                $data['email_reply_to'] = $data['email'];
                $data['subject'] = "Inscription Afterwork S5E6 - online";
                if (Email::send(CONTACT_FORM_TO, $data['subject'], 'form-afterworks-to', $data)) {
                    $smarty->assign('sent_ok', true);
                } else {
                    $smarty->assign('sent_ko', true);
                }

                // 2. envoi de la copie à l'expéditeur
                $data['email_reply_to'] = 'contact@adhocmusic.com';
                if (Email::send($data['email'], "[cc] " . $data['subject'], 'form-afterworks-cc', $data)) {
                }
            } else {
                // erreur dans le form
                $smarty->assign('sent_ko', true);
                $smarty->assign('show_form', true);
                foreach ($errors as $k => $v) {
                    $smarty->assign('error_' . $k, $v);
                }
            }
        }

        $smarty->assign('name', $data['name']);
        $smarty->assign('email', $data['email']);
        $smarty->assign('date', $data['date']);
        $smarty->assign('h1930-2030', $data['h1930-2030']);
        $smarty->assign('h2030-2130', $data['h2030-2130']);
        $smarty->assign('h2130-2230', $data['h2130-2230']);
        $smarty->assign('creneaux', $data['creneaux']);
        $smarty->assign('instrument', $data['instrument']);
        $smarty->assign('text', $data['text']);
        $smarty->assign('check', $data['check']);

        return $smarty->fetch('assoce/afterworks/inscription.tpl');
    }

    /**
     * @return string
     */
    public static function festival(): string
    {
        $smarty = new AdHocSmarty();

        Trail::getInstance()->addStep("Festival");

        return $smarty->fetch('assoce/festival.tpl');
    }

    /**
     * @return string
     */
    public static function equipe(): string
    {
        $smarty = new AdHocSmarty();

        Trail::getInstance()->addStep("Équipe");

        $smarty->assign('membres', MembreAdhoc::getStaff(true));

        return $smarty->fetch('assoce/equipe.tpl');
    }

    /**
     * Routine de validation des données du formulaire
     *
     * @param array $data   tableau des données
     * @param array $errors tableau des erreurs (par référence)
     *
     * @return bool
     */
    private static function validateAfterworksForm(array $data, array &$errors): bool
    {
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
        return true;
    }
}
