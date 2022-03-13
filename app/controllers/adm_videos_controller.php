<?php declare(strict_types=1);

define('NB_VIDEOS_PER_PAGE', 80);

final class Controller
{
    /**
     * @return string
     */
    static function index(): string
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
        $nb_videos = count($videos);

        $smarty->assign('videos', $videos);

        // pagination
        $smarty->assign('nb_items', $nb_videos);
        $smarty->assign('nb_items_per_page', NB_VIDEOS_PER_PAGE);
        $smarty->assign('page', $page);

        return $smarty->fetch('adm/videos/index.tpl');
    }
}
