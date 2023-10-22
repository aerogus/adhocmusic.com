<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\AdHocSmarty;

/**
 *
 */
final class Controller
{
    /**
     *
     */
    public static function index(): string
    {
        Tools::auth(Membre::TYPE_ADMIN);

        $smarty = new AdHocSmarty();

        Trail::getInstance()
            ->addStep("Commentaires", '/comments');

        $comments = Comment::getComments(
            [
                'sort' => 'id',
                'sens' => 'DESC',
            ]
        );
        $smarty->assign('comments', $comments);

        return $smarty->fetch('comments/index.tpl');
    }

    /**
     * @return string
     */
    public static function show(): string
    {
        $id = (int) Route::params('id');
        $comment = Comment::getInstance($id);

        $smarty = new AdHocSmarty();
        $smarty->assign('comment', $comment);
        return $smarty->fetch('comments/show.tpl');
    }

    /**
     * @return string
     */
    public static function fetch(): string
    {
        $smarty = new AdHocSmarty();
        return $smarty->fetch('comments/fetch.tpl');
    }

    /**
     * @return string
     */
    public static function create(): string
    {
        $fp = fopen(ADHOC_ROOT_PATH . '/log/hack-comment.log', 'a');
        fwrite($fp, print_r($_GET, true) . "\n" . print_r($_POST, true) . "\n" . print_r($_SERVER, true));
        fclose($fp);
        die('hi');

        $data = [
            'type'       => (string) Route::params('type'),
            'id_content' => (int) Route::params('id_content'),
            'text'       => (string) Route::params('text'),
            'antispam'   => (string) Route::params('antispam'),
        ];

        if (!Tools::isAuth() && $data['antispam'] !== 'oui') {
            die('spam not allowed here !');
        }

        $comment = (new Comment())
            ->setType($data['type'])
            ->setIdContent($data['id_content'])
            ->setOnline(true)
            ->setText($data['text']);

        if (Tools::isAuth()) {
            $comment->setIdContact($_SESSION['membre']->getId())
                ->setPseudo($_SESSION['membre']->getPseudo())
                ->setEmail($_SESSION['membre']->getEmail());
        } else {
            $comment->setPseudo((string) Route::params('pseudo'))
                ->setEmail((string) Route::params('email'));
        }

        if ($id_comment = $comment->save()) {
            Log::action(Log::ACTION_COMMENT_CREATE, $comment->getText());
            $comment->sendNotifs();
            Tools::redirect($_SERVER['HTTP_REFERER']);
            return 'OK : ' . $id_comment;
        }
        return 'KO';
    }

    /**
     * @return string
     */
    public static function ajaxDelete(): string
    {
        $id = (int) Route::params('id');
        Tools::auth(Membre::TYPE_ADMIN);
        $comment = Comment::getInstance($id);
        if ($comment->delete()) {
            Log::action(Log::ACTION_COMMENT_DELETE, $comment->getId());
            return 'OK';
        }
        return 'KO';
    }

    /**
     * @return string
     */
    public static function delete(): string
    {
        $id = (int) Route::params('id');

        Tools::auth(Membre::TYPE_ADMIN);

        $comment = Comment::getInstance($id);

        $smarty = new AdHocSmarty();

        if (Tools::isSubmit('form-comment-delete')) {
            if ($comment->delete()) {
                Log::action(Log::ACTION_COMMENT_DELETE, $comment->getId());
                Tools::redirect('/comments/?delete=1');
            }
        }

        $smarty->assign('comment', $comment);

        return $smarty->fetch('comments/delete.tpl');
    }
}
