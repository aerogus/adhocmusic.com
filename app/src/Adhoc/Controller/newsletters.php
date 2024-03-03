<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\Newsletter;
use Adhoc\Utils\AdHocTwig;
use Adhoc\Utils\Email;
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
     * @return string
     */
    public static function index(): string
    {
        $twig = new AdHocTwig();

        Trail::getInstance()
            ->addStep("Newsletters");

        $twig->assign(
            'newsletters',
            Newsletter::find(
                [
                    'order_by' => 'id_newsletter',
                    'sort' => 'DESC',
                ]
            )
        );

        return $twig->render('newsletters/index.twig');
    }

    /**
     * @return string
     */
    public static function show(): string
    {
        $id = (int) Route::params('id');

        $twig = new AdHocTwig();

        try {
            $newsletter = Newsletter::getInstance($id);
            $twig->assign('newsletter', $newsletter);
            return $twig->render('newsletters/show.twig');
        } catch (\Exception $e) {
            Route::setHttpCode(404);
            $twig->assign('unknown_newsletter', true);
            return $twig->render('newsletters/show.twig');
        }
    }

    /**
     * @return string
     */
    public static function subscriptions(): string
    {
        $email = (string) Route::params('email');
        $action = (string) Route::params('action');

        $twig = new AdHocTwig();

        Trail::getInstance()
            ->addStep("Newsletters", "/newsletters")
            ->addStep("Gestion de l'abonnement");

        $twig->assign('email', $email);
        $twig->assign('action', $action);

        if (Tools::isSubmit('form-newsletter')) {
            if (!Email::validate($email)) {
                $twig->assign('error_email', true);
            } else {
                $twig->assign('email', $email);

                switch ($action) {
                    case 'sub':
                        $ret = Newsletter::addEmail($email);
                        switch ($ret) {
                            case NEWSLETTER_SUB_OK_CONTACT_CREATED:
                            case NEWSLETTER_SUB_OK_RESUBSCRIBED_MEMBER:
                                Log::action(Log::ACTION_NEWSLETTER_SUB, $email);
                                $twig->assign('ret', 'SUB-OK');
                                break;
                            case NEWSLETTER_SUB_KO_ALREADY_SUBSCRIBED_MEMBER:
                            case NEWSLETTER_SUB_KO_ALREADY_CONTACT:
                                $twig->assign('ret', 'SUB-KO');
                                break;
                        }
                        break;

                    case 'unsub':
                        $ret = Newsletter::removeEmail($email);
                        switch ($ret) {
                            case NEWSLETTER_UNSUB_OK_UNSUBSCRIBED_MEMBER:
                            case NEWSLETTER_UNSUB_OK_CONTACT_DELETED:
                                Log::action(Log::ACTION_NEWSLETTER_UNSUB, $email);
                                $twig->assign('ret', 'UNSUB-OK');
                                break;
                            case NEWSLETTER_UNSUB_KO_ALREADY_UNSUBSCRIBED_MEMBER:
                            case NEWSLETTER_UNSUB_KO_UNKNOWN_CONTACT:
                                $twig->assign('ret', 'UNSUB-KO');
                                break;
                        }
                        break;
                }
            }
        } else { // isSubmit
            $twig->assign('form', true);
        }

        return $twig->render('newsletters/subscriptions.twig');
    }
}
