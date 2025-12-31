<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\Membre;
use Adhoc\Model\TypeMusicien;
use Adhoc\Utils\AdHocTwig;
use Adhoc\Utils\Route;
use Adhoc\Utils\Tools;

final class Controller
{
    const MEMBERS_PER_PAGE = 100;

    public static function index(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        if (((string) Route::params('sort') === 'DESC')) {
            $sort = 'DESC';
            $sortinv = 'ASC';
        } else {
            $sort = 'ASC';
            $sortinv = 'DESC';
        }

        if (!is_null(Route::params('order_by'))) {
            $order_by = Route::params('order_by');
        } else {
            $order_by = 'id_contact';
        }

        $page = (int) Route::params('page');

        $pseudo = trim((string) Route::params('pseudo'));
        $email = trim((string) Route::params('email'));
        $last_name = trim((string) Route::params('last_name'));
        $first_name = trim((string) Route::params('first_name'));

        $membres = Membre::find(
            [
                'pseudo'     => $pseudo,
                'email'      => $email,
                'last_name'  => $last_name,
                'first_name' => $first_name,
                'order_by'   => $order_by,
                'sort'       => $sort,
                'start'      => $page * self::MEMBERS_PER_PAGE,
                'limit'      => self::MEMBERS_PER_PAGE,
            ]
        );

        $nb_membres = Membre::count();

        $twig = new AdHocTwig();

        $twig->assign('membres', $membres);

        $twig->assign('sort', $sort);
        $twig->assign('sortinv', $sortinv);
        $twig->assign('page', $page);

        // test ajax
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            return $twig->render('adm/membres/index-res.twig');
        }

        $twig->assign('breadcrumb', [
            ['title' => '🏠', 'link' => '/'],
            ['title' => 'Privé', 'link' => '/adm'],
            'Membres',
        ]);

        $twig->assign('types_membre', Membre::getTypesMembre());
        $twig->assign('types_musicien', TypeMusicien::findAll());

        $twig->assign(
            'search',
            [
                'pseudo' => $pseudo,
                'last_name' => $last_name,
                'first_name' => $first_name,
                'email' => $email,
            ]
        );

        // pagination
        $twig->assign('nb_items', $nb_membres);
        $twig->assign('nb_items_per_page', self::MEMBERS_PER_PAGE);
        $twig->assign('link_base_params', 'order_by=' . $order_by . '&sort=' . $sort);

        return $twig->render('adm/membres/index.twig');
    }

    /**
     * @return string
     */
    public static function show(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id = (int) Route::params('id');

        $membre = Membre::getInstance($id);

        $twig = new AdHocTwig();

        $twig->assign('breadcrumb', [
            ['title' => '🏠', 'link' => '/'],
            ['title' => 'Privé', 'link' => '/adm'],
            ['title' => 'Membres', 'link' => '/adm/membres'],
            $membre->getPseudo(),
        ]);

        $twig->assign('membre', $membre);
        return $twig->render('adm/membres/show.twig');
    }

    /**
     * @return string
     */
    public static function delete(): string
    {
        Tools::auth(Membre::TYPE_ADMIN);

        $id = (int) Route::params('id');

        $membre = Membre::getInstance($id);

        // ***

        //$membre->delete();
        //$contact = Contact::getInstance($id);
        //$contact->delete();

        // ***

        $twig = new AdHocTwig();

        $twig->assign('breadcrumb', [
            ['title' => '🏠', 'link' => '/'],
            ['title' => 'Privé', 'link' => '/adm'],
            ['title' => 'Membres', 'link' => '/adm/membres'],
            "Suppression de " . $membre->getPseudo(),
        ]);

        $twig->assign('membre', $membre);
        return $twig->render('adm/membres/delete.twig');
    }
}
