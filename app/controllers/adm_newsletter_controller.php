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

        $smarty->enqueue_style('https://cdn.rawgit.com/codemirror/CodeMirror/master/lib/codemirror.css');
        $smarty->enqueue_script('https://cdn.rawgit.com/codemirror/CodeMirror/master/lib/codemirror.js');
        $smarty->enqueue_script('https://cdn.rawgit.com/codemirror/CodeMirror/master/mode/xml/xml.js');

        if(Tools::isSubmit('form-newsletter-create'))
        {
            $data = array(
                'title'   => trim((string) Route::params('title')),
                'content' => trim((string) Route::params('content')),
            );

            $newsletter = Newsletter::init();
            $newsletter->setTitle($data['title']);
            $newsletter->setContent($data['content']);
            $newsletter->save();

            Tools::redirect('/adm/newsletter/?create=1');
        }

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'prive');

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Newsletter", "/adm/newsletter/");
        $trail->addStep("Ajout");

        $data = array(
            'title' => '',
            'content' => '',
        );

        $smarty->assign('data', $data);

        return $smarty->fetch('adm/newsletter/create.tpl');
    }

    static function edit()
    {
        Tools::auth(Membre::TYPE_INTERNE);


        $smarty->enqueue_style('https://cdn.rawgit.com/codemirror/CodeMirror/master/lib/codemirror.css');
        $smarty->enqueue_script('https://cdn.rawgit.com/codemirror/CodeMirror/master/lib/codemirror.js');
        $smarty->enqueue_script('https://cdn.rawgit.com/codemirror/CodeMirror/master/mode/xml/xml.js');

        if(Tools::isSubmit('form-newsletter-edit'))
        {
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
}
