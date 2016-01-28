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
        $trail->addStep("Foire aux questions");

        $smarty->assign('create', (bool) Route::params('create'));
        $smarty->assign('edit', (bool) Route::params('edit'));
        $smarty->assign('delete', (bool) Route::params('delete'));
        $smarty->assign('faq', FAQ::getFAQs());

        return $smarty->fetch('adm/faq/index.tpl');
    }

    static function create()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'prive');

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Foire aux questions", "/adm/faq/");
        $trail->addStep("Création");

        if(Tools::isSubmit('form-faq-create'))
        {
            $data = array(
                'id_category' => (int) Route::params('id_category'),
                'question'    => (string) Route::params('question'),
                'answer'      => (string) Route::params('answer'),
            );

            $faq = FAQ::init();
            $faq->setIdCategory($data['id_category']);
            $faq->setQuestion($data['question']);
            $faq->setAnswer($data['answer']);
            $faq->save();

            Tools::redirect('/adm/faq/?create=1');
        }

        $smarty->assign('categories', FAQ::getCategories());

        return $smarty->fetch('adm/faq/create.tpl');
    }

    static function edit()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id_faq = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'prive');

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Foire aux questions", "/adm/faq/");
        $trail->addStep("Edition");

        if(Tools::isSubmit('form-faq-edit'))
        {
            $data = array(
                'id_faq'      => (int) Route::params('id_faq'),
                'id_category' => (int) Route::params('id_category'),
                'question'    => (string) Route::params('question'),
                'answer'      => (string) Route::params('answer'),
            );

            FAQ::getInstance($data['id_faq']);
            $faq->setIdCategory($data['id_category']);
            $faq->setQuestion($data['question']);
            $faq->setAnswer($data['answer']);
            $faq->save();

            Tools::redirect('/adm/faq/?edit=1');
        }

        $smarty->assign('categories', FAQ::getCategories());
        $smarty->assign('faq', FAQ::getInstance($id_faq));

        return $smarty->fetch('adm/faq/edit.tpl');
    }

    static function delete()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'prive');

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Foire aux questions", "/adm/faq/");
        $trail->addStep("Suppression");

        if(Tools::isSubmit('form-faq-delete'))
        {
            $faq = FAQ::getInstance($id);
            $faq->delete();

            Tools::redirect('/adm/faq/?delete=1');
        }

        $smarty->assign('faq', FAQ::getInstance($id));

        return $smarty->fetch('adm/faq/delete.tpl');
    }
}