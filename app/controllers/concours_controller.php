<?php

class Controller
{
    static function index()
    {
        return '';
    }

    static function ou_est_pidou()
    {
        if (!empty($_POST)) {
            Log::write('ou-est-pidou', print_r($_POST, true));            
            $subject ='participation ou-est-pidou';
            mail('guillaume.seznec@gmail.com', $subject, print_r($_POST, true));
            return 'OK';
        }

        $trail = Trail::getInstance();
        $trail->addStep("Concours", "/concours");
        $trail->addStep("Où est Pidou ?");

        $smarty = new AdHocSmarty();

        $smarty->assign('title', 'Où est Pidou ?');
        $smarty->assign('description', "Avant de décoller loin d'Epinay avec une programmation World Music ce samedi 21 janvier 2017, nous vous proposons de partir à la recherche de cette salle sur la carte de la ville. Oui, mais une carte datant de 1897");
        $smarty->assign('og_image', 'https://adhocmusic.com/img/concours/epinay-980-old.jpg');

        $smarty->enqueue_script('/js/concours-ou-est-pidou.js');
        $smarty->enqueue_style('/css/concours-ou-est-pidou.css');

        return $smarty->fetch('concours/ou-est-pidou.tpl');
    }

    static function ou_est_pidou_get_target()
    {
    }

    static function ou_est_pidou_set_target()
    {
    }
}

