<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\Membre;
use Adhoc\Model\Photo;
use Adhoc\Utils\AdHocTwig;
use Adhoc\Utils\AdHocTwigBootstrap;
use Adhoc\Utils\Email;
use Adhoc\Utils\Route;
use Adhoc\Utils\Tools;
use Adhoc\Utils\Trail;

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

        $twig = new AdHocTwig();

        $photos = Photo::find(
            [
                'order_by' => 'id_photo',
                'sort' => 'ASC',
                'start' => $page * NB_PHOTOS_PER_PAGE,
                'limit' => NB_PHOTOS_PER_PAGE,
            ]
        );
        $twig->assign('photos', $photos);

        // pagination
        $twig->assign('nb_items', Photo::count());
        $twig->assign('nb_items_per_page', NB_PHOTOS_PER_PAGE);
        $twig->assign('page', $page);

        return $twig->render('adm/photos/index.twig');
    }
}
