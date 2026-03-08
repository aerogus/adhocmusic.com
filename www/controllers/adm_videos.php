<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\Membre;
use Adhoc\Model\Video;
use Adhoc\Utils\AdHocTwig;
use Adhoc\Utils\Route;
use Adhoc\Utils\Tools;

define('NB_VIDEOS_PER_PAGE', 80);

final class Controller
{
    /**
     * @return string
     */
    public static function index(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $twig = new AdHocTwig();

        $twig->enqueueScript('/js/adm/videos/index.js');
        $twig->enqueueScript('/static/library/dataTables@2.3.6/dataTables.min.js');
        $twig->enqueueStyle('/static/library/dataTables@2.3.6/dataTables.min.css');

        $twig->assign('breadcrumb', [
            ['title' => '🏠', 'link' => '/'],
            ['title' => 'Privé', 'link' => '/adm'],
            'Vidéos',
        ]);

        return $twig->render('adm/videos/index.twig');
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
            0 => 'id_video',
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
            $order_by = 'id_video';
            $sort = 'ASC';
        }

        $videos = Video::find([
            'order_by' => $order_by,
            'sort' => $sort,
            'start' => $start,
            'limit' => $length,
            'found_rows' => true,
        ]);

        $output->draw = $draw;
        $output->recordsTotal = intval(Video::getFoundRows());
        $output->recordsFiltered = intval(Video::getFoundRows());
        $output->data = [];
        foreach ($videos as $video) {
            $output->data[] = [
                'id_video' => $video->getIdVideo(),
                'name' => $video->getName(),
                'created_at' => $video->getCreatedAt(),
                'updated_at' => $video->getModifiedAt(),
            ];
        }

        return $output;
    }
}
