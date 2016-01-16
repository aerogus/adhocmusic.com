<?php

class Controller
{
    static function index()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'prive');

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Newsletter");

        $smarty->assign('newsletters', Newsletter::getNewsletters(array(
            'sens' => 'DESC',
            'limit' => 50,
        )));
        $smarty->assign('nb_sub', Newsletter::getSubscribersCount());

        return $smarty->fetch('adm/newsletter/index.tpl');
    }

    static function create()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'prive');

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Newsletter", "/adm/newsletter/");
        $trail->addStep("Ajout");

        $data = array(
            'title' => Newsletter::getDefaultTitle(),
            'content' => Newsletter::getDefaultRawContent(),
        );

        $smarty->assign('data', $data);

        return $smarty->fetch('adm/newsletter/create.tpl');
    }

    static function create_submit()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $data = array(
            'title'   => trim((string) Route::params('title')),
            'content' => trim((string) Route::params('content')),
        );

        $newsletter = Newsletter::init();
        $newsletter->save();

        $newsletter->setTitle($data['title']);
        $newsletter->setContent($data['content']);
        $newsletter->save();

        Tools::redirect('/adm/newsletter/?create=1');
    }

    static function edit()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'prive');

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Newsletter", "/adm/newsletter/");
        $trail->addStep("Edition");

        $smarty->assign('newsletter', Newsletter::getInstance($id));

        return $smarty->fetch('adm/newsletter/edit.tpl');
    }

    static function edit_submit()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $data = array(
            'id'      => (int) Route::params('id'),
            'title'   => trim((string) Route::params('title')),
            'content' => trim((string) Route::params('content')),
        );

        $newsletter = Newsletter::getInstance($data['id']);
        $newsletter->setTitle($data['title']);
        $newsletter->setContent($data['content']);
        $newsletter->save();

        Tools::redirect('/adm/newsletter/edit/'.(int) Route::params('id').'?edit=1');
    }

}
