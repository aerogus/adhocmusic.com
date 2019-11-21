<?php declare(strict_types=1);

/**
 * Controlleur Medias
 */
final class Controller
{
    /**
     * @return string
     */
    static function index(): string
    {
        Trail::getInstance()
            ->addStep('Média');

        $smarty = new AdHocSmarty();

        $smarty->enqueue_script('/js/medias.js');

        $smarty->assign(
            'last_videos', Video::find(
                [
                    'online' => true,
                    'order_by'   => 'created_on',
                    'sort'   => 'DESC',
                    'limit'  => 18,
                ]
            )
        );

        // recup events ayant des vidéos
        $smarty->assign(
            'events', Event::find(
                [
                    'online' => true,
                    'with_video' => true,
                ]
            )
        );

        return $smarty->fetch('medias/index.tpl');
    }

    /**
     * @return string
     */
    static function search_results(): string
    {
        $id_groupe = (int) Route::params('groupe');
        $id_event  = (int) Route::params('event');
        $type      = (string) Route::params('type');

        $search_media = [];

        if ($id_groupe) {
            $search_media = Media::getMedia(
                [
                    'type' => $type,
                    'groupe' => $id_groupe,
                    'online' => true,
                    'limit' => 30,
                ]
            );
        }

        if ($id_event) {
            $search_media = Media::getMedia(
                [
                    'type' => $type,
                    'event' => $id_event,
                    'online' => true,
                    'limit' => 30,
                ]
            );
        }

        $smarty = new AdHocSmarty();
        $smarty->assign('search_media', $search_media);
        return $smarty->fetch('medias/search-results.tpl');
    }
}
