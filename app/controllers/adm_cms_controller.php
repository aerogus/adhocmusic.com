<?php

/**
 *
 */
final class Controller
{
    /**
     * @return string
     */
    static function index(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);
        $smarty = new AdHocSmarty();

        Trail::getInstance()
            ->addStep("Privé", "/adm/")
            ->addStep("Pages Statiques");

        $smarty->assign('create', (bool) Route::params('create'));
        $smarty->assign('edit', (bool) Route::params('edit'));
        $smarty->assign('delete', (bool) Route::params('delete'));

        $smarty->assign('cmss', CMS::getCMSs());

        return $smarty->fetch('adm/cms/index.tpl');
    }

    /**
     * @return string
     */
    static function create(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        Trail::getInstance()
            ->addStep("Privé", "/adm/")
            ->addStep("Pages Statiques", "/adm/cms/")
            ->addStep("Création");

        $smarty->assign('auth', Membre::getTypesMembre());

        if (Tools::isSubmit('form-cms-create')) {
            $data = [
                'alias'      => (string) Route::params('alias'),
                'breadcrumb' => (string) Route::params('breadcrumb'),
                'title'      => (string) Route::params('title'),
                'content'    => (string) Route::params('content'),
                'online'     => (bool) Route::params('online'),
                'auth'       => (int) Route::params('auth'),
            ];

            $cms = CMS::init();
            $cms->setAlias($data['alias']);
            $cms->setBreadcrumb($data['breadcrumb']);
            $cms->setTitle($data['title']);
            $cms->setContent($data['content']);
            $cms->setOnline($data['online']);
            $cms->setCreatedNow();
            $cms->setAuth($data['auth']);
            $cms->save();

            Tools::redirect('/adm/cms/?create=1');
        }

        return $smarty->fetch('adm/cms/create.tpl');
    }

    /**
     * @return string
     */
    static function edit(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        Trail::getInstance()
            ->addStep("Privé", "/adm/")
            ->addStep("Pages Statiques", "/adm/cms/")
            ->addStep("Edition");

        $smarty->assign('auth', Membre::getTypesMembre());

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

            $cms = CMS::getInstance($data['id_cms']);
            $cms->setAlias($data['alias']);
            $cms->setBreadcrumb($data['breadcrumb']);
            $cms->setTitle($data['title']);
            $cms->setContent($data['content']);
            $cms->setOnline($data['online']);
            $cms->setAuth($data['auth']);
            $cms->setModifiedNow();
            $cms->save();

            Tools::redirect('/adm/cms/?edit=1');
        }

        $smarty->assign('cms', CMS::getInstance($id));

        return $smarty->fetch('adm/cms/edit.tpl');
    }

    /**
     * @return string
     */
    static function delete(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        Trail::getInstance()
            ->addStep("Privé", "/adm/")
            ->addStep("Pages Statiques", "/adm/cms/")
            ->addStep("Suppression");

        if (Tools::isSubmit('form-cms-delete')) {
            $cms = CMS::getInstance($id);
            $cms->delete();
            Tools::redirect('/adm/cms/?delete=1');
        }

        $smarty->assign('cms', CMS::getInstance($id));

        return $smarty->fetch('adm/cms/delete.tpl');
    }
}
