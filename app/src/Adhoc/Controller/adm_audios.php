<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\AdHocSmarty;
use Adhoc\Model\Audio;
use Adhoc\Model\Membre;
use Adhoc\Model\Route;
use Adhoc\Model\Tools;
use Adhoc\Model\Trail;

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

        $smarty = new AdHocSmarty();

        $audios = Audio::find(
            [
                'order_by' => 'id_audio',
                'sort' => 'ASC',
                'start' => $page * NB_AUDIOS_PER_PAGE,
                'limit' => NB_AUDIOS_PER_PAGE,
            ]
        );
        $smarty->assign('audios', $audios);

        // pagination
        $smarty->assign('nb_items', Audio::count());
        $smarty->assign('nb_items_per_page', NB_AUDIOS_PER_PAGE);
        $smarty->assign('page', $page);

        return $smarty->fetch('adm/audios/index.tpl');
    }
}
