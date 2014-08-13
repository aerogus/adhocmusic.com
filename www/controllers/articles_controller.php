<?php

define('FRONT_NB_ARTICLES_PER_PAGE', 10);
define('ADM_NB_ARTICLES_PER_PAGE', 30);

class Controller
{
    /**
     * Page d'accueil du mag, listing des articles
     */
    public static function index($rub = null)
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('title', "♫ AD'HOC Music : Le Mag");
        $smarty->assign('description', "Articles sur la pédagogie musicale, chroniques de concerts, d'albums, technique du son ...");
        $smarty->assign('keywords', "musique, technique, home studio, autoproduction, musicien, protools");

        $smarty->assign('menuselected', 'articles');

        $trail = Trail::getInstance();
        $trail->addStep("Articles", '/articles/');

        ///
        if(!is_null($rub)) {

            if($id_rubrique = Article::getIdRubriqueByAlias($rub)) {
                $articles = Article::getArticles(array(
                    'online' => true,
                    'sort'   => 'created_on',
                    'sens'   => 'DESC',
                    'debut'   => 0,
                    'limit'   => 100,
                    'rubrique' => $id_rubrique,
                ));
                $smarty->assign('articles', $articles);
                $rubrique = Article::getRubrique($id_rubrique);
                $smarty->assign('rubrique', $rubrique);
                $trail->addStep($rubrique['title']);
            } else {
                // err rub introuvable
                $smarty->assign('rub_err', true);
            }

        } else {

            $last_articles_by_rubriques = Article::getLastArticlesByRubriques(2);
            $rubriques = Article::getRubriques(true); // count_articles
    
            $smarty->assign('last_articles_by_rubriques', $last_articles_by_rubriques);
            $smarty->assign('rubriques', $rubriques);
        }

        $comments = Comment::getComments(array(
            'type' => 'a',
            'sort' => 'id',
            'sens' => 'DESC',
            'debut' => 0,
            'limit' => 5,
        ));
        $smarty->assign('comments', $comments);
        
        return $smarty->fetch('articles/index.tpl');
    }

    public static function more()
    {
        $rub = (string) Route::params('rub');

        $smarty = new AdHocSmarty();

        if($id_rubrique = Article::getIdRubriqueByAlias($rub)) {
            $articles = Article::getArticles(array(
                'online'   => true,
                'sort'     => 'created_on',
                'sens'     => 'DESC',
                'debut'    => 2,
                'limit'    => 100,
                'rubrique' => $id_rubrique,
            ));
            $smarty->assign('articles', $articles);
        }

        return $smarty->fetch('articles/more.tpl');
    }

    /**
     * listing public d'une rubrique particulière
     */
    public static function rub()
    {
        $rub = (string) Route::params('rub');
        return self::index($rub);
    }

    /**
     * admin : liste de mes articles
     */
    public static function my()
    {
        Tools::auth(Membre::TYPE_REDACTEUR);

        $page = (int) Route::params('page');

        $smarty = new AdHocSmarty();

        $smarty->assign('create', (bool) Route::params('create'));
        $smarty->assign('edit', (bool) Route::params('edit'));
        $smarty->assign('delete', (bool) Route::params('delete'));

        $smarty->assign('title', "♫ AD'HOC Music : Le Mag");
        $smarty->assign('description', "Articles sur la pédagogie musicale, chroniques de concerts, d'albums, technique du son ...");
        $smarty->assign('keywords', "musique, technique, home studio, autoproduction, musicien, protools");

        $smarty->assign('menuselected', 'articles');

        $trail = Trail::getInstance();
        $trail->addStep("Tableau de bord", "/membres/tableau-de-bord");
        $trail->addStep("Mes Articles");

        $articles = Article::getArticles(array(
            'debut'   => $page * ADM_NB_ARTICLES_PER_PAGE,
            'limit'   => ADM_NB_ARTICLES_PER_PAGE,
            'contact' => $_SESSION['membre']->isAdmin() ? 0 : $_SESSION['membre']->getId(),
            'sort'    => 'created_on',
            'sens'    => 'DESC',
        ));
        if($_SESSION['membre']->isAdmin()) {
            $nb_articles = Article::getArticlesCount();
        } else {
            $nb_articles = Article::getMyArticlesCount();
        }

        $smarty->assign('articles', $articles);

        $smarty->assign('nb_items', $nb_articles);
        $smarty->assign('nb_items_per_page', ADM_NB_ARTICLES_PER_PAGE);
        $smarty->assign('page', $page);

        return $smarty->fetch('articles/my.tpl');
    }

    public static function show()
    {
        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'articles');

        try {
            $article = Article::getInstance((int) $id);
        } catch(AdHocUserException $e) {
            Route::set_http_code('404');
            $smarty->assign('unknown_article', true);
            return $smarty->fetch('articles/show.tpl');
        }

        $smarty->assign('article', $article);

        $smarty->assign('title', $article->getTitle());
        $smarty->assign('description', $article->getIntro());
        $smarty->assign('keywords', "musique, technique, home studio, autoproduction, musicien, protools");
        $smarty->assign('og_type', 'article');
        if($article->getImage()) {
            $smarty->assign('og_image', $article->getImage());
        }

        $trail = Trail::getInstance();
        $trail->addStep("Articles", "/articles/");
        $trail->addStep(Article::getRubriqueName($article->getIdRubrique()), "/articles/" . Article::getRubriqueAlias($article->getIdRubrique()));
        $trail->addStep($article->getTitle());

        $smarty->assign('rubriques', Article::getRubriques());
        $smarty->assign('rubrique', Article::getRubriqueName($article->getIdRubrique()));

        $smarty->assign('comments', Comment::getComments(array(
            'type'       => 'a',
            'id_content' => $article->getId(),
            'online'     => true,
            'sort'       => 'created_on',
            'sens'       => 'ASC',
        )));

        $article->addVisite();

        return $smarty->fetch('articles/show.tpl');
    }

    public static function create()
    {
        Tools::auth(Membre::TYPE_REDACTEUR);

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'articles');

        $trail = Trail::getInstance();
        $trail->addStep("Tableau de bord", "/membres/tableau-de-bord");
        $trail->addStep("Mes Articles", "/articles/my");
        $trail->addStep("Ajout");

        $data = array(
            'id_rubrique' => 0,
            'id_contact'  => (int) $_SESSION['membre']->getId(),
            'title'       => '',
            'intro'       => '',
            'text'        => '',
        );

        if(Tools::isSubmit('form-article-create'))
        {
            $data = array(
                'id_rubrique' => (int) Route::params('id_rubrique'),
                'id_contact'  => (int) $_SESSION['membre']->getId(),
                'title'       => trim((string) Route::params('title')),
                'intro'       => trim((string) Route::params('intro')),
                'text'        => trim((string) Route::params('text')),
            );

            if(self::_validate_form_article($data, $errors)) {
                $article = Article::init();
                $article->setIdRubrique($data['id_rubrique']);
                $article->setIdContact($data['id_contact']);
                $article->setTitle($data['title']);
                $article->setAlias($data['title']);
                $article->setIntro($data['intro']);
                $article->setText($data['text']);
                $article->setOnline(false);
                $article->setCreatedNow();
                if($article->save()) {
                    if(is_uploaded_file($_FILES['image']['tmp_name'])) {
                        $img = new Image($_FILES['image']['tmp_name']);
                        $img->setType(IMAGETYPE_JPEG);
                        $img->setKeepRatio(true);
                        $img->setMaxWidth(100);
                        $img->setMaxHeight(100);
                        $img->setDestFile(ADHOC_ROOT_PATH . '/media/article/p/' . $article->getId() . '.jpg');
                        $img->write();
                        $img = '';
                    }
                    Log::action(Log::ACTION_ARTICLE_CREATE, $article->getId());
                    Tools::redirect('/articles/my?create=1');
                }
                $errors['generic'] = "Une erreur mystérieuse s'est produite.";
            } else {
                foreach($errors as $k => $v) {
                    $smarty->assign('error_' . $k, $v);
                }
            }
        }

        $smarty->assign('rubriques', Article::getRubriques());
        $smarty->assign('data', $data);

        return $smarty->fetch('articles/create.tpl');
    }

    public static function edit()
    {
        $id = (int) Route::params('id');

        Tools::auth(Membre::TYPE_REDACTEUR);

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'articles');

        $trail = Trail::getInstance();
        $trail->addStep("Tableau de bord", "/membres/tableau-de-bord");
        $trail->addStep("Mes Articles", "/articles/my");
        $trail->addStep("Edition");

        $article = Article::getInstance($id);

        if(Tools::isSubmit('form-article-edit'))
        {
            $data = array(
                'id'          => (int) Route::params('id'),
                'id_contact'  => $_SESSION['membre']->getId(),
                'id_rubrique' => (int) Route::params('id_rubrique'),
                'title'       => (string) Route::params('title'),
                'intro'       => (string) Route::params('intro'),
                'text'        => (string) Route::params('text'),
                'online'      => (bool) Route::params('online'),
            );
    
            if(self::_validate_form_article($data, $errors)) {
                $article->setIdRubrique($data['id_rubrique']);
                $article->setTitle($data['title']);
                $article->setAlias($data['title']);
                $article->setIntro($data['intro']);
                $article->setText($data['text']);
                $article->setOnline($data['online']);
                $article->setModifiedNow();
                if($article->save()) {
                    if(is_uploaded_file($_FILES['image']['tmp_name'])) {
                        $img = new Image($_FILES['image']['tmp_name']);
                        $img->setType(IMAGETYPE_JPEG);
                        $img->setKeepRatio(true);
                        $img->setMaxWidth(100);
                        $img->setMaxHeight(100);
                        $img->setDestFile(ADHOC_ROOT_PATH . '/media/article/p/' . $article->getId() . '.jpg');
                        $img->write();
                        $img = '';
                    }
                    Log::action(Log::ACTION_ARTICLE_EDIT, $article->getId());
                    Tools::redirect('/articles/my?edit=1');
                }
                $errors['generic'] = "Une erreur mystérieuse s'est produite.";
            } else {
                foreach($errors as $k => $v) {
                    $smarty->assign('error_' . $k, $v);
                }
            }            
        }

        if(($_SESSION['membre']->isAdmin() === false)
        && ($_SESSION['membre']->getId() != $article->getIdContact())) {
            $smarty->assign('error_article', true);
        } else {
            $smarty->assign('rubriques', Article::getRubriques());
            $smarty->assign('article', $article);
        }

        return $smarty->fetch('articles/edit.tpl');
    }

    /**
     * validation du formulaire article
     * @param array $data
     * @param array &$errors
     * @return bool
     */
    protected static function _validate_form_article($data, &$errors)
    {
        $errors = array();
        if (empty($data['id_rubrique'])) {
            $errors['id_rubrique'] = true;
        }
        if (empty($data['title'])) {
            $errors['title'] = true;
        }
        if (empty($data['intro'])) {
            $errors['intro'] = true;
        }
        if (empty($data['text'])) {
            $errors['text'] = true;
        }
        if(count($errors)) {
            return false;
        }
        return true;
    }

    public static function delete()
    {
        $id = (int) Route::params('id');

        Tools::auth(Membre::TYPE_ADMIN);
 
        $article = Article::getInstance($id);
 
        $smarty = new AdHocSmarty();
        $smarty->assign('menuselected', 'articles');

        $trail = Trail::getInstance();
        $trail->addStep("Tableau de bord", "/membres/tableau-de-bord");
        $trail->addStep("Mes Articles", "/articles/my");
        $trail->addStep("Suppression");

        if(Tools::isSubmit('form-article-delete'))
        {
            if($article->delete()) {
                Log::action(Log::ACTION_ARTICLE_DELETE, $article->getId());
                Tools::redirect('/articles/my?delete=1');
            }
        }

        $smarty->assign('article', $article);

        return $smarty->fetch('articles/delete.tpl');
    }
}
