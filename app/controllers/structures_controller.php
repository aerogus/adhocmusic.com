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
        Trail::getInstance()
            ->addStep('Structures');

        $smarty = new AdHocSmarty();
        $smarty->assign('structures', Structure::findAll());
        return $smarty->fetch('structures/index.tpl');
    }

    /**
     * @return string
     */
    static function show(): string
    {
        $id = (int) Route::params('id');

        try {
            $structure = Structure::getInstance($id);
        } catch (Exception $e) {
            Route::set_http_code(404);
            $smarty->assign('unknown_structure', true);
            return $smarty->fetch('structures/show.tpl');
        }

        Trail::getInstance()
            ->addStep('Structures', '/structures')
            ->addStep($structure->getName());

        $smarty = new AdHocSmarty();

        $smarty->assign('structure', $structure);

        $smarty->assign(
            'events', Event::find(
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
    static function create(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $smarty = new AdHocSmarty();

        $smarty->enqueue_script('/js/structures/create.js');

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
            $errors = [];

            if (self::_validateStructureCreateForm($data, $errors)) {
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
    static function edit(): string
    {
        $id = (int) Route::params('id');

        Tools::auth(Membre::TYPE_STANDARD);

        $smarty = new AdHocSmarty();

        $smarty->enqueue_script('/js/structures/edit.js');

        if (Tools::isSubmit('form-structure-edit')) {
            $data = [
                'name' => (string) Route::params('name'),
            ];
            $errors = [];

            if (self::_validateStructureEditForm($data, $errors)) {
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
    static function delete(): string
    {
        $id = (int) Route::params('id');

        Tools::auth(Membre::TYPE_ADMIN);

        $structure = Structure::getInstance($id);

        $smarty = new AdHocSmarty();

        $smarty->enqueue_script('/js/structures/delete.js');

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
     * @param array $data   tableau des données
     * @param array $errors tableau des erreurs (par référence)
     *
     * @return bool
     */
    private static function _validateStructureCreateForm(array $data, array &$errors): bool
    {
        if (count($errors)) {
            return false;
        }
        return true;
    }

    /**
     * Validation du formulaire de modification structure
     *
     * @param array $data   tableau des données
     * @param array $errors tableau des erreurs (par référence)
     *
     * @return bool
     */
    private static function _validateStructureEditForm(array $data, array &$errors): bool
    {
        if (count($errors)) {
            return false;
        }
        return true;
    }
}
