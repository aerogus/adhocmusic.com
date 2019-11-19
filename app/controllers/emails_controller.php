<?php declare(strict_types=1);

/**
 *
 */
final class Controller
{
    /**
     * @return string
     */
    static function form_contact_cc(): string
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
    static function form_contact_to(): string
    {
        $smarty = new EmailSmarty();
        return $smarty->fetch('form-contact-to.tpl');
    }

    /**
     * @return string
     */
    static function forum_prive_new_message(): string
    {
        $smarty = new EmailSmarty();
        return $smarty->fetch('forum-prive-new-message.tpl');
    }

    /**
     * @return string
     */
    static function member_create(): string
    {
        $smarty = new EmailSmarty();
        return $smarty->fetch('member-create.tpl');
    }

    /**
     * @return string
     */
    static function message_received(): string
    {
        $smarty = new EmailSmarty();
        return $smarty->fetch('message-received.tpl');
    }

    /**
     * @return string
     */
    static function password_changed(): string
    {
        $smarty = new EmailSmarty();
        return $smarty->fetch('password-changed.tpl');
    }

    /**
     * @return string
     */
    static function password_lost(): string
    {
        $smarty = new EmailSmarty();
        return $smarty->fetch('password-lost.tpl');
    }

    /**
     * @return string
     */
    static function new_comment(): string
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
    static function log_action(): string
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
