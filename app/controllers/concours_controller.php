<?php

class Controller
{
    static function index()
    {
        return '';
    }

    static function ou_est_pidou()
    {
        $trail = Trail::getInstance();
        $trail->addStep("Concours", "/concours");
        $trail->addStep("Où est Pidou ?");

        $smarty = new AdHocSmarty();

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

