<?php

class Controller
{
    static function index()
    {
        return self::presentation();
    }

    static function presentation()
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'assoce');

        $trail = Trail::getInstance();
        $trail->addStep("L'Association", "/assoce");
        $trail->addStep("Présentation", "/assoce/presentation");

        $smarty->assign('photos', Photo::getPhotos(array(
            'online' => true,
            'sort'   => 'random',
            'lieu'   => 1,
            'limit'  => 3,
        )));

        $smarty->assign('videos', Video::getVideos(array(
            'online' => true,
            'sort'   => 'random',
            'lieu'   => 1,
            'limit'  => 6,
        )));

        return $smarty->fetch('assoce/presentation.tpl');
    }

    static function concerts()
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'assoce');

        $trail = Trail::getInstance();
        $trail->addStep("L'Association", "/assoce");
        $trail->addStep("Les Concerts", "/assoce/concerts");

        $smarty->assign('photos', Photo::getPhotos(array(
            'online' => true,
            'sort'   => 'random',
            'lieu'   => 1,
            'limit'  => 3,
        )));

        $smarty->assign('videos', Video::getVideos(array(
            'online' => true,
            'sort'   => 'random',
            'lieu'   => 1,
            'limit'  => 6,
        )));

        $smarty->assign('events', array_reverse(Event::getAdHocEventsBySeason(), true));

        return $smarty->fetch('assoce/concerts.tpl');
    }
    
    static function equipe()
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'assoce');

        $trail = Trail::getInstance();
        $trail->addStep("L'Association", "/assoce");
        $trail->addStep("L'Equipe", "/assoce/equipe");

        $smarty->assign('photos', Photo::getPhotos(array(
            'online' => true,
            'sort'   => 'random',
            'lieu'   => 1,
            'limit'  => 3,
        )));

        $smarty->assign('videos', Video::getVideos(array(
            'online' => true,
            'sort'   => 'random',
            'lieu'   => 1,
            'limit'  => 6,
        )));

        $smarty->assign('membres', MembreAdhoc::getStaff(true));
        $smarty->assign('omembres', MembreAdhoc::getStaff(false));

        return $smarty->fetch('assoce/equipe.tpl');
    }

    static function statuts()
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'assoce');

        $trail = Trail::getInstance();
        $trail->addStep("L'Association", "/assoce");
        $trail->addStep("Statuts", "/assoce/statuts");

        $smarty->assign('photos', Photo::getPhotos(array(
            'online' => true,
            'sort'   => 'random',
            'lieu'   => 1,
            'limit'  => 3,
        )));

        $smarty->assign('videos', Video::getVideos(array(
            'online' => true,
            'sort'   => 'random',
            'lieu'   => 1,
            'limit'  => 6,
        )));

        return $smarty->fetch('assoce/statuts.tpl');
    }

    static function recrutement()
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('title', "AD'HOC recrute");
        $smarty->assign('description', "L'association AD'HOC recrute constamment des nouveaux bénévoles afin de mener à bien ses activités");

        $smarty->assign('menuselected', 'assoce');

        $trail = Trail::getInstance();
        $trail->addStep("L'Association", "/assoce/");
        $trail->addStep("Recrutement");

        $smarty->assign('photos', Photo::getPhotos(array(
            'online' => true,
            'sort'   => 'random',
            'lieu'   => 1,
            'limit'  => 3,
        )));

        $smarty->assign('videos', Video::getVideos(array(
            'online' => true,
            'sort'   => 'random',
            'lieu'   => 1,
            'limit'  => 6,
        )));

        return $smarty->fetch('assoce/recrutement.tpl');
    }
}
