<?php

class Controller
{
    public static function index()
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'groupes');

        $trail = Trail::getInstance();
        $trail->addStep("Groupes", "/groupes/");

        return $smarty->fetch('exposants/index.tpl');
    }

    public static function show()
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'groupes');
            
        $trail = Trail::getInstance();
        $trail->addStep("Groupes", "/groupes/");
        
        return $smarty->fetch('exposants/show.tpl');
    }
}

