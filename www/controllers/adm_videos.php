<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\Membre;
use Adhoc\Model\Video;
use Adhoc\Utils\AdHocTwigBootstrap;
use Adhoc\Utils\Route;
use Adhoc\Utils\Tools;
use Adhoc\Utils\Trail;

define('NB_VIDEOS_PER_PAGE', 80);

final class Controller
{
    /**
     * @return string
     */
    public static function index(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        Trail::getInstance()
            ->addStep("Privé", "/adm")
            ->addStep("Vidéos");

        $page = (int) Route::params('page');

        $twig = new AdhocTwigBootstrap();

        $videos = Video::find(
            [
                'order_by' => 'id_video',
                'sort' => 'ASC',
                'start' => $page * NB_VIDEOS_PER_PAGE,
                'limit' => NB_VIDEOS_PER_PAGE,
            ]
        );
        $twig->assign('videos', $videos);

        // pagination
        $twig->assign('nb_items', Video::count());
        $twig->assign('nb_items_per_page', NB_VIDEOS_PER_PAGE);
        $twig->assign('page', $page);

        return $twig->render('adm/videos/index.twig');
    }
}
