<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\CMS;
use Adhoc\Model\Membre;
use Adhoc\Utils\AdHocTwig;
use Adhoc\Utils\Route;
use Adhoc\Utils\Tools;

/**
 *
 */
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
            'Pages Statiques',
        ]);

        $twig->assign('create', (bool) Route::params('create'));
        $twig->assign('edit', (bool) Route::params('edit'));
        $twig->assign('delete', (bool) Route::params('delete'));

        $twig->assign('cmss', CMS::findAll());

        return $twig->render('adm/cms/index.twig');
    }

    /**
     * @return string
     */
    public static function create(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $twig = new AdHocTwig();

        $twig->assign('breadcrumb', [
            ['title' => '🏠', 'link' => '/'],
            ['title' => 'Privé', 'link' => '/adm'],
            ['title' => 'Pages Statiques', 'link' => '/adm/cms'],
            'Création',
        ]);

        $twig->assign('auth', Membre::getTypesMembre());

        if (Tools::isSubmit('form-cms-create')) {
            $data = [
                'alias'      => (string) Route::params('alias'),
                'breadcrumb' => (string) Route::params('breadcrumb'),
                'title'      => (string) Route::params('title'),
                'content'    => (string) Route::params('content'),
                'online'     => (bool) Route::params('online'),
                'auth'       => (int) Route::params('auth'),
            ];

            (new CMS())
                ->setAlias($data['alias'])
                ->setBreadcrumb($data['breadcrumb'])
                ->setTitle($data['title'])
                ->setContent($data['content'])
                ->setOnline($data['online'])
                ->setAuth($data['auth'])
                ->save();

            Tools::redirect('/adm/cms?create=1');
        }

        return $twig->render('adm/cms/create.twig');
    }

    /**
     * @return string
     */
    public static function edit(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id = (int) Route::params('id');

        $twig = new AdHocTwig();

        $twig->assign('breadcrumb', [
            ['title' => '🏠', 'link' => '/'],
            ['title' => 'Privé', 'link' => '/adm'],
            ['title' => 'Pages Statiques', 'link' => '/adm/cms'],
            'Édition',
        ]);

        $twig->assign('auth', Membre::getTypesMembre());

        if (Tools::isSubmit('form-cms-edit')) {
            $data = [
                'id_cms'       => (int) Route::params('id_cms'),
                'alias'        => (string) Route::params('alias'),
                'breadcrumb'   => (string) Route::params('breadcrumb'),
                'title'        => (string) Route::params('title'),
                'content'      => (string) Route::params('content'),
                'online'       => (bool) Route::params('online'),
                'auth'         => (int) Route::params('auth'),
            ];

            CMS::getInstance($data['id_cms'])
                ->setAlias($data['alias'])
                ->setBreadcrumb($data['breadcrumb'])
                ->setTitle($data['title'])
                ->setContent($data['content'])
                ->setOnline($data['online'])
                ->setAuth($data['auth'])
                ->save();

            Tools::redirect('/adm/cms?edit=1');
        }

        $twig->assign('cms', CMS::getInstance($id));

        return $twig->render('adm/cms/edit.twig');
    }

    /**
     * @return string
     */
    public static function delete(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id = (int) Route::params('id');

        $twig = new AdHocTwig();

        $twig->assign('breadcrumb', [
            ['title' => '🏠', 'link' => '/'],
            ['title' => 'Privé', 'link' => '/adm'],
            ['title' => 'Pages Statiques', 'link' => '/adm/cms'],
            'Suppression',
        ]);

        if (Tools::isSubmit('form-cms-delete')) {
            CMS::getInstance($id)->delete();
            Tools::redirect('/adm/cms?delete=1');
        }

        $twig->assign('cms', CMS::getInstance($id));

        return $twig->render('adm/cms/delete.twig');
    }
}
