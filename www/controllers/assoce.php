<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\Event;
use Adhoc\Model\MembreAdhoc;
use Adhoc\Utils\AdHocTwigBootstrap;
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
        $twig = new AdHocTwigBootstrap();

        $twig->assign('breadcrumb', [['title' => '🏠', 'link' => '/'], "L'Association"]);

        return $twig->render('assoce/presentation.twig');
    }

    /**
     * @return string
     */
    public static function concerts(): string
    {
        $twig = new AdHocTwigBootstrap();

        $twig->assign('breadcrumb', [['title' => '🏠', 'link' => '/'], "Concerts"]);

        $twig->enqueueScript('/static/library/masonry@4.2.2/masonry.min.js');
        $twig->enqueueScript('/static/library/imagesloaded@4.1.4/imagesloaded.min.js');

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
        $twig = new AdHocTwigBootstrap();

        $twig->assign('breadcrumb', [['title' => '🏠', 'link' => '/'], "Afterworks"]);

        return $twig->render('assoce/afterworks.twig');
    }

    /**
     * @return string
     */
    public static function festival(): string
    {
        $twig = new AdHocTwigBootstrap();

        $twig->assign('breadcrumb', [['title' => '🏠', 'link' => '/'], "Festival"]);

        return $twig->render('assoce/festival.twig');
    }

    /**
     * @return string
     */
    public static function equipe(): string
    {
        $twig = new AdHocTwigBootstrap();

        $twig->assign('breadcrumb', [['title' => '🏠', 'link' => '/'], "Équipe"]);

        $twig->assign('membres', MembreAdhoc::getStaff(true));

        return $twig->render('assoce/equipe.twig');
    }
}
