<?php

declare(strict_types=1);

namespace Adhoc\Controller;

final class Controller
{
    /**
     * @return string
     */
    public static function index(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        Trail::getInstance()
            ->addStep("Privé", "/adm")
            ->addStep("À l'affiche");

        $smarty = new AdHocSmarty();

        $smarty->assign(
            'featured_front',
            Featured::find(
                [
                    'online' => true,
                    'current' => true,
                    'order_by' => 'modified_at',
                    'sort' => 'DESC',
                    'limit' => 6,
                ]
            )
        );

        $smarty->assign(
            'featured_admin',
            Featured::find(
                [
                    'order_by' => 'id_featured',
                    'sort' => 'DESC',
                ]
            )
        );

        $smarty->enqueue_script('/js/swipe.min.js');
        $smarty->enqueue_script('/js/featured.js');

        return $smarty->fetch('adm/featured/index.tpl');
    }

    /**
     * @return string
     */
    public static function create(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        Trail::getInstance()
            ->addStep("Privé", "/adm")
            ->addStep("À l'affiche", "/adm/featured")
            ->addStep("Ajouter");

        $smarty = new AdHocSmarty();

        $smarty->enqueue_style('/css/jquery-ui.min.css');

        $smarty->enqueue_script('/js/jquery-ui.min.js');
        $smarty->enqueue_script('/js/jquery-ui-datepicker-fr.js');
        $smarty->enqueue_script('/js/adm/featured.js');

        // valeurs par défaut
        $data = [
            'title'       => '',
            'description' => '',
            'url'         => '',
            'datdeb'      => '',
            'datfin'      => '',
            'online'      => true,
        ];

        if (Tools::isSubmit('form-featured-create')) {
            $data = [
                'title'       => trim((string) Route::params('title')),
                'description' => trim((string) Route::params('description')),
                'url'         => trim((string) Route::params('url')),
                'datdeb'      => trim((string) Route::params('datdeb') . ' 00:00:00'),
                'datfin'      => trim((string) Route::params('datfin') . ' 23:59:59'),
                'online'      => (bool) Route::params('online'),
            ];
            $errors = [];

            if (self::validateForm($data, $errors)) {
                $f = (new Featured())
                    ->setTitle($data['title'])
                    ->setDescription($data['description'])
                    ->setUrl($data['url'])
                    ->setDatDeb($data['datdeb'])
                    ->setDatFin($data['datfin'])
                    ->setOnline($data['online']);
                $f->save();

                if (is_uploaded_file($_FILES['image']['tmp_name'])) {
                    (new Image($_FILES['image']['tmp_name']))
                        ->setType(IMAGETYPE_JPEG)
                        ->setMaxWidth(Featured::WIDTH)
                        ->setMaxHeight(Featured::HEIGHT)
                        ->setDestFile(Featured::getBasePath() . '/' . $f->getId() . '.jpg')
                        ->write();
                }

                Tools::redirect('/adm/featured?create=1');
            }

            if (!empty($errors)) {
                foreach ($errors as $k => $v) {
                    $smarty->assign('error_' . $k, $v);
                }
            }
        }

        $smarty->assign('data', $data);
        $smarty->assign(
            'events',
            Event::find(
                [
                    'online' => true,
                    'datdeb' => date('Y-m-d H:i:s'),
                    'order_by' => 'date',
                    'sort' => 'ASC',
                    'limit' => 500,
                ]
            )
        );

        return $smarty->fetch('adm/featured/create.tpl');
    }

    /**
     * @return string
     */
    public static function edit(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        Trail::getInstance()
            ->addStep("Privé", "/adm")
            ->addStep("À l'affiche", "/adm/featured")
            ->addStep("Modifier");

        $smarty = new AdHocSmarty();

        $smarty->enqueue_style('/css/jquery-ui.min.css');

        $smarty->enqueue_script('/js/jquery-ui.min.js');
        $smarty->enqueue_script('/js/jquery-ui-datepicker-fr.js');
        $smarty->enqueue_script('/js/adm/featured.js');

        $id = (int) Route::params('id');
        $f = Featured::getInstance($id);

        $data = [
            'id'          => $f->getId(),
            'title'       => $f->getTitle(),
            'description' => $f->getDescription(),
            'url'         => $f->getUrl(),
            'image'       => $f->getImage(),
            'datdeb'      => $f->getDatDeb(),
            'datfin'      => $f->getDatFin(),
            'online'      => $f->getOnline(),
        ];

        if (Tools::isSubmit('form-featured-edit')) {
            $data = [
                'id'          => $f->getId(),
                'title'       => trim((string) Route::params('title')),
                'description' => trim((string) Route::params('description')),
                'url'         => trim((string) Route::params('url')),
                'datdeb'      => trim((string) Route::params('datdeb') . ' 00:00:00'),
                'datfin'      => trim((string) Route::params('datfin') . ' 23:59:59'),
                'online'      => (bool) Route::params('online'),
            ];
            $errors = [];

            if (self::validateForm($data, $errors)) {
                $f->setTitle($data['title'])
                    ->setDescription($data['description'])
                    ->setUrl($data['url'])
                    ->setDatDeb($data['datdeb'])
                    ->setDatFin($data['datfin'])
                    ->setOnline($data['online']);

                $f->save();

                if (is_uploaded_file($_FILES['image']['tmp_name'])) {
                    (new Image($_FILES['image']['tmp_name']))
                        ->setType(IMAGETYPE_JPEG)
                        ->setMaxWidth(Featured::WIDTH)
                        ->setMaxHeight(Featured::HEIGHT)
                        ->setDestFile(Featured::getBasePath() . '/' . $f->getId() . '.jpg')
                        ->write();
                }

                Tools::redirect('/adm/featured?edit=1');
            }

            if (!empty($errors)) {
                foreach ($errors as $k => $v) {
                    $smarty->assign('error_' . $k, $v);
                }
            }
        }

        $smarty->assign('data', $data);

        return $smarty->fetch('adm/featured/edit.tpl');
    }

    /**
     * @return string
     */
    public static function delete(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        Trail::getInstance()
            ->addStep("Privé", "/adm")
            ->addStep("A l'Affiche", "/adm/featured")
            ->addStep("Supprimer");

        $smarty = new AdHocSmarty();

        $id = (int) Route::params('id');
        $f = Featured::getInstance($id);

        if (Tools::isSubmit('form-featured-delete')) {
            if ($f->delete()) {
                Tools::redirect('/adm/featured?delete=1');
                unlink(Featured::getBasePath() . '/' . $f->getId() . '.jpg');
            }
        }

        $smarty->assign('featured', $f);
        return $smarty->fetch('adm/featured/delete.tpl');
    }

    /**
     * Validation du formulaire featured
     *
     * @param array $data   tableau des données
     * @param array $errors tableau des erreurs (par référence)
     *
     * @return bool
     */
    private static function validateForm(array $data, array &$errors): bool
    {
        if (empty($data['title'])) {
            $errors['title'] = "Vous devez saisir un titre";
        }
        if (empty($data['description'])) {
            $errors['description'] = "Vous devez saisir une description";
        }
        if (empty($data['url'])) {
            $errors['url'] = "Vous devez saisir un lien de destination";
        }
        if (empty($data['datdeb'])) {
            $errors['datdeb'] = "Vous devez choisir une date de début de programmation";
        }
        if (empty($data['datfin'])) {
            $errors['datfin'] = "Vous devez saisir une date de fin de programmation";
        }
        if (count($errors)) {
            return false;
        }
        return true;
    }
}
