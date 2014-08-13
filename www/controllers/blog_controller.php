<?php

class Controller
{
    public static function index()
    {
        $groupe = (int) Route::params('groupe');

        Tools::auth(Membre::TYPE_STANDARD);
        Tools::authGroupe($groupe);

        $trail = Trail::getInstance();
        $trail->addStep("Zone Membres", "/membres/");
        $trail->addStep("Mon Blog Groupe");

        $blog = Blog::getInstance($groupe);

        $smarty = new AdHocSmarty();

        $smarty->assign('articles', $blog->getBlog());
        $smarty->assign('groupe', $groupe);

        return $smarty->fetch('blog/index.tpl');
    }

    public static function add()
    {
        $groupe = (int) Route::params('groupe');

        Tools::auth(Membre::TYPE_STANDARD);
        Tools::authGroupe($groupe);

        $trail = Trail::getInstance();
        $trail->addStep("Zone Membres", "/membres/");
        $trail->addStep("Mon Blog Groupe", "/blog/?groupe=".$groupe);
        $trail->addStep("Ajout Article");

        $blog = Blog::getInstance($groupe);

        $smarty = new AdHocSmarty();

        $smarty->assign('form', true);
        $smarty->assign('groupe', $groupe);

        return $smarty->fetch('blog/add.tpl');
    }

    public static function add_submit()
    {
        $groupe = (int) Route::params('groupe');

        Tools::auth(Membre::TYPE_STANDARD);
        Tools::authGroupe($groupe);

        $blog = Blog::getInstance($groupe);

        $id_article = $blog->addArticle(array(
            'id_contact' => $_SESSION['membre']->getId(),
            'title'      => (string) Route::params('title'),
            'text'       => (string) Route::params('text'),
        ));

        if(is_uploaded_file($_FILES['file']['tmp_name'])) {
            $id_file = $blog->addFile(array(
                'id_contact' => $_SESSION['membre']->getId(),
                'id_article' => $id_article,
                'title'      => $_FILES['file']['tmp_name'],
            ));
            $blog->uploadFile($id_file, $_FILES['file']);
        }

        Tools::redirect('/blog/?groupe='.$groupe);
    }

    public static function addcom_submit()
    {
        $groupe = (int) Route::params('groupe');

        Tools::auth(Membre::TYPE_STANDARD);
        Tools::authGroupe($groupe);

        $blog->addComment(array(
            'id_contact' => $_SESSION['membre']->getId(),
            'id_article' => (int) Route::params('id_article'),
            'text'       => (string) Route::params('text'),
        ));

        Tools::redirect('/blog/?groupe='.$groupe);
    }

    public static function del()
    {
        $id = (int) Route::params('id');
        $groupe = (int) Route::params('groupe');

        Tools::auth(Membre::TYPE_STANDARD);
        Tools::authGroupe($groupe);

        $trail = Trail::getInstance();
        $trail->addStep("Zone Membres", "/membres/");
        $trail->addStep("Mon Blog Groupe", "/blog/?groupe=".$groupe);
        $trail->addStep("Suppression Article");

        $blog = Blog::getInstance($groupe);

        $smarty = new AdHocSmarty();

        $smarty->assign('article', $blog->getArticle($id));
        $smarty->assign('groupe', $groupe);
        $smarty->assign('id', $id);
        $smarty->assign('form', true);

        return $smarty->fetch('blog/del.tpl');
    }

    public static function del_submit()
    {
        $groupe = (int) Route::params('groupe');

        Tools::auth(Membre::TYPE_STANDARD);
        Tools::authGroupe($groupe);

        $blog = Blog::getInstance($groupe);
        $blog->delArticle($id);

        Tools::redirect('/blog/?groupe='.$groupe);
    }

    public static function edit()
    {
        $id = (int) Route::params('id');
        $groupe = (int) Route::params('groupe');

        Tools::auth(Membre::TYPE_STANDARD);
        Tools::authGroupe($groupe);

        $trail = Trail::getInstance();
        $trail->addStep("Zone Membres", "/membres/");
        $trail->addStep("Mon Blog Groupe", "/blog/?groupe=".$groupe);
        $trail->addStep("Edition Article");

        $blog = Blog::getInstance($groupe);

        $smarty = new AdHocSmarty();

        $smarty->assign('article', $blog->getArticle($id));
        $smarty->assign('groupe', $groupe);
        $smarty->assign('form', true);

        return $smarty->fetch('blog/edit.tpl');
    }

    public static function edit_submit()
    {
        $groupe = (int) Route::params('groupe');

        Tools::auth(Membre::TYPE_STANDARD);
        Tools::authGroupe($groupe);

        $blog = Blog::getInstance($groupe);

        $blog->editArticle(array(
            'id_contact' => $_SESSION['membre']->getId(),
            'id'         => (int) Route::params('id'),
            'title'      => (string) Route::params('title'),
            'text'       => (string) Route::params('text'),
        ));

        if(is_uploaded_file($_FILES['file']['tmp_name'])) {
            $blog->addFile((int) Route::params('id'), $_FILES['file']);
        }

        Tools::redirect('/blog/?groupe='.$groupe);
    }

    public static function dl()
    {
        $groupe = (int) Route::params('groupe');

        Tools::auth(Membre::TYPE_STANDARD);
        Tools::authGroupe($groupe);

        return file_get_contents($fichier);
    }
}
