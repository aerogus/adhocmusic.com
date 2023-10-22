<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\AdHocSmarty;
use Adhoc\Model\Reference\FAQCategory;

final class Controller
{
    public static function index(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        Trail::getInstance()
            ->addStep('Privé', '/adm')
            ->addStep('Foire aux questions');

        $smarty->assign('create', (bool) Route::params('create'));
        $smarty->assign('edit', (bool) Route::params('edit'));
        $smarty->assign('delete', (bool) Route::params('delete'));
        $smarty->assign('faq', FAQ::findAll());

        return $smarty->fetch('adm/faq/index.tpl');
    }

    /**
     * @return string
     */
    public static function create(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        Trail::getInstance()
            ->addStep('Privé', '/adm')
            ->addStep('Foire aux questions', '/adm/faq')
            ->addStep('Création');

        if (Tools::isSubmit('form-faq-create')) {
            $data = [
                'id_category' => (int) Route::params('id_category'),
                'question'    => (string) Route::params('question'),
                'answer'      => (string) Route::params('answer'),
                'online'      => (bool) Route::params('online'),
            ];

            (new FAQ())
                ->setIdCategory($data['id_category'])
                ->setQuestion($data['question'])
                ->setAnswer($data['answer'])
                ->setOnline($data['online'])
                ->save();

            Tools::redirect('/adm/faq?create=1');
        }

        $smarty->assign('categories', FAQCategory::findAll());

        return $smarty->fetch('adm/faq/create.tpl');
    }

    /**
     * @return string
     */
    public static function edit(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id_faq = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        Trail::getInstance()
            ->addStep('Privé', '/adm')
            ->addStep('Foire aux questions', '/adm/faq')
            ->addStep('Édition');

        if (Tools::isSubmit('form-faq-edit')) {
            $data = [
                'id_faq'      => (int) Route::params('id_faq'),
                'id_category' => (int) Route::params('id_category'),
                'question'    => (string) Route::params('question'),
                'answer'      => (string) Route::params('answer'),
                'online'      => (bool) Route::params('online'),
            ];

            FAQ::getInstance($data['id_faq'])
                ->setIdCategory($data['id_category'])
                ->setQuestion($data['question'])
                ->setAnswer($data['answer'])
                ->setOnline($data['online'])
                ->save();

            Tools::redirect('/adm/faq?edit=1');
        }

        $smarty->assign('categories', FAQCategory::findAll());
        $smarty->assign('faq', FAQ::getInstance($id_faq));

        return $smarty->fetch('adm/faq/edit.tpl');
    }

    /**
     * @return string
     */
    public static function delete(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        Trail::getInstance()
            ->addStep('Privé', '/adm')
            ->addStep('Foire aux questions', '/adm/faq')
            ->addStep('Suppression');

        if (Tools::isSubmit('form-faq-delete')) {
            FAQ::getInstance($id)->delete();
            Tools::redirect('/adm/faq?delete=1');
        }

        $smarty->assign('faq', FAQ::getInstance($id));

        return $smarty->fetch('adm/faq/delete.tpl');
    }
}
