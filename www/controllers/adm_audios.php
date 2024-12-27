<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\Audio;
use Adhoc\Model\Membre;
use Adhoc\Utils\AdHocTwigBootstrap;
use Adhoc\Utils\Route;
use Adhoc\Utils\Tools;
use Adhoc\Utils\Trail;

define('NB_AUDIOS_PER_PAGE', 80);

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
            ->addStep("Audios");

        $page = (int) Route::params('page');

        $twig = new AdhocTwigBootstrap();

        $audios = Audio::find(
            [
                'order_by' => 'id_audio',
                'sort' => 'ASC',
                'start' => $page * NB_AUDIOS_PER_PAGE,
                'limit' => NB_AUDIOS_PER_PAGE,
            ]
        );
        $twig->assign('audios', $audios);

        // pagination
        $twig->assign('nb_items', Audio::count());
        $twig->assign('nb_items_per_page', NB_AUDIOS_PER_PAGE);
        $twig->assign('page', $page);

        return $twig->render('adm/audios/index.twig');
    }
}
