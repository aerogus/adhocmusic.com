<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\Membre;
use Adhoc\Model\Newsletter;
use Adhoc\Utils\AdHocTwigBootstrap;
use Adhoc\Utils\Route;
use Adhoc\Utils\Tools;
use Adhoc\Utils\Trail;

final class Controller
{
    /**
     * @return string
     */
    public static function index(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $twig = new AdhocTwigBootstrap();

        Trail::getInstance()
            ->addStep('Privé', '/adm')
            ->addStep('Newsletter');

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

        return $twig->render('adm/newsletter/index.twig');
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
            $mjmlBin = ADHOC_ROOT_PATH . '/node_modules/.bin/mjml';
            $html = shell_exec($mjmlBin . " -i <<EOF\n" . $data['content'] . "\nEOF");

            (new Newsletter())
                ->setTitle($data['title'])
                ->setContent($data['content'])
                ->setHtml($html)
                ->save();

            Tools::redirect('/adm/newsletter?create=1');
        }

        $twig = new AdhocTwigBootstrap();

        $twig->enqueueStyle('https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.48.4/codemirror.min.css');
        $twig->enqueueScript('https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.48.4/codemirror.min.js');
        $twig->enqueueScript('https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.48.4/mode/xml/xml.min.js');
        $twig->enqueueScript('/js/adm/newsletter.js');

        Trail::getInstance()
            ->addStep('Privé', '/adm')
            ->addStep('Newsletter', '/adm/newsletter')
            ->addStep('Ajout');

        $data = [
            'title' => '',
            'content' => '',
        ];

        $twig->assign('data', $data);

        return $twig->render('adm/newsletter/create.twig');
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

            Tools::redirect('/adm/newsletter/edit/' . (int) Route::params('id') . '?edit=1');
        }

        $id = (int) Route::params('id');

        $twig = new AdhocTwigBootstrap();

        $twig->enqueueStyle('https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.48.4/codemirror.min.css');
        $twig->enqueueScript('https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.48.4/codemirror.min.js');
        $twig->enqueueScript('https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.48.4/mode/xml/xml.min.js');
        $twig->enqueueScript('/js/adm/newsletter.js');

        Trail::getInstance()
            ->addStep('Privé', '/adm')
            ->addStep('Newsletter', '/adm/newsletter')
            ->addStep('Édition');

        $twig->assign('newsletter', Newsletter::getInstance($id));

        return $twig->render('adm/newsletter/edit.twig');
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
