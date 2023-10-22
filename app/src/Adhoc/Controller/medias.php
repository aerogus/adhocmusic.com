<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\AdHocSmarty;
use Adhoc\Model\Event;
use Adhoc\Model\Groupe;
use Adhoc\Model\Lieu;
use Adhoc\Model\Route;
use Adhoc\Model\Trail;
use Adhoc\Model\Video;

/**
 * Controlleur Medias
 */
final class Controller
{
    /**
     * @return string
     */
    public static function index(): string
    {
        Trail::getInstance()
            ->addStep('Média');

        $smarty = new AdHocSmarty();

        $smarty->enqueueScript('/js/medias.js');

        $smarty->assign(
            'groupes',
            Groupe::find(
                [
                    'online' => true,
                    'order_by' => 'name',
                    'sort' => 'ASC',
                ]
            )
        );

        $smarty->assign(
            'events',
            Event::find(
                [
                    'online' => true,
                    'id_structure' => 1,
                    'datfin' => date('Y-m-d'),
                    'order_by' => 'date',
                    'sort' => 'DESC',
                ]
            )
        );

        $smarty->assign(
            'lieux',
            Lieu::find(
                [
                    'online' => true,
                    'with_events' => true,
                    'order_by' => 'id_city',
                    'sort' => 'ASC',
                ]
            )
        );

        $smarty->assign(
            'last_videos',
            Video::find(
                [
                    'online' => true,
                    'order_by' => 'created_at',
                    'sort' => 'DESC',
                    'limit' => 18,
                ]
            )
        );

        return $smarty->fetch('medias/index.tpl');
    }

    /**
     * @return string
     */
    public static function searchResults(): string
    {
        $id_groupe = (int) Route::params('groupe');
        $id_event  = (int) Route::params('event');
        $id_lieu   = (int) Route::params('lieu');

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
        if ($id_lieu) {
            $search_params['id_lieu'] = $id_lieu;
        }

        $smarty = new AdHocSmarty();
        $smarty->assign('search_video', Video::find($search_params));
        return $smarty->fetch('medias/search-results.tpl');
    }
}
