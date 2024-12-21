<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\ForumPrive;
use Adhoc\Model\Membre;
use Adhoc\Utils\AdHocTwig;
use Adhoc\Utils\Email;
use Adhoc\Utils\Route;
use Adhoc\Utils\Tools;
use Adhoc\Utils\Trail;

final class Controller
{
    public static function index(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $twig = new AdHocTwig();

        Trail::getInstance()
            ->addStep("Privé", "/adm")
            ->addStep("Forums");

        $twig->assign('forums', ForumPrive::getForums());

        return $twig->render('adm/forums/index.twig');
    }

    public static function forum(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id_forum = Route::params('id_forum');
        $page = (int) Route::params('page');

        $forum = ForumPrive::getForum($id_forum);

        $twig = new AdHocTwig();

        Trail::getInstance()
            ->addStep("Privé", "/adm")
            ->addStep("Forums", "/adm/forums")
            ->addStep($forum['title']);

        $twig->enqueueScript('/js/adm/forums.js');

        $twig->assign('subs', ForumPrive::getSubscribers($id_forum));
        $twig->assign('forum', $forum);
        $twig->assign('threads', ForumPrive::getThreads($id_forum, $page));

        $twig->assign('nb_items', ForumPrive::getThreadsCount($id_forum));
        $twig->assign('nb_items_per_page', FORUM_NB_THREADS_PER_PAGE);
        $twig->assign('page', $page);

        return $twig->render('adm/forums/forum.twig');
    }

    public static function thread(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id_thread = (int) Route::params('id_thread');
        $page = (int) Route::params('page');

        $twig = new AdHocTwig();

        $data = ForumPrive::getMessages($id_thread, $page);
        $forum = ForumPrive::getForum($data['thread']['id_forum']);

        Trail::getInstance()
            ->addStep("Privé", "/adm")
            ->addStep("Forums", "/adm/forums")
            ->addStep($forum['title'], "/adm/forums/forum/" . $forum['id_forum'])
            ->addStep($data['thread']['subject']);

        $twig->assign('id_forum', $forum['id_forum']);
        $twig->assign('id_thread', $id_thread);

        $twig->assign('subs', ForumPrive::getSubscribers($forum['id_forum']));
        $twig->assign('thread', $data['thread']);
        $twig->assign('messages', $data['messages']);

        $twig->assign('nb_items', $data['thread']['nb_messages']);
        $twig->assign('nb_items_per_page', FORUM_NB_MESSAGES_PER_PAGE);
        $twig->assign('page', $page);

        ForumPrive::addView($id_thread);

        // box écrire
        $twig->assign('text', '');
        $twig->assign('check', Tools::getCSRFToken());

        return $twig->render('adm/forums/thread.twig');
    }

    public static function write(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id_forum  = Route::params('id_forum');
        $id_thread = (int) Route::params('id_thread');

        if (Tools::isSubmit('form-forum-write')) {
            // a debuger
            /*
            if (Tools::checkCSRFToken((string) Route::params('check')) === false) {
                //die('csrf fail'); // mauvais code sécurité
            }
            */

            $subject   = (string) Route::params('subject');
            $text      = (string) Route::params('text');

            $msg = ForumPrive::addMessage(
                [
                    'id_contact' => $_SESSION['membre']->getIdContact(),
                    'id_forum'   => $id_forum,
                    'id_thread'  => $id_thread,
                    'subject'    => $subject,
                    'text'       => $text,
                ]
            );

            /* début alerte mail aux abonnés */

            $subs = ForumPrive::getSubscribers($msg['id_forum']);
            $forum = ForumPrive::getForum($msg['id_forum']);
            if (strlen($subject) > 0) {
                $msgs = ForumPrive::getMessages($msg['id_thread']);
                $subject = $msgs['thread']['subject'];
            }

            if (count($subs) > 0) {
                foreach ($subs as $sub) {
                    $data = [
                        'title' => 'Nouveau message',
                        'pseudo_to' => $sub['pseudo'],
                        'pseudo_from' => $_SESSION['membre']->getPseudo(),
                        'avatar' => $_SESSION['membre']->getAvatarInterneUrl(),
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

        $twig = new AdHocTwig();

        if (is_null($id_forum) && ($id_thread === 0)) {
            $twig->assign('error_params', true);
        } elseif ($id_thread !== 0) {
            $id_forum = ForumPrive::getIdForumByIdThread($id_thread);
        }

        $forum = ForumPrive::getForum($id_forum);

        Trail::getInstance()
            ->addStep("Privé", "/adm")
            ->addStep("Forums", "/adm/forums")
            ->addStep($forum['title'], "/adm/forums/forum/" . $forum['id_forum'])
            ->addStep("Ecrire un message");

        // box écrire
        $twig->assign('subject', '');
        $twig->assign('text', '');
        $twig->assign('check', Tools::getCSRFToken());
        $twig->assign('id_forum', $id_forum);
        $twig->assign('id_thread', $id_thread);

        return $twig->render('adm/forums/write.twig');
    }
}
