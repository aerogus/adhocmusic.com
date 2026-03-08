<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\Membre;
use Adhoc\Model\Photo;
use Adhoc\Utils\AdHocTwig;
use Adhoc\Utils\Email;
use Adhoc\Utils\Route;
use Adhoc\Utils\Tools;

define('NB_PHOTOS_PER_PAGE', 80);

final class Controller
{
    /**
     * @return string
     */
    public static function index(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $page = (int) Route::params('page');

        $twig = new AdHocTwig();

        $twig->enqueueScript('/js/adm/photos/index.js');
        $twig->enqueueScript('/static/library/dataTables@2.3.6/dataTables.min.js');
        $twig->enqueueStyle('/static/library/dataTables@2.3.6/dataTables.min.css');

        $twig->assign('breadcrumb', [
            ['title' => '🏠', 'link' => '/'],
            ['title' => 'Privé', 'link' => '/adm'],
            'Photos',
        ]);

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
        $start = intval($_GET['start'] ?? 0);
        $length = min(intval($_GET['length'] ?? 100), 500);
        $order = $_GET['order'] ?? [];

        $col2prop = [
            0 => 'id_photo',
            1 => 'name',
            2 => 'group',
            3 => 'event',
            4 => 'lieu',
            5 => 'created_at',
            6 => 'updated_at',
        ];

        if (count($order) > 0) {
            $order_by = $col2prop[$order[0]['column']];
            $sort = $order[0]['dir'];
        } else {
            $order_by = 'id_photo';
            $sort = 'ASC';
        }

        $photos = Photo::find([
            'order_by' => $order_by,
            'sort' => $sort,
            'start' => $start,
            'limit' => $length,
            'found_rows' => true,
        ]);

        $output->draw = $draw;
        $output->recordsTotal = intval(Photo::getFoundRows());
        $output->recordsFiltered = intval(Photo::getFoundRows());
        $output->data = [];
        foreach ($photos as $photo) {
            $output->data[] = [
                'id_photo' => $photo->getIdPhoto(),
                'name' => $photo->getName(),
                'created_at' => $photo->getCreatedAt(),
                'updated_at' => $photo->getModifiedAt(),
            ];
        }

        return $output;
    }
}
