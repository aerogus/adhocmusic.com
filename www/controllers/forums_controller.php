<?php

class Controller
{
    public static function index()
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'forums');

        $trail = Trail::getInstance();
        $trail->addStep("Forums");

        $smarty->assign('title', "♫ AD'HOC : Les Forums");
        $smarty->assign('description', "Association oeuvrant pour le développement de la vie musicale en Essonne depuis 1996. Promotion d'artistes, Pédagogie musicale, Agenda concerts, Communauté de musiciens ...");
        $smarty->assign('keywords', "musique, essonne, epinay sur orge, epinay");

        $smarty->assign("forums", ForumPublic::getForums());

        return $smarty->fetch('forums/index.tpl');
    }

    public static function forum()
    {
        $id_forum = Route::params('id_forum');
        $page = (int) Route::params('page');

        $smarty = new AdHocSmarty();

        $db = DataBase::getInstance();
        $trail = Trail::getInstance();

        $smarty->assign('menuselected', 'forums');

        if(!($forum = ForumPublic::getForum($id_forum))) {
            Tools::redirect('/forums/');
        }

        $trail->addStep("Forums", "/forums/");
        $trail->addStep($forum['title']);

        $smarty->assign('forum', $forum);

        $smarty->assign('title', "♫ Forum " . $forum['title']);
        $smarty->assign('description', "Association oeuvrant pour le développement de la vie musicale en Essonne depuis 1996. Promotion d'artistes, Pédagogie musicale, Agenda concerts, Communauté de musiciens ...");
        $smarty->assign('keywords', "musique, essonne, epinay sur orge, epinay");

        $smarty->assign('threads', ForumPublic::getThreads($forum['id_forum'], $page));

        $smarty->assign('nb_items', ForumPublic::getThreadsCount($forum['id_forum']));
        $smarty->assign('nb_items_per_page', FORUM_NB_THREADS_PER_PAGE);
        $smarty->assign('page', $page);

        return $smarty->fetch('forums/forum.tpl');
    }

    public static function thread()
    {
        $id_thread = (int) Route::params('id_thread');
        $page = (int) Route::params('page');

        $data = ForumPublic::getMessages($id_thread, $page);
        $forum = ForumPublic::getForum($data['thread']['id_forum']);

        $smarty = new AdHocSmarty();
        $smarty->assign('menuselected', 'forums');

        $smarty->assign('title', "♫ " . $data['thread']['subject']);

        $trail = Trail::getInstance();
        $trail->addStep("Forums", "/forums/");
        $trail->addStep($forum['title'], "/forums/forum/" . $forum['id_forum']);
        $trail->addStep($data['thread']['subject']);

        $smarty->assign('id_forum', $data['thread']['id_forum']);
        $smarty->assign('id_thread', $id_thread);

        $smarty->assign('thread', $data['thread']);
        $smarty->assign('messages', $data['messages']);

        $smarty->assign('nb_items', $data['thread']['nb_messages']);
        $smarty->assign('nb_items_per_page', FORUM_NB_MESSAGES_PER_PAGE);
        $smarty->assign('page', $page);

        ForumPublic::addView($id_thread);

        // box écrire
        $smarty->assign('text', '');
        $smarty->assign('check', Tools::getCSRFToken());

        return $smarty->fetch('forums/thread.tpl');
    }

    public static function write()
    {
        Tools::auth(Membre::TYPE_STANDARD);

        if(Tools::isSubmit('form-forum-write'))
        {
            if(Tools::checkCSRFToken((string) Route::params('check')) === false) {
                die(); // mauvais code sécurité
            }
    
            $id_forum  = Route::params('id_forum');
            $id_thread = (int) Route::params('id_thread');
            $subject   = (string) Route::params('subject');
            $text      = (string) Route::params('text');
    
            $msg = ForumPublic::addMessage(array(
                'id_contact' => $_SESSION['membre']->getId(),
                'id_forum'   => $id_forum,
                'id_thread'  => $id_thread,
                'subject'    => $subject,
                'text'       => $text,
            ));
    
            Tools::redirect('/forums/forum/' . $msg['id_forum']);            
        }

        $id_forum  = Route::params('id_forum');
        $id_thread = (int) Route::params('id_thread');

        $smarty = new AdHocSmarty();

        if(is_null($id_forum) && empty($id_thread)) {
            Tools::redirect('/forums/');
        } elseif(!empty($id_thread)) {
            $data = ForumPublic::getMessages($id_thread);
            $id_forum = $data['thread']['id_forum'];
            $smarty->assign('id_thread', $id_thread);
            $smarty->assign('thread', $data['thread']);
            $smarty->assign('messages', $data['messages']);
        } elseif(!empty($id_forum)) {
            $smarty->assign('id_forum', $id_forum);
        }

        $forum = ForumPublic::getForum($id_forum);

        $smarty->assign('menuselected', 'forums');

        $trail = Trail::getInstance();
        $trail->addStep("Forums", "/forums/");
        $trail->addStep($forum['title'], "/forums/forum/" . $forum['id_forum']);
        if(!empty($id_thread)) {
            $trail->addStep($data['thread']['subject'], "/forums/thread/" . $id_thread);
        }
        $trail->addStep("Ajouter un message");

        $smarty->assign('forum', $forum);

        // box écrire
        $smarty->assign('subject', '');
        $smarty->assign('text', '');
        $smarty->assign('check', Tools::getCSRFToken());
        $smarty->assign('id_forum', $id_forum);
        $smarty->assign('id_thread', $id_thread);

        return $smarty->fetch('forums/write.tpl');
    }
}
