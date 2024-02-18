<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\Event;
use Adhoc\Model\Membre;
use Adhoc\Model\Structure;
use Adhoc\Utils\AdHocSmarty;
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
        Trail::getInstance()
            ->addStep('Structures');

        $smarty = new AdHocSmarty();
        $smarty->assign('structures', Structure::findAll());
        return $smarty->fetch('structures/index.tpl');
    }

    /**
     * @return string
     */
    public static function show(): string
    {
        $smarty = new AdHocSmarty();

        $id = (int) Route::params('id');

        try {
            $structure = Structure::getInstance($id);
        } catch (\Exception $e) {
            Route::setHttpCode(404);
            $smarty->assign('unknown_structure', true);
            return $smarty->fetch('structures/show.tpl');
        }

        Trail::getInstance()
            ->addStep('Structures', '/structures')
            ->addStep($structure->getName());

        $smarty->assign('structure', $structure);

        $smarty->assign(
            'events',
            Event::find(
                [
                    'id_structure' => $structure->getIdStructure(),
                    'online' => true,
                    'order_by' => 'date',
                    'sort' => 'ASC',
                    'limit' => 500,
                ]
            )
        );

        return $smarty->fetch('structures/show.tpl');
    }

    /**
     * @return string
     */
    public static function create(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $smarty = new AdHocSmarty();

        $smarty->enqueueScript('/js/structures/create.js');

        if (Tools::isSubmit('form-structure-create')) {
            $data = [
                'name' => (string) Route::params('name'),
                'id_departement' => '',
                'id_country' => 'FR',
                'city' => '',
                'cp' => '',
                'address' => '',
                'tel' => '',
                'text' => '',
                'site' => '',
                'email' => '',
            ];

            $errors = self::validateStructureCreateForm($data);
            if (count($errors) === 0) {
                (new Structure())
                    ->setName($data['name'])
                    ->save();
                Tools::redirect('/structures/?create=1');
            } else {
                // todo
            }
        }

        return $smarty->fetch('structures/create.tpl');
    }

    /**
     * @return string
     */
    public static function edit(): string
    {
        $id = (int) Route::params('id');

        Tools::auth(Membre::TYPE_STANDARD);

        $smarty = new AdHocSmarty();

        $smarty->enqueueScript('/js/structures/edit.js');

        if (Tools::isSubmit('form-structure-edit')) {
            $data = [
                'name' => (string) Route::params('name'),
            ];

            $errors = self::validateStructureEditForm($data);
            if (count($errors) === 0) {
                Structure::getInstance((int) Route::params('id'))
                    ->setName($data['name'])
                    ->save();
                Tools::redirect('/structures/?edit=1');
            } else {
                // todo
            }
        }

        $smarty->assign('structure', Structure::getInstance($id));

        return $smarty->fetch('structures/edit.tpl');
    }

    /**
     * @return string
     */
    public static function delete(): string
    {
        $id = (int) Route::params('id');

        Tools::auth(Membre::TYPE_ADMIN);

        $structure = Structure::getInstance($id);

        $smarty = new AdHocSmarty();

        $smarty->enqueueScript('/js/structures/delete.js');

        if (Tools::isSubmit('form-structure-delete')) {
            if ($structure->delete()) {
                Tools::redirect('/structures/?delete=1');
            }
        }

        $smarty->assign('structure', $structure);

        return $smarty->fetch('structures/delete.tpl');
    }

    /**
     * Validation du formulaire de création structure
     *
     * @param array<string,mixed> $data tableau des données
     *
     * @return array<string,true>
     */
    private static function validateStructureCreateForm(array $data): array
    {
        $errors = [];

        return $errors;
    }

    /**
     * Validation du formulaire de modification structure
     *
     * @param array<string,mixed> $data tableau des données
     *
     * @return array<string,true>
     */
    private static function validateStructureEditForm(array $data): array
    {
        $errors = [];

        return $errors;
    }
}
