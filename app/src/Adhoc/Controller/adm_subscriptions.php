<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\Membre;
use Adhoc\Model\Subscription;
use Adhoc\Utils\AdHocSmarty;
use Adhoc\Utils\Route;
use Adhoc\Utils\Tools;
use Adhoc\Utils\Trail;

/**
 * Controlleur des cotisations
 */
final class Controller
{
    /**
     * @return string
     */
    public static function index(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        Trail::getInstance()
            ->addStep("Privé", "/adm")
            ->addStep("Cotisations");

        $smarty->assign('subscriptions', Subscription::findAll());

        return $smarty->fetch('adm/subscriptions/index.tpl');
    }

    /**
     * @return string
     */
    public static function create(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        Trail::getInstance()
            ->addStep("Privé", "/adm")
            ->addStep("Cotisations", "/adm/subscriptions")
            ->addStep("Nouvelle cotisation");

        return $smarty->fetch('adm/subscriptions/create.tpl');
    }

    /**
     * @return string
     */
    public static function edit(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        Trail::getInstance()
            ->addStep("Privé", "/adm")
            ->addStep("Cotisations", "/adm/subscriptions")
            ->addStep("Édition");

        return $smarty->fetch('adm/subscriptions/edit.tpl');
    }

    /**
     * @return string
     */
    public static function delete(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        Trail::getInstance()
            ->addStep("Privé", "/adm")
            ->addStep("Cotisations", "/adm/subscriptions")
            ->addStep("Suppression");

        return $smarty->fetch('adm/subscriptions/delete.tpl');
    }

    /**
     * Test api:
     * http -v --verify=no GET https://www.adhocmusic.test/api/subscriptions/list.json
     *
     * @return array<\stdClass>
     */
    public static function apiList(): array
    {
        //Tools::auth(Membre::TYPE_INTERNE);

        $ret = [];
        $subs = Subscription::findAll();
        foreach ($subs as $sub) {
            $_sub = (object) [
                'id' => (int) $sub->getId(),
                'created_at' => $sub->getCreatedAt(),
                'subscribed_at' => $sub->getSubscribedAt(),
                'amount' => $sub->getAmount(),
                'adult' => $sub->getAdult(),
                'first_name' => $sub->getFirstName(),
                'last_name' => $sub->getLastName(),
                'email' => $sub->getEmail(),
                'cp' => $sub->getCp(),
                'id_contact' => $sub->getIdContact(),
            ];
            $ret[] = $_sub;
        }
        return $ret;
    }

    /**
     * Test API avec httpie:
     * http -v -f --verify=no POST https://www.adhocmusic.test/api/subscriptions/create.json first_name=Guillaume
     *
     * @return array<string,mixed>
     */
    public static function apiCreate(): array
    {
        //Tools::auth(Membre::TYPE_INTERNE);

        $s = new Subscription();

        if (!is_null(Route::params('subscribed_at'))) {
            $s->setSubscribedAt((string) Route::params('subscribed_at'));
        }
        if (!is_null(Route::params('amount'))) {
            $s->setAmount((float) Route::params('amount'));
        }
        if (!is_null(Route::params('first_name'))) {
            $s->setFirstName((string) Route::params('first_name'));
        }
        if (!is_null(Route::params('last_name'))) {
            $s->setLastName((string) Route::params('last_name'));
        }
        if (!is_null(Route::params('adult'))) {
            $s->setAdult((bool) Route::params('adult'));
        }
        if (!is_null(Route::params('email'))) {
            $s->setemail((string) Route::params('email'));
        }
        if (!is_null(Route::params('cp'))) {
            $s->setCp((string) Route::params('cp'));
        }

        if ($id = $s->save()) {
            return [
                'success' => true,
                'id' => $id,
            ];
        } else {
            return [
                'success' => false,
            ];
        }
    }

    /**
     * Test API avec httpie:
     * http -v -f --verify=no POST https://www.adhocmusic.test/api/subscriptions/edit/15.json first_name=Guillaume
     *
     * @return array<string,mixed>
     */
    public static function apiEdit(): array
    {
        //Tools::auth(Membre::TYPE_INTERNE);

        $s = Subscription::getInstance((int) Route::params('id'));

        if (!is_null(Route::params('subscribed_at'))) {
            $s->setSubscribedAt((string) Route::params('subscribed_at'));
        }
        if (!is_null(Route::params('amount'))) {
            $s->setAmount((float) Route::params('amount'));
        }
        if (!is_null(Route::params('first_name'))) {
            $s->setFirstName((string) Route::params('first_name'));
        }
        if (!is_null(Route::params('last_name'))) {
            $s->setLastName((string) Route::params('last_name'));
        }
        if (!is_null(Route::params('adult'))) {
            $s->setAdult((bool) Route::params('adult'));
        }
        if (!is_null(Route::params('email'))) {
            $s->setEmail((string) Route::params('email'));
        }
        if (!is_null(Route::params('cp'))) {
            $s->setCp((string) Route::params('cp'));
        }
        if ($s->save()) {
            return [
                'success' => true,
                'message' => "Cotisation ajoutée",
                'results' => [
                    'id' => $s->getId(),
                ],
            ];
        } else {
            return [
                'success' => false,
                'message' => "Cotisation non ajoutée",
            ];
        }
    }

    /**
     * Suppression d'une cotisation
     *
     * Test API avec httpie:
     * http -v -f --verify=no POST https://www.adhocmusic.test/api/subscriptions/delete/15.json
     *
     * @return array<string,mixed>
     */
    public static function apiDelete(): array
    {
        // Tools::auth(Membre::TYPE_INTERNE);

        try {
            Subscription::getInstance(Route::params('id'))
                ->delete();
            return [
                'success' => true,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
