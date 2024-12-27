<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\Event;
use Adhoc\Model\Groupe;
use Adhoc\Model\Lieu;
use Adhoc\Model\Video;
use Adhoc\Utils\AdHocTwigBootstrap;
use Adhoc\Utils\Route;
use Adhoc\Utils\Trail;

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

        $twig = new AdhocTwigBootstrap();

        $twig->enqueueScript('/js/medias.js');

        $twig->assign(
            'groupes',
            Groupe::find(
                [
                    'online' => true,
                    'order_by' => 'name',
                    'sort' => 'ASC',
                ]
            )
        );

        $twig->assign(
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

        $twig->assign(
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

        $twig->assign(
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

        return $twig->render('medias/index.twig');
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

        if ($id_groupe > 0) {
            $search_params['id_groupe'] = $id_groupe;
        }
        if ($id_event > 0) {
            $search_params['id_event'] = $id_event;
        }
        if ($id_lieu > 0) {
            $search_params['id_lieu'] = $id_lieu;
        }

        $twig = new AdhocTwigBootstrap();
        $twig->assign('search_video', Video::find($search_params));
        return $twig->render('medias/search-results.twig');
    }
}
