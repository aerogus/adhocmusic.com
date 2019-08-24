<?php

final class Controller
{
    static function assoce() : string
    {
        $smarty = new AdHocSmarty();

        $smarty->enqueue_style('/mediaelement/mediaelementplayer.css');
        $smarty->enqueue_script('/mediaelement/mediaelement-and-player.min.js');
        $smarty->enqueue_script('/js/assoce.js');

        $trail = Trail::getInstance();
        $trail->addStep("L'Association");

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

    static function concerts() : string
    {
        $smarty = new AdHocSmarty();

        $smarty->enqueue_style('/mediaelement/mediaelementplayer.css');
        $smarty->enqueue_script('/mediaelement/mediaelement-and-player.min.js');
        $smarty->enqueue_script('/js/assoce.js');

        $trail = Trail::getInstance();
        $trail->addStep("Concerts");

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

    static function afterworks() : string
    {
        $smarty = new AdHocSmarty();

        $smarty->enqueue_style('/mediaelement/mediaelementplayer.css');
        $smarty->enqueue_script('/mediaelement/mediaelement-and-player.min.js');
        $smarty->enqueue_script('/js/assoce.js');

        $trail = Trail::getInstance();
        $trail->addStep("Afterworks");

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

    static function formations() : string
    {
        $smarty = new AdHocSmarty();
        $smarty->enqueue_style('/mediaelement/mediaelementplayer.css');
        $smarty->enqueue_script('/mediaelement/mediaelement-and-player.min.js');
        $smarty->enqueue_script('/js/assoce.js');

        $trail = Trail::getInstance();
        $trail->addStep("Formation");

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

    static function equipe() : string
    {
        $smarty = new AdHocSmarty();

        $smarty->enqueue_style('/mediaelement/mediaelementplayer.css');
        $smarty->enqueue_script('/mediaelement/mediaelement-and-player.min.js');
        $smarty->enqueue_script('/js/assoce.js');

        $trail = Trail::getInstance();
        $trail->addStep("Équipe");

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
}
