<?php declare(strict_types=1);

/**
 * Controlleur Medias
 */
final class Controller
{
    static function index(): string
    {
        Trail::getInstance()
            ->addStep('Média');

        $smarty = new AdHocSmarty();

        $smarty->enqueue_script('/js/medias.js');

        $last_media = Media::getMedia(
            [
                'type'   => 'video',
                'sort'   => 'created_on',
                'sens'   => 'DESC',
                'online' => true,
                'limit'  => 18,
                'split'  => true,
            ]
        );
        $smarty->assign('last_media', $last_media);

        $id_groupe = (int) Route::params('groupe');
        $id_event  = (int) Route::params('event');

        $smarty->assign('id_groupe', $id_groupe);
        $smarty->assign('id_event', $id_event);

        $smarty->assign('create', (bool) Route::params('create'));
        $smarty->assign('edit', (bool) Route::params('edit'));
        $smarty->assign('delete', (bool) Route::params('delete'));

        $search_media = [];

        // recup groupes ayant des média
        $smarty->assign('groupes', Groupe::getGroupesWithMedia());

        if ($id_groupe) {
            $search_media = Media::getMedia(
                [
                    'type'   => 'video',
                    'groupe' => $id_groupe,
                    'online' => true,
                ]
            );
        }

        // recup events ayant des média
        $smarty->assign('events', Event::getEventsWithVideo());

        if ($id_event) {
            $search_media = Media::getMedia(
                [
                    'type'   => 'video',
                    'event'  => $id_event,
                    'online' => true,
                ]
            );
        }

        $smarty->assign('search_media', $search_media);

        $comments = Comment::getComments(
            [
                'type'  => 's,p,v',
                'sort'  => 'id',
                'sens'  => 'DESC',
                'debut' => 0,
                'limit' => 5,
            ]
        );
        $smarty->assign('comments', $comments);

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
                    'type'   => $type,
                    'groupe' => $id_groupe,
                    'online' => true,
                    'limit'  => 30,
                ]
            );
        }

        if ($id_event) {
            $search_media = Media::getMedia(
                [
                    'type'   => $type,
                    'event'  => $id_event,
                    'online' => true,
                    'limit'  => 30,
                ]
            );
        }

        $smarty = new AdHocSmarty();
        $smarty->assign('search_media', $search_media);
        return $smarty->fetch('medias/search-results.tpl');
    }
}
