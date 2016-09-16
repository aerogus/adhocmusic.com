<?php

class Controller
{
    static function index()
    {
        Tools::auth(Membre::TYPE_ADMIN);

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Commentaires", '/comments/');

        $comments = Comment::getComments(array(
            'sort' => 'id',
            'sens' => 'DESC',
        ));
        $smarty->assign('comments', $comments);

        return $smarty->fetch('comments/index.tpl');
    }

    static function show()
    {
        $id = (int) Route::params('id');
        $comment = Comment::getInstance($id);

        $smarty = new AdHocSmarty();
        $smarty->assign('comment', $comment);
        return $smarty->fetch('comments/show.tpl');
    }

    static function fetch()
    {
        $smarty = new AdHocSmarty();
        return $smarty->fetch('comments/fetch.tpl');
    }

    static function create()
    {
        $fp = fopen('/var/www/adhocmusic.com/log/hack-comment.log', 'a');
        fwrite($fp, print_r($_GET, true) . "\n" . print_r($_POST, true) . "\n" . print_r($_SERVER, true));
        fclose($fp);
        die('hi');

        $data = array(
            'type'       => (string) Route::params('type'),
            'id_content' => (int) Route::params('id_content'),
            'text'       => (string) Route::params('text'),
            'antispam'   => (string) Route::params('antispam'),
        );

        if(!Tools::isAuth() && $data['antispam'] !== 'oui') {
            die('spam not allowed here !');
        }

        $comment = Comment::init();
        $comment->setType($data['type']);
        $comment->setIdContent($data['id_content']);
        $comment->setCreatedNow();
        $comment->setOnline(true);
        $comment->setText($data['text']);

        if(Tools::isAuth()) {
            $comment->setIdContact($_SESSION['membre']->getId());
            $comment->setPseudo($_SESSION['membre']->getPseudo());
            $comment->setEmail($_SESSION['membre']->getEmail());
        } else {
            $comment->setPseudo((string) Route::params('pseudo'));
            $comment->setEmail((string) Route::params('email'));
        }

        if($id_comment = $comment->save()) {
            Log::action(Log::ACTION_COMMENT_CREATE, $comment->getText());
            $comment->sendNotifs();
            Tools::redirect($_SERVER['HTTP_REFERER']);
            return 'OK : ' . $id_comment;
        }
        return 'KO';
    }

    static function ajax_delete()
    {
        $id = (int) Route::params('id');
        Tools::auth(Membre::TYPE_ADMIN);
        $comment = Comment::getInstance($id);
        if($comment->delete()) {
            Log::action(Log::ACTION_COMMENT_DELETE, $comment->getId());
            return 'OK';
        }
        return 'KO';
    }

    static function delete()
    {
        $id = (int) Route::params('id');

        Tools::auth(Membre::TYPE_ADMIN);

        $comment = Comment::getInstance($id);

        $smarty = new AdHocSmarty();

        if(Tools::isSubmit('form-comment-delete'))
        {
            if($comment->delete())
            {
                Log::action(Log::ACTION_COMMENT_DELETE, $comment->getId());
                Tools::redirect('/comments/?delete=1');
            }
        }

        $smarty->assign('comment', $comment);

        return $smarty->fetch('comments/delete.tpl');
    }
}
