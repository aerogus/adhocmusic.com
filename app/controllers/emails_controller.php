<?php

declare(strict_types=1);

namespace Adhoc\Controller;

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
        $smarty = new EmailSmarty();
        $smarty->assign(
            [
                'name' => 'Mon nom',
                'email' => 'email@email.com',
                'date' => '2011-12-25 00:00:00',
                'subject' => 'Mon sujet',
                'text' => 'Mon texte',
            ]
        );
        return $smarty->fetch('form-contact-cc.tpl');
    }

    /**
     * @return string
     */
    public static function formContactTo(): string
    {
        $smarty = new EmailSmarty();
        return $smarty->fetch('form-contact-to.tpl');
    }

    /**
     * @return string
     */
    public static function forumPriveNewMessage(): string
    {
        $smarty = new EmailSmarty();
        return $smarty->fetch('forum-prive-new-message.tpl');
    }

    /**
     * @return string
     */
    public static function memberCreate(): string
    {
        $smarty = new EmailSmarty();
        return $smarty->fetch('member-create.tpl');
    }

    /**
     * @return string
     */
    public static function messageReceived(): string
    {
        $smarty = new EmailSmarty();
        return $smarty->fetch('message-received.tpl');
    }

    /**
     * @return string
     */
    public static function passwordChanged(): string
    {
        $smarty = new EmailSmarty();
        return $smarty->fetch('password-changed.tpl');
    }

    /**
     * @return string
     */
    public static function passwordLost(): string
    {
        $smarty = new EmailSmarty();
        return $smarty->fetch('password-lost.tpl');
    }

    /**
     * @return string
     */
    public static function newComment(): string
    {
        $smarty = new EmailSmarty();
        $smarty->assign(
            [
                'subject' => "Un nouveau commentaire a été posté sur la vidéo machin",
                'pseudo' => 'pseudo',
                'date' => '2011-12-25 06:00:00',
                'title' => 'Titre du contenu',
                'url' => HOME_URL,
                'text' => 'Contenu du commentaire',
            ]
        );
        return $smarty->fetch('new-comment.tpl');
    }

    /**
     * @return string
     */
    public static function logAction(): string
    {
        $smarty = new EmailSmarty();
        $smarty->assign(
            [
                'subject' => "gus a ajouté un nouveau lieu",
                'pseudo' => 'gus',
                'action' => 'a ajouté un nouveau lieu',
                'extra' => '1',
            ]
        );
        return $smarty->fetch('log-action.tpl');
    }
}
