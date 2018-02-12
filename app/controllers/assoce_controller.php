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

        $smarty->enqueue_style('/mediaelement/mediaelementplayer.css');
        $smarty->enqueue_script('/mediaelement/mediaelement-and-player.min.js');
        $smarty->enqueue_script('/js/assoce.js');

        $smarty->assign('menuselected', 'assoce');

        $trail = Trail::getInstance();
        $trail->addStep("L'Association", "/assoce");
        $trail->addStep("Présentation");

        $smarty->assign('photos', Photo::getPhotos([
            'online' => true,
            'sort'   => 'random',
            'lieu'   => 1,
            'limit'  => 3,
        ]));

        $smarty->assign('videos', Video::getVideos([
            'online' => true,
            'sort'   => 'random',
            'lieu'   => 1,
            'limit'  => 6,
        ]));

        return $smarty->fetch('assoce/presentation.tpl');
    }

    static function concerts()
    {
        $smarty = new AdHocSmarty();

        $smarty->enqueue_style('/mediaelement/mediaelementplayer.css');
        $smarty->enqueue_script('/mediaelement/mediaelement-and-player.min.js');
        $smarty->enqueue_script('/js/assoce.js');

        $smarty->assign('menuselected', 'assoce');

        $trail = Trail::getInstance();
        $trail->addStep("L'Association", "/assoce");
        $trail->addStep("Les Concerts");

        $smarty->assign('photos', Photo::getPhotos([
            'online' => true,
            'sort'   => 'random',
            'lieu'   => 1,
            'limit'  => 3,
        ]));

        $smarty->assign('videos', Video::getVideos([
            'online' => true,
            'sort'   => 'random',
            'lieu'   => 1,
            'limit'  => 6,
        ]));

        // tri antéchrono des saisons
        $smarty->assign('events', array_reverse(Event::getAdHocEventsBySeason()));

        return $smarty->fetch('assoce/concerts.tpl');
    }

    static function afterworks()
    {
        $smarty = new AdHocSmarty();

        $smarty->enqueue_style('/mediaelement/mediaelementplayer.css');
        $smarty->enqueue_script('/mediaelement/mediaelement-and-player.min.js');
        $smarty->enqueue_script('/js/assoce.js');

        $smarty->assign('menuselected', 'assoce');

        $trail = Trail::getInstance();
        $trail->addStep("L'Association", "/assoce");
        $trail->addStep("Les Afterworks");

        $smarty->assign('photos', Photo::getPhotos([
            'online' => true,
            'sort'   => 'random',
            'lieu'   => 1,
            'limit'  => 3,
        ]));

        $smarty->assign('videos', Video::getVideos([
            'online' => true,
            'sort'   => 'random',
            'lieu'   => 1,
            'limit'  => 6,
        ]));

        $smarty->assign('events', array_reverse(Event::getAdHocEventsBySeason(), true));

        return $smarty->fetch('assoce/afterworks.tpl');
    }

    static function formations()
    {
        $smarty = new AdHocSmarty();
        $smarty->enqueue_style('/mediaelement/mediaelementplayer.css');
        $smarty->enqueue_script('/mediaelement/mediaelement-and-player.min.js');
        $smarty->enqueue_script('/js/assoce.js');
        $smarty->assign('menuselected', 'assoce');
        $trail = Trail::getInstance();
        $trail->addStep("L'Association", "/assoce");
        $trail->addStep("L'Equipe");
        $smarty->assign('photos', Photo::getPhotos([
            'online' => true,
            'sort'   => 'random',
            'lieu'   => 1,
            'limit'  => 3,
        ]));
        $smarty->assign('videos', Video::getVideos([
            'online' => true,
            'sort'   => 'random',
            'lieu'   => 1,
            'limit'  => 6,
        ]));
        return $smarty->fetch('assoce/formations.tpl');
    }

    static function equipe()
    {
        $smarty = new AdHocSmarty();

        $smarty->enqueue_style('/mediaelement/mediaelementplayer.css');
        $smarty->enqueue_script('/mediaelement/mediaelement-and-player.min.js');
        $smarty->enqueue_script('/js/assoce.js');

        $smarty->assign('menuselected', 'assoce');

        $trail = Trail::getInstance();
        $trail->addStep("L'Association", "/assoce");
        $trail->addStep("L'Equipe");

        $smarty->assign('photos', Photo::getPhotos([
            'online' => true,
            'sort'   => 'random',
            'lieu'   => 1,
            'limit'  => 3,
        ]));

        $smarty->assign('videos', Video::getVideos([
            'online' => true,
            'sort'   => 'random',
            'lieu'   => 1,
            'limit'  => 6,
        ]));

        $smarty->assign('membres', MembreAdhoc::getStaff(true));
        $smarty->assign('omembres', MembreAdhoc::getStaff(false));

        return $smarty->fetch('assoce/equipe.tpl');
    }

    static function statuts()
    {
        $smarty = new AdHocSmarty();

        $smarty->enqueue_style('/mediaelement/mediaelementplayer.css');
        $smarty->enqueue_script('/mediaelement/mediaelement-and-player.min.js');
        $smarty->enqueue_script('/js/assoce.js');

        $smarty->assign('menuselected', 'assoce');

        $trail = Trail::getInstance();
        $trail->addStep("L'Association", "/assoce");
        $trail->addStep("Statuts");

        $smarty->assign('photos', Photo::getPhotos([
            'online' => true,
            'sort'   => 'random',
            'lieu'   => 1,
            'limit'  => 3,
        ]));

        $smarty->assign('videos', Video::getVideos([
            'online' => true,
            'sort'   => 'random',
            'lieu'   => 1,
            'limit'  => 6,
        ]));

        return $smarty->fetch('assoce/statuts.tpl');
    }
}
