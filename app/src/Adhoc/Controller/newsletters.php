<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\Newsletter;
use Adhoc\Utils\AdHocSmarty;
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
        $smarty = new AdHocSmarty();

        Trail::getInstance()
            ->addStep("Newsletters");

        $smarty->assign(
            'newsletters',
            Newsletter::find(
                [
                    'order_by' => 'id_newsletter',
                    'sort' => 'DESC',
                ]
            )
        );

        return $smarty->fetch('newsletters/index.tpl');
    }

    /**
     * @return string
     */
    public static function show(): string
    {
        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        try {
            $newsletter = Newsletter::getInstance($id);
            $smarty->assign('newsletter', $newsletter);
            return $smarty->fetch('newsletters/show.tpl');
        } catch (\Exception $e) {
            Route::setHttpCode(404);
            $smarty->assign('unknown_newsletter', true);
            return $smarty->fetch('newsletters/show.tpl');
        }
    }

    /**
     * @return string
     */
    public static function subscriptions(): string
    {
        $email = (string) Route::params('email');
        $action = (string) Route::params('action');

        $smarty = new AdHocSmarty();

        Trail::getInstance()
            ->addStep("Newsletters", "/newsletters")
            ->addStep("Gestion de l'abonnement");

        $smarty->assign('email', $email);
        $smarty->assign('action', $action);

        if (Tools::isSubmit('form-newsletter')) {
            if (!Email::validate($email)) {
                $smarty->assign('error_email', true);
            } else {
                $smarty->assign('email', $email);

                switch ($action) {
                    case 'sub':
                        $ret = Newsletter::addEmail($email);
                        switch ($ret) {
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
                        switch ($ret) {
                            case NEWSLETTER_UNSUB_OK_UNSUBSCRIBED_MEMBER:
                            case NEWSLETTER_UNSUB_OK_CONTACT_DELETED:
                                Log::action(Log::ACTION_NEWSLETTER_UNSUB, $email);
                                $smarty->assign('ret', 'UNSUB-OK');
                                break;
                            case NEWSLETTER_UNSUB_KO_ALREADY_UNSUBSCRIBED_MEMBER:
                            case NEWSLETTER_UNSUB_KO_UNKNOWN_CONTACT:
                                $smarty->assign('ret', 'UNSUB-KO');
                                break;
                        }
                        break;
                }
            }
        } else { // isSubmit
            $smarty->assign('form', true);
        }

        return $smarty->fetch('newsletters/subscriptions.tpl');
    }
}
