<?php

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

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Cotisations");

        return $smarty->fetch('adm/subscriptions/index.tpl');
    }

    /**
     * @return string
     */
    static function create(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Cotisations", "/adm/subscriptions");
        $trail->addStep("Ajout");

        $sub = Subscription::init();
        $sub->setFirstName('Guillaume');
        $sub->setLastName('Seznec');
        $sub->save();

        return $smarty->fetch('adm/subscriptions/create.tpl');
    }

    /**
     * @return string
     */
    static function edit(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Cotisations", "/adm/subscriptions");
        $trail->addStep("Édition");

        return $smarty->fetch('adm/subscriptions/edit.tpl');
    }

    /**
     * @return string
     */
    static function delete(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Cotisations", "/adm/subscriptions");
        $trail->addStep("Suppression");

        return $smarty->fetch('adm/subscriptions/delete.tpl');
    }
}