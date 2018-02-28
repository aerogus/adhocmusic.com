<?php

class Controller
{
    static function index()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Forums");

        $smarty->assign('forums', ForumPrive::getForums());

        return $smarty->fetch('adm/forums/index.tpl');
    }

    static function forum()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id_forum = Route::params('id_forum');
        $page = (int) Route::params('page');

        $forum = ForumPrive::getForum($id_forum);

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Forums", "/adm/forums/");
        $trail->addStep($forum['title']);

        $smarty->enqueue_script('/js/adm/forums.js');

        $smarty->assign('subs', ForumPrive::getSubscribers($id_forum));
        $smarty->assign('forum', $forum);
        $smarty->assign('threads', ForumPrive::getThreads($id_forum, $page));

        $smarty->assign('nb_items', ForumPrive::getThreadsCount($id_forum));
        $smarty->assign('nb_items_per_page', FORUM_NB_THREADS_PER_PAGE);
        $smarty->assign('page', $page);

        return $smarty->fetch('adm/forums/forum.tpl');
    }

    static function thread()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id_thread = (int) Route::params('id_thread');
        $page = (int) Route::params('page');

        $smarty = new AdHocSmarty();

        $data = ForumPrive::getMessages($id_thread, $page);
        $forum = ForumPrive::getForum($data['thread']['id_forum']);

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Forums", "/adm/forums/");
        $trail->addStep($forum['title'], "/adm/forums/forum/" . $forum['id_forum']);
        $trail->addStep($data['thread']['subject']);

        $smarty->assign('id_forum', $forum['id_forum']);
        $smarty->assign('id_thread', $id_thread);

        $smarty->assign('subs', ForumPrive::getSubscribers($forum['id_forum']));
        $smarty->assign('thread', $data['thread']);
        $smarty->assign('messages', $data['messages']);

        $smarty->assign('nb_items', $data['thread']['nb_messages']);
        $smarty->assign('nb_items_per_page', FORUM_NB_MESSAGES_PER_PAGE);
        $smarty->assign('page', $page);

        ForumPrive::addView($id_thread);

        // box écrire
        $smarty->assign('text', '');
        $smarty->assign('check', Tools::getCSRFToken());

        return $smarty->fetch('adm/forums/thread.tpl');
    }

    static function write()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id_forum  = Route::params('id_forum');
        $id_thread = (int) Route::params('id_thread');

        if (Tools::isSubmit('form-forum-write'))
        {
            // a debuger
            /*
            if (Tools::checkCSRFToken((string) Route::params('check')) === false) {
                //die('csrf fail'); // mauvais code sécurité
            }
            */

            $subject   = (string) Route::params('subject');
            $text      = (string) Route::params('text');

            $msg = ForumPrive::addMessage([
                'id_contact' => $_SESSION['membre']->getId(),
                'id_forum'   => $id_forum,
                'id_thread'  => $id_thread,
                'subject'    => $subject,
                'text'       => $text,
            ]);

            /* début alerte mail aux abonnés */

            $subs = ForumPrive::getSubscribers($msg['id_forum']);
            $forum = ForumPrive::getForum($msg['id_forum']);
            if (!$subject) {
                $msgs = ForumPrive::getMessages($msg['id_thread']);
                $subject = $msgs['thread']['subject'];
            }

            if (sizeof($subs)) {

                foreach ($subs as $sub) {

                    $data = [
                        'title' => 'Nouveau message',
                        'pseudo_to' => $sub['pseudo'],
                        'pseudo_from' => $_SESSION['membre']->getPseudo(),
                        'avatar' => $_SESSION['membre']->getAvatarInterne(),
                        'forum_name' => $forum['title'],
                        'id_thread' => $msg['id_thread'],
                        'subject' => $subject,
                        'text' => $text,
                    ];

                    Email::send(
                        $sub['email'],
                        "[AD'HOC] " . $_SESSION['membre']->getPseudo() . " a écrit un message dans le forum " . $forum['title'],
                        "forum-prive-new-message",
                        $data
                    );

                }
            }

            /* fin alerte mail aux abonnés */

            Tools::redirect('/adm/forums/forum/' . $msg['id_forum']);
        }

        $smarty = new AdHocSmarty();

        if (is_null($id_forum) && empty($id_thread)) {
            $smarty->assign('error_params', true);
        } elseif (!empty($id_thread)) {
            $id_forum = ForumPrive::getIdForumByIdThread($id_thread);
        } elseif (!is_null($id_forum)) {
            // rien
        }

        $forum = ForumPrive::getForum($id_forum);

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Forums", "/adm/forums/");
        $trail->addStep($forum['title'], "/adm/forums/forum/" . $forum['id_forum']);
        $trail->addStep("Ecrire un message");

        // box écrire
        $smarty->assign('subject', '');
        $smarty->assign('text', '');
        $smarty->assign('check', Tools::getCSRFToken());
        $smarty->assign('id_forum', $id_forum);
        $smarty->assign('id_thread', $id_thread);

        return $smarty->fetch('adm/forums/write.tpl');
    }
}
