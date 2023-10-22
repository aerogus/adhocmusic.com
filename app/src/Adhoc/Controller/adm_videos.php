<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\AdHocSmarty;
use Adhoc\Model\Membre;
use Adhoc\Model\Tools;
use Adhoc\Model\Trail;
use Adhoc\Model\Video;

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

        $smarty = new AdHocSmarty();

        $videos = Video::find(
            [
                'order_by' => 'id_video',
                'sort' => 'ASC',
                'start' => $page * NB_VIDEOS_PER_PAGE,
                'limit' => NB_VIDEOS_PER_PAGE,
            ]
        );
        $smarty->assign('videos', $videos);

        // pagination
        $smarty->assign('nb_items', Video::count());
        $smarty->assign('nb_items_per_page', NB_VIDEOS_PER_PAGE);
        $smarty->assign('page', $page);

        return $smarty->fetch('adm/videos/index.tpl');
    }
}
