<?php declare(strict_types=1);

/**
 *
 */
final class Controller
{
    /**
     * @return string
     */
    static function newsletter(): string
    {
        $id = (int) Route::params('id');

        try {
            $newsletter = Newsletter::getInstance($id);
        } catch (Exception $e) {
            Route::set_http_code(404);
            return 'newsletter introuvable';
        }

        // oui je sais ...
        // @see EmailSmarty::modifier_link
        global $newsletter_id_newsletter;
               $newsletter_id_newsletter = $newsletter->getId();
        global $newsletter_id_contact;
               $newsletter_id_contact = 0;

        $smarty = new EmailSmarty();
        $smarty->assign('id', $newsletter->getId());
        $smarty->assign('id_newsletter', $newsletter->getId());
        $smarty->assign('id_contact', 0);
        $smarty->assign('title', $newsletter->getTitle());
        $smarty->assign('email', '');
        $smarty->assign('url', $newsletter->getUrl());
        $smarty->assign('unsub_url', HOME_URL . '/newsletters/subscriptions?action=unsub&email=');
        return $smarty->fetch('newsletter-' . $newsletter->getId() . '.tpl');
    }

    /**
     * @return string
     */
    static function form_contact_cc(): string
    {
        $smarty = new EmailSmarty();
        $smarty->assign('name', 'Mon nom');
        $smarty->assign('email', 'email@email.com');
        $smarty->assign('date', '2011-12-25 00:00:00');
        $smarty->assign('subject', 'Mon sujet');
        $smarty->assign('text', 'Mon texte');
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
     *
     */
    static function one_year_unactive_member(): string
    {
        $smarty = new EmailSmarty();
        return $smarty->fetch('one-year-unactive-member.tpl');
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
    static function you_have_a_group(): string
    {
        $smarty = new EmailSmarty();
        return $smarty->fetch('you-have-a-group.tpl');
    }

    /**
     * @return string
     */
    static function you_have_a_lieu(): string
    {
        $smarty = new EmailSmarty();
        return $smarty->fetch('you-have-a-lieu.tpl');
    }

    /**
     * @return string
     */
    static function new_commentaire(): string
    {
        $smarty = new EmailSmarty();
        $smarty->assign('subject', "Un nouveau commentaire a été posté sur la vidéo machin");
        $smarty->assign('pseudo', 'pseudo');
        $smarty->assign('date', '2011-12-25 06:00:00');
        $smarty->assign('title', 'Titre du contenu');
        $smarty->assign('url', 'http://www.adhocmusic.com');
        $smarty->assign('text', 'Contenu du commentaire');
        return $smarty->fetch('new-commentaire.tpl');
    }

    /**
     * @return string
     */
    static function log_action(): string
    {
        $smarty = new EmailSmarty();
        $smarty->assign('subject', "gus a ajouté un nouveau lieu");
        $smarty->assign('pseudo', 'gus');
        $smarty->assign('action', 'a ajouté un nouveau lieu');
        $smarty->assign('extra', '1');
        return $smarty->fetch('log-action.tpl');
    }
}
