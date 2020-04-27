<?php declare(strict_types=1);

final class Controller
{
    /**
     * @return string
     */
    static function assoce(): string
    {
        $smarty = new AdHocSmarty();

        Trail::getInstance()->addStep("L'Association");

        return $smarty->fetch('assoce/presentation.tpl');
    }

    /**
     * @return string
     */
    static function concerts(): string
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
    static function afterworks(): string
    {
        $smarty = new AdHocSmarty();

        Trail::getInstance()->addStep("Afterworks");

        return $smarty->fetch('assoce/afterworks.tpl');
    }

    /**
     * @return string
     */
    static function afterworks_chat(): string
    {
        $smarty = new AdHocSmarty();

        $smarty->enqueue_script('/js/socket.io-2.3.0.min.js');
        $smarty->enqueue_script('/js/assoce/afterworks/chat.js');

        Trail::getInstance()
            ->addStep("Afterworks")
            ->addStep("Chat");

        return $smarty->fetch('assoce/afterworks/chat.tpl');
    }

    /**
     * @return string
     */
    static function afterworks_inscription(): string
    {
        $smarty = new AdHocSmarty();

        $smarty->enqueue_script('/js/assoce/afterworks/inscription.js');

        Trail::getInstance()
            ->addStep("Afterworks")
            ->addStep("Inscription");

        if (!Tools::isSubmit('form-afterworks-inscription')) {

            $smarty->assign('show_form', true);

            // valeurs par défaut
            $data = [
                'name'    => '',
                'email'   => '',
                'subject' => '',
                'text'    => '',
                'check'   => Tools::getCSRFToken(),
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
                'subject' => trim((string) Route::params('subject')),
                'text'    => trim((string) Route::params('text')),
                'check'   => (string) Route::params('check'),
            ];
            $errors = [];

            self::_validateAfterworksInscriptionForm($data, $errors);

            if (empty($errors)) {

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
        $smarty->assign('subject', $data['subject']);
        $smarty->assign('text', $data['text']);
        $smarty->assign('check', $data['check']);

        return $smarty->fetch('assoce/afterworks/inscription.tpl');
    }

    /**
     * @return string
     */
    static function festival(): string
    {
        $smarty = new AdHocSmarty();

        Trail::getInstance()->addStep("Festival");

        return $smarty->fetch('assoce/festival.tpl');
    }

    /**
     * @return string
     */
    static function equipe(): string
    {
        $smarty = new AdHocSmarty();

        Trail::getInstance()->addStep("Équipe");

        $smarty->assign('membres', MembreAdhoc::getStaff(true));

        return $smarty->fetch('assoce/equipe.tpl');
    }
}
