<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\Groupe;
use Adhoc\Model\Membre;
use Adhoc\Utils\AdHocTwig;
use Adhoc\Utils\Route;
use Adhoc\Utils\Tools;

final class Controller
{
    /**
     * @return string
     */
    public static function index(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $twig = new AdHocTwig();

        $twig->assign('breadcrumb', [
            ['title' => '🏠', 'link' => '/'],
            ['title' => 'Privé', 'link' => '/adm'],
            'Groupes',
        ]);

        $page = (int) Route::params('page');

        $twig->assign(
            'groupes',
            Groupe::find(
                [
                    'order_by' => 'name',
                    'sort' => 'ASC',
                    'start' => $page * ADM_NB_MEMBERS_PER_PAGE,
                    'limit' => ADM_NB_MEMBERS_PER_PAGE,
                ]
            )
        );

        // pagination
        $twig->assign('nb_items', Groupe::count());
        $twig->assign('nb_items_per_page', ADM_NB_MEMBERS_PER_PAGE);
        $twig->assign('page', $page);

        return $twig->render('adm/groupes/index.twig');
    }

    /**
     * @return string
     */
    public static function show(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id_groupe = (int) Route::params('id');

        $groupe = Groupe::getInstance($id_groupe);

        $twig = new AdHocTwig();

        $twig->assign('breadcrumb', [
            ['title' => '🏠', 'link' => '/'],
            ['title' => 'Privé', 'link' => '/adm'],
            ['title' => 'Groupes', 'link' => '/adm/groupes'],
            $groupe->getName(),
        ]);

        $twig->assign('groupe', $groupe);
        return $twig->render('adm/groupes/show.twig');
    }
}
