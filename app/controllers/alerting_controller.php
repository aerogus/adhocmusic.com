<?php declare(strict_types=1);

final class Controller
{
    /**
     * @return string
     */
    static function my(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        Trail::getInstance()
            ->addStep('Tableau de bord', '/membres/tableau-de-bord')
            ->addStep('Mes alertes');

        $smarty = new AdHocSmarty();
        $smarty->assign('groupes', Alerting::getGroupesAlertingByIdContact($_SESSION['membre']->getId()));
        $smarty->assign('lieux', Alerting::getLieuxAlertingByIdContact($_SESSION['membre']->getId()));
        $smarty->assign('events', Alerting::getEventsAlertingByIdContact($_SESSION['membre']->getId()));
        return $smarty->fetch('alerting/my.tpl');
    }

    /**
     * @return string
     */
    static function sub(): string
    {
        if (Tools::isAuth() === false) {
            return 'not auth';
        }

        $id_contact = (int) $_SESSION['membre']->getId();
        $type = (string) Route::params('type');
        $id_content = (int) Route::params('id_content');

        $r = Alerting::addSubscriber($id_contact, $type, $id_content);

        switch ($type)
        {
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
    static function unsub(): string
    {
        if (Tools::isAuth() === false) {
            return 'not auth';
        }

        $id_contact = (int) $_SESSION['membre']->getId();
        $type = (string) Route::params('type');
        $id_content = (int) Route::params('id_content');

        $r = Alerting::delSubscriber($id_contact, $type, $id_content);

        switch ($type)
        {
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
