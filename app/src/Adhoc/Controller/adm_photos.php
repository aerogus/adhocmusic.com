<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\AdHocSmarty;
use Adhoc\Model\Email;
use Adhoc\Model\Membre;
use Adhoc\Model\Photo;
use Adhoc\Model\Route;
use Adhoc\Model\Tools;
use Adhoc\Model\Trail;

define('NB_PHOTOS_PER_PAGE', 80);

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
            ->addStep("Photos");

        $page = (int) Route::params('page');

        $smarty = new AdHocSmarty();

        $photos = Photo::find(
            [
                'order_by' => 'id_photo',
                'sort' => 'ASC',
                'start' => $page * NB_PHOTOS_PER_PAGE,
                'limit' => NB_PHOTOS_PER_PAGE,
            ]
        );
        $smarty->assign('photos', $photos);

        // pagination
        $smarty->assign('nb_items', Photo::count());
        $smarty->assign('nb_items_per_page', NB_PHOTOS_PER_PAGE);
        $smarty->assign('page', $page);

        return $smarty->fetch('adm/photos/index.tpl');
    }
}
