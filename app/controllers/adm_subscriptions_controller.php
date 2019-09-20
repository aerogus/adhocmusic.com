<?php declare(strict_types=1);

/**
 *
 */
final class Controller
{
    /**
     * @return string
     */
    static function index(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        Trail::getInstance()
            ->addStep("Privé", "/adm/")
            ->addStep("Cotisations");

        $smarty->assign('subscriptions', Subscription::findAll());

        return $smarty->fetch('adm/subscriptions/index.tpl');
    }

    /**
     * @return string
     */
    static function create(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        Trail::getInstance()
            ->addStep("Privé", "/adm/")
            ->addStep("Cotisations", "/adm/subscriptions")
            ->addStep("Nouvelle cotisation");

        return $smarty->fetch('adm/subscriptions/create.tpl');
    }

    /**
     * @return string
     */
    static function edit(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        Trail::getInstance()
            ->addStep("Privé", "/adm/")
            ->addStep("Cotisations", "/adm/subscriptions")
            ->addStep("Édition");

        return $smarty->fetch('adm/subscriptions/edit.tpl');
    }

    /**
     * @return string
     */
    static function delete(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        Trail::getInstance()
            ->addStep("Privé", "/adm/")
            ->addStep("Cotisations", "/adm/subscriptions")
            ->addStep("Suppression");

        return $smarty->fetch('adm/subscriptions/delete.tpl');
    }
}