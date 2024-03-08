<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Utils\EmailTwig;

/**
 *
 */
final class Controller
{
    /**
     * @return string
     */
    public static function formContactCc(): string
    {
        $twig = new EmailTwig();
        $twig->assign(
            [
                'name' => 'Mon nom',
                'email' => 'email@email.com',
                'date' => '2011-12-25 00:00:00',
                'subject' => 'Mon sujet',
                'text' => 'Mon texte',
            ]
        );
        return $twig->render('form-contact-cc.twig');
    }

    /**
     * @return string
     */
    public static function formContactTo(): string
    {
        $twig = new EmailTwig();
        return $twig->render('form-contact-to.twig');
    }

    /**
     * @return string
     */
    public static function forumPriveNewMessage(): string
    {
        $twig = new EmailTwig();
        return $twig->render('forum-prive-new-message.twig');
    }

    /**
     * @return string
     */
    public static function memberCreate(): string
    {
        $twig = new EmailTwig();
        return $twig->render('member-create.twig');
    }

    /**
     * @return string
     */
    public static function messageReceived(): string
    {
        $twig = new EmailTwig();
        return $twig->render('message-received.twig');
    }

    /**
     * @return string
     */
    public static function passwordChanged(): string
    {
        $twig = new EmailTwig();
        return $twig->render('password-changed.twig');
    }

    /**
     * @return string
     */
    public static function passwordLost(): string
    {
        $twig = new EmailTwig();
        return $twig->render('password-lost.twig');
    }

    /**
     * @return string
     */
    public static function newComment(): string
    {
        $twig = new EmailTwig();
        $twig->assign(
            [
                'subject' => "Un nouveau commentaire a été posté sur la vidéo machin",
                'pseudo' => 'pseudo',
                'date' => '2011-12-25 06:00:00',
                'title' => 'Titre du contenu',
                'url' => HOME_URL,
                'text' => 'Contenu du commentaire',
            ]
        );
        return $twig->render('new-comment.twig');
    }

    /**
     * @return string
     */
    public static function logAction(): string
    {
        $twig = new EmailTwig();
        $twig->assign(
            [
                'subject' => "gus a ajouté un nouveau lieu",
                'pseudo' => 'gus',
                'action' => 'a ajouté un nouveau lieu',
                'extra' => '1',
            ]
        );
        return $twig->render('log-action.twig');
    }
}
