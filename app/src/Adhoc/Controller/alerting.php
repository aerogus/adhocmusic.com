<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\AdHocSmarty;
use Adhoc\Model\Alerting;
use Adhoc\Model\Event;
use Adhoc\Model\Groupe;
use Adhoc\Model\Lieu;
use Adhoc\Model\Log;
use Adhoc\Model\Membre;
use Adhoc\Model\Route;
use Adhoc\Model\Tools;
use Adhoc\Model\Trail;

final class Controller
{
    /**
     * @return string
     */
    public static function my(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        Trail::getInstance()
            ->addStep('Tableau de bord', '/membres/tableau-de-bord')
            ->addStep('Mes alertes');

        $myAlerting = Alerting::find(['id_contact' => $_SESSION['membre']->getId()]);
        $myAlertingLieu = $myAlertingGroupe = $myAlertingEvent =  [];
        foreach ($myAlerting as $ma) {
            if ($ma->getIdLieu()) {
                $myAlertingLieu[] = Lieu::getInstance($ma->getIdLieu());
            } elseif ($ma->getIdGroupe()) {
                $myAlertingGroupe[] = Groupe::getInstance($ma->getIdGroupe());
            } elseif ($ma->getIdEvent()) {
                $myAlertingEvent[] = Event::getInstance($ma->getIdEvent());
            }
        }
        $smarty = new AdHocSmarty();
        $smarty->assign('lieux', $myAlertingLieu);
        $smarty->assign('groupes', $myAlertingGroupe);
        $smarty->assign('events', $myAlertingEvent);
        return $smarty->fetch('alerting/my.tpl');
    }

    /**
     * @return string
     */
    public static function sub(): string
    {
        if (Tools::isAuth() === false) {
            return 'not auth';
        }

        $id_contact = (int) $_SESSION['membre']->getId();
        $type = (string) Route::params('type');
        $id_content = (int) Route::params('id_content');

        $r = Alerting::addSubscriber($id_contact, $type, $id_content);

        switch ($type) {
            case 'g':
                Log::action(Log::ACTION_ALERTING_GROUPE_SUB, $id_content);
                //Tools::redirect(Groupe::getInstance($id_content)->getUrl());
                Tools::redirect($_SERVER['HTTP_REFERER']);
                break;
            case 'l':
                Log::action(Log::ACTION_ALERTING_LIEU_SUB, $id_content);
                //Tools::redirect(Lieu::getInstance($id_content)->getUrl());
                Tools::redirect($_SERVER['HTTP_REFERER']);
                break;
            case 'e':
                Log::action(Log::ACTION_ALERTING_EVENT_SUB, $id_content);
                //Tools::redirect(Event::getInstance($id_content)->getUrl());
                Tools::redirect($_SERVER['HTTP_REFERER']);
                break;
        }

        return 'res: ' . $r;
    }

    /**
     * @return string
     */
    public static function unsub(): string
    {
        if (Tools::isAuth() === false) {
            return 'not auth';
        }

        $id_contact = (int) $_SESSION['membre']->getId();
        $type = (string) Route::params('type');
        $id_content = (int) Route::params('id_content');

        $r = Alerting::delSubscriber($id_contact, $type, $id_content);

        switch ($type) {
            case 'g':
                Log::action(Log::ACTION_ALERTING_GROUPE_UNSUB, $id_content);
                //Tools::redirect(Groupe::getInstance($id_content)->getUrl());
                Tools::redirect($_SERVER['HTTP_REFERER']);
                break;
            case 'l':
                Log::action(Log::ACTION_ALERTING_LIEU_UNSUB, $id_content);
                //Tools::redirect(Lieu::getInstance($id_content)->getUrl());
                Tools::redirect($_SERVER['HTTP_REFERER']);
                break;
            case 'e':
                Log::action(Log::ACTION_ALERTING_EVENT_UNSUB, $id_content);
                //Tools::redirect(Event::getInstance($id_content)->getUrl());
                Tools::redirect($_SERVER['HTTP_REFERER']);
                break;
        }

        return 'res: ' . $r;
    }
}
