<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\Comment;
use Adhoc\Model\Membre;
use Adhoc\Utils\AdHocTwig;
use Adhoc\Utils\AdHocTwigBootstrap;
use Adhoc\Utils\Log;
use Adhoc\Utils\Route;
use Adhoc\Utils\Tools;
use Adhoc\Utils\Trail;

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

        $twig = new AdHocTwig();

        Trail::getInstance()
            ->addStep("Commentaires", '/comments');

        $comments = Comment::find(
            [
                'order_by' => 'id',
                'sort' => 'DESC',
            ]
        );
        $twig->assign('comments', $comments);

        return $twig->render('comments/index.twig');
    }

    /**
     * @return string
     */
    public static function show(): string
    {
        $id = (int) Route::params('id');
        $comment = Comment::getInstance($id);

        $twig = new AdHocTwig();
        $twig->assign('comment', $comment);
        return $twig->render('comments/show.twig');
    }

    /**
     * @return string
     */
    public static function fetch(): string
    {
        $twig = new AdHocTwig();
        return $twig->render('comments/fetch.twig');
    }

    /**
     * @return string
     */
    public static function create(): string
    {
        // log des trucs douteux
        $fp = fopen(ADHOC_ROOT_PATH . '/log/hack-comment.log', 'a');
        fwrite($fp, print_r($_GET, true) . "\n" . print_r($_POST, true) . "\n" . print_r($_SERVER, true));
        fclose($fp);

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
            $comment->setIdContact($_SESSION['membre']->getIdContact())
                ->setPseudo($_SESSION['membre']->getPseudo())
                ->setEmail($_SESSION['membre']->getEmail());
        } else {
            $comment->setPseudo((string) Route::params('pseudo'))
                ->setEmail((string) Route::params('email'));
        }

        if ($id_comment = $comment->save()) {
            Log::info("Comment create " . $comment->getText());
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
            Log::info("Commennt delete " . $comment->getIdComment());
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

        $twig = new AdHocTwig();

        if (Tools::isSubmit('form-comment-delete')) {
            if ($comment->delete()) {
                Log::info("Comment delete " . $comment->getIdComment());
                Tools::redirect('/comments/?delete=1');
            }
        }

        $twig->assign('comment', $comment);

        return $twig->render('comments/delete.twig');
    }
}
