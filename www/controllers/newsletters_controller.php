<?php

class Controller
{
    static function index()
    {
        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Newsletters");

        $smarty->assign('newsletters', Newsletter::getNewsletters(array(
            'limit' => 50,
        )));

        return $smarty->fetch('newsletters/index.tpl');
    }

    static function show()
    {
        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        try {
            $newsletter = Newsletter::getInstance($id);
        } catch(AdHocUserException $e) {
            Route::set_http_code('404');
            $smarty->assign('unknown_newsletter', true);
            return $smarty->fetch('newsletters/show.tpl');
        }

        // oui je sais ...
        // @see EmailSmarty::modifier_link
        global $newsletter_id_newsletter;
               $newsletter_id_newsletter = $newsletter->getId();
        global $newsletter_id_contact;
               $newsletter_id_contact = 0;

        $smarty->assign('title', $newsletter->getTitle());
        $smarty->assign('description', substr(strip_tags($newsletter->getBodyHtml()), 0, 500));
        $smarty->assign('og_image', 'http://cache.adhocmusic.com/img/c/9/3/c938aee4553db039b3b6a8ca203f01a3.jpg'); // 5 nov.
        $smarty->assign('newsletter', $newsletter);

        $trail = Trail::getInstance();
        $trail->addStep("Newsletters", "/newsletters/");
        $trail->addStep($newsletter->getTitle());

        return $smarty->fetch('newsletters/show.tpl');
    }

    static function subscriptions()
    {
        $email = (string) Route::params('email');
        $action = (string) Route::params('action');

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Newsletters", "/newsletters/");
        $trail->addStep("Gestion de l'abonnement");

        $smarty->assign('email', $email);
        $smarty->assign('action', $action);

        if(Tools::isSubmit('form-newsletter'))
        {

        if(!Email::validate($email)) {

            $smarty->assign('error_email', true);

        } else {

            $smarty->assign('email', $email);

            switch($action)
            {
                case 'sub':
                    $ret = Newsletter::addEmail($email);
                    switch($ret)
                    {
                        case NEWSLETTER_SUB_OK_CONTACT_CREATED:
                        case NEWSLETTER_SUB_OK_RESUBSCRIBED_MEMBER:
                            Log::action(Log::ACTION_NEWSLETTER_SUB, $email);
                            $smarty->assign('ret', 'SUB-OK');
                            break;
                        case NEWSLETTER_SUB_KO_ALREADY_SUBSCRIBED_MEMBER:
                        case NEWSLETTER_SUB_KO_ALREADY_CONTACT:
                            $smarty->assign('ret', 'SUB-KO');
                            break;
                    }
                    break;

                case 'unsub':
                    $ret = Newsletter::removeEmail($email);
                    switch($ret)
                    {
                        case NEWSLETTER_UNSUB_OK_UNSUBSCRIBED_MEMBER:
                        case NEWSLETTER_UNSUB_OK_CONTACT_DELETED:
                            Log::action(Log::ACTION_NEWSLETTER_UNSUB, $email);
                            $smarty->assign('ret', 'UNSUB-OK');
                            break;
                        case NEWSLETTER_UNSUB_KO_ALREADY_UNSUBSCRIBED_MEMBER:
                        case NEWSLETTER_UNSUB_KO_UNKNOW_CONTACT:
                            $smarty->assign('ret', 'UNSUB-KO');
                            break;
                    }
                    break;
            }

        }

        } // isSubmit

        else {

            $smarty->assign('form', true);

        }

        return $smarty->fetch('newsletters/subscriptions.tpl');
    }
}
