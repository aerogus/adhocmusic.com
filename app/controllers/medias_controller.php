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
            'groupes', Groupe::find(
                [
                    'online' => true,
                    'order_by' => 'name',
                    'sort' => 'ASC',
                ]
            )
        );
        
        $smarty->assign(
            'last_videos', Video::find(
                [
                    'online' => true,
                    'order_by' => 'created_at',
                    'sort' => 'DESC',
                    'limit' => 18,
                ]
            )
        );

        // recup events AD'HOC ayant des vidéos
        $smarty->assign(
            'events', Event::find(
                [
                    'online' => true,
                    'id_structure' => 1,
                    'datfin' => date('Y-m-d'),
                    'order_by' => 'date',
                    'sort' => 'DESC',
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

        $search_params = [
            'online' => true,
            'limit' => 18,
        ];

        if ($id_groupe) {
            $search_params['id_groupe'] = $id_groupe;
        }

        if ($id_event) {
            $search_params['id_event'] = $id_event;
        }

        $smarty = new AdHocSmarty();
        $smarty->assign('search_video', Video::find($search_params));
        return $smarty->fetch('medias/search-results.tpl');
    }
}
