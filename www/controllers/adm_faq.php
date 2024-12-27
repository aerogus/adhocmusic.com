<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\FAQ;
use Adhoc\Model\Membre;
use Adhoc\Model\FAQCategory;
use Adhoc\Utils\AdHocTwig;
use Adhoc\Utils\AdHocTwigBootstrap;
use Adhoc\Utils\Route;
use Adhoc\Utils\Tools;
use Adhoc\Utils\Trail;

final class Controller
{
    public static function index(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $twig = new AdHocTwig();

        Trail::getInstance()
            ->addStep('Privé', '/adm')
            ->addStep('Foire aux questions');

        $twig->assign('create', (bool) Route::params('create'));
        $twig->assign('edit', (bool) Route::params('edit'));
        $twig->assign('delete', (bool) Route::params('delete'));
        $twig->assign('faq', FAQ::findAll());

        return $twig->render('adm/faq/index.twig');
    }

    /**
     * @return string
     */
    public static function create(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $twig = new AdHocTwig();

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

        $twig->assign('categories', FAQCategory::findAll());

        return $twig->render('adm/faq/create.twig');
    }

    /**
     * @return string
     */
    public static function edit(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id_faq = (int) Route::params('id');

        $twig = new AdHocTwig();

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

        $twig->assign('categories', FAQCategory::findAll());
        $twig->assign('faq', FAQ::getInstance($id_faq));

        return $twig->render('adm/faq/edit.twig');
    }

    /**
     * @return string
     */
    public static function delete(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id = (int) Route::params('id');

        $twig = new AdHocTwig();

        Trail::getInstance()
            ->addStep('Privé', '/adm')
            ->addStep('Foire aux questions', '/adm/faq')
            ->addStep('Suppression');

        if (Tools::isSubmit('form-faq-delete')) {
            FAQ::getInstance($id)->delete();
            Tools::redirect('/adm/faq?delete=1');
        }

        $twig->assign('faq', FAQ::getInstance($id));

        return $twig->render('adm/faq/delete.twig');
    }
}
