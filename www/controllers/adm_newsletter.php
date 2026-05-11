<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\Membre;
use Adhoc\Model\Newsletter;
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

        $twig->enqueueScript('/js/adm/newsletters/index.js');
        $twig->enqueueScript('/static/library/dataTables@2.3.7/dataTables.min.js');
        $twig->enqueueStyle('/static/library/dataTables@2.3.7/dataTables.min.css');

        $twig->assign('breadcrumb', [
            ['title' => '🏠', 'link' => '/'],
            ['title' => 'Privé', 'link' => '/adm'],
            'Newsletters',
        ]);

        $twig->assign(
            'newsletters',
            Newsletter::find(
                [
                    'order_by' => 'id_newsletter',
                    'sort' => 'DESC',
                ]
            )
        );
        $twig->assign('nb_sub', Newsletter::getSubscribersCount());

        return $twig->render('adm/newsletters/index.twig');
    }

    /**
     * @return string
     */
    public static function create(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        if (Tools::isSubmit('form-newsletter-create')) {
            $data = [
                'title'   => trim((string) Route::params('title')),
                'content' => trim((string) Route::params('content')),
            ];

            // dépendance à mjml via npm
            // nécessite l'environnement node !
            $mjmlBin = ADHOC_ROOT_PATH . '/node_modules/.bin/mjml';
            $html = shell_exec($mjmlBin . " -i <<EOF\n" . $data['content'] . "\nEOF");

            Newsletter::init()
                ->setTitle($data['title'])
                ->setContent($data['content'])
                ->setHtml($html)
                ->save();

            Tools::redirect('/adm/newsletters?create=1');
        }

        $twig = new AdHocTwig();

        $twig->enqueueStyle('/static/library/codemirror@6.65.7/codemirror.min.css');
        $twig->enqueueScript('/static/library/codemirror@6.65.7/codemirror.min.js');
        $twig->enqueueScript('/static/library/codemirror@6.65.7/mode/xml/xml.min.js');
        $twig->enqueueScript('/js/adm/newsletters/create-edit.js');

        $twig->assign('breadcrumb', [
            ['title' => '🏠', 'link' => '/'],
            ['title' => 'Privé', 'link' => '/adm'],
            ['title' => 'Newsletters', 'link' => '/adm/newsletters'],
            'Ajout',
        ]);

        $data = [
            'title' => '',
            'content' => '',
        ];

        $twig->assign('data', $data);

        return $twig->render('adm/newsletters/create.twig');
    }

    /**
     * @return string
     */
    public static function edit(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        if (Tools::isSubmit('form-newsletter-edit')) {
            $data = [
                'id'      => (int) Route::params('id'),
                'title'   => trim((string) Route::params('title')),
                'content' => trim((string) Route::params('content')),
            ];

            // dépendance à mjml via npm
            $mjmlBin = ADHOC_ROOT_PATH . '/node_modules/.bin/mjml';
            $html = shell_exec($mjmlBin . " -i <<EOF\n" . $data['content'] . "\nEOF");

            Newsletter::getInstance($data['id'])
                ->setTitle($data['title'])
                ->setContent($data['content'])
                ->setHtml($html)
                ->save();

            Tools::redirect('/adm/newsletters/edit/' . (int) Route::params('id') . '?edit=1');
        }

        $id = (int) Route::params('id');

        $twig = new AdHocTwig();

        $twig->enqueueStyle('/static/library/codemirror@6.65.7/codemirror.min.css');
        $twig->enqueueScript('/static/library/codemirror@6.65.7/codemirror.min.js');
        $twig->enqueueScript('/static/library/codemirror@6.65.7/mode/xml/xml.min.js');
        $twig->enqueueScript('/js/adm/newsletters/create-edit.js');

        $twig->assign('breadcrumb', [
            ['title' => '🏠', 'link' => '/'],
            ['title' => 'Privé', 'link' => '/adm'],
            ['title' => 'Newsletters', 'link' => '/adm/newsletters'],
            'Édition',
        ]);

        $twig->assign('newsletter', Newsletter::getInstance($id));

        return $twig->render('adm/newsletters/edit.twig');
    }

    /**
     * Upload fichier pour newsletter
     * il est stocké dans le répertoire dédié sans traitement particulier
     *
     * @return string
     */
    public static function upload(): string
    {
        $id = (int) Route::params('id');

        if (is_uploaded_file($_FILES['file']['tmp_name'])) {
            $n = Newsletter::getInstance($id);
            if (!file_exists($n->getFilePath())) {
                mkdir($n->getFilePath());
            }
            move_uploaded_file($_FILES['file']['tmp_name'], $n->getFilePath() . '/' . $_FILES['file']['name']);
            return 'OK';
        }
        return 'KO';
    }
}
