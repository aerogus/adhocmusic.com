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

        $twig->enqueueScript('/js/adm/membres/index.js');
        $twig->enqueueScript('/static/library/dataTables@2.3.6/dataTables.min.js');
        $twig->enqueueStyle('/static/library/dataTables@2.3.6/dataTables.min.css');

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

    /**
     * json de réponse pour dataTables
     *
     * @return \stdClass
     */
    public static function dt(): mixed
    {
        Tools::auth(Membre::TYPE_ADMIN);

        $output = new \stdClass();

        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $output->status = 'KO';
            $output->msg = 'api compatible seulement avec la méthode GET';
            Api::stdout($output, 400);
            exit;
        }

        $draw = intval($_GET['draw'] ?? 1);
        $pseudo = $_GET['pseudo'] ?? null;
        $last_name = $_GET['last_name'] ?? null;
        $first_name = $_GET['first_name'] ?? null;
        $email = $_GET['email'] ?? null;
        $start = intval($_GET['start'] ?? 0);
        $length = min(intval($_GET['length'] ?? 100), 500);
        $order = $_GET['order'] ?? [];

        $col2prop = [
            0 => 'id_contact',
            1 => 'pseudo',
            2 => 'last_name',
            3 => 'first_name',
            4 => 'email',
            5 => 'created_at',
            6 => 'updated_at',
            7 => 'visited_at',
        ];

        if (count($order) > 0) {
            $order_by = $col2prop[$order[0]['column']];
            $sort = $order[0]['dir'];
        } else {
            $order_by = 'id_contact';
            $sort = 'ASC';
        }

        $membres = Membre::find([
            'pseudo' => $pseudo,
            'last_name' => $last_name,
            'first_name' => $first_name,
            'email' => $email,
            'order_by' => $order_by,
            'sort' => $sort,
            'start' => $start,
            'limit' => $length,
            'found_rows' => true,
        ]);

        $output->draw = $draw;
        $output->recordsTotal = intval(Membre::getFoundRows());
        $output->recordsFiltered = intval(Membre::getFoundRows());
        $output->data = [];
        foreach ($membres as $membre) {
            $output->data[] = [
                'id_contact' => $membre->getIdContact(),
                'pseudo' => $membre->getPseudo(),
                'last_name' => $membre->getLastName(),
                'first_name' => $membre->getFirstName(),
                'email' => $membre->getEmail(),
                'created_at' => $membre->getCreatedAt(),
                'updated_at' => $membre->getModifiedAt(),
                'visited_at' => $membre->getVisitedAt(),
            ];
        }

        return $output;
    }
}
