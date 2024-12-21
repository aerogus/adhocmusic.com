<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\Event;
use Adhoc\Model\Featured;
use Adhoc\Model\Membre;
use Adhoc\Utils\AdHocTwig;
use Adhoc\Utils\Image;
use Adhoc\Utils\Route;
use Adhoc\Utils\Tools;
use Adhoc\Utils\Trail;

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

        $twig = new AdHocTwig();

        $twig->assign(
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

        $twig->assign(
            'featured_admin',
            Featured::find(
                [
                    'order_by' => 'id_featured',
                    'sort' => 'DESC',
                ]
            )
        );

        $twig->enqueueScript('/static/library/swipe@2.0.0/swipe.min.js');
        $twig->enqueueScript('/js/featured.js');

        return $twig->render('adm/featured/index.twig');
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

        $twig = new AdHocTwig();

        $twig->enqueueStyle('/static/library/jquery-ui@1.11.4/jquery-ui.min.css');

        $twig->enqueueScript('/static/library/jquery-ui@1.11.4/jquery-ui.min.js');
        $twig->enqueueScript('/static/library/jquery-ui@1.11.4/jquery-ui-datepicker-fr.js');
        $twig->enqueueScript('/js/adm/featured.js');

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

            $errors = self::validateForm($data);
            if (count($errors) === 0) {
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
                        ->setDestFile(Featured::getBasePath() . '/' . $f->getIdFeatured() . '.jpg')
                        ->write();
                }

                Tools::redirect('/adm/featured?create=1');
            }

            if (count($errors) > 0) {
                foreach ($errors as $k => $v) {
                    $twig->assign('error_' . $k, $v);
                }
            }
        }

        $twig->assign('data', $data);
        $twig->assign(
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

        return $twig->render('adm/featured/create.twig');
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

        $twig = new AdHocTwig();

        $twig->enqueueStyle('/static/library/jquery-ui@1.11.4/jquery-ui.min.css');

        $twig->enqueueScript('/static/library/jquery-ui@1.11.4/jquery-ui.min.js');
        $twig->enqueueScript('/static/library/jquery-ui@1.11.4/jquery-ui-datepicker-fr.js');
        $twig->enqueueScript('/js/adm/featured.js');

        $id = (int) Route::params('id');
        $f = Featured::getInstance($id);

        $data = [
            'id'          => $f->getIdFeatured(),
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
                'id'          => $f->getIdFeatured(),
                'title'       => trim((string) Route::params('title')),
                'description' => trim((string) Route::params('description')),
                'url'         => trim((string) Route::params('url')),
                'datdeb'      => trim((string) Route::params('datdeb') . ' 00:00:00'),
                'datfin'      => trim((string) Route::params('datfin') . ' 23:59:59'),
                'online'      => (bool) Route::params('online'),
            ];

            $errors = self::validateForm($data);
            if (count($errors) === 0) {
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
                        ->setDestFile(Featured::getBasePath() . '/' . $f->getIdFeatured() . '.jpg')
                        ->write();
                }

                Tools::redirect('/adm/featured?edit=1');
            }

            if (count($errors) > 0) {
                foreach ($errors as $k => $v) {
                    $twig->assign('error_' . $k, $v);
                }
            }
        }

        $twig->assign('data', $data);

        return $twig->render('adm/featured/edit.twig');
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

        $twig = new AdHocTwig();

        $id = (int) Route::params('id');
        $f = Featured::getInstance($id);

        if (Tools::isSubmit('form-featured-delete')) {
            if ($f->delete()) {
                Tools::redirect('/adm/featured?delete=1');
                unlink(Featured::getBasePath() . '/' . $f->getIdFeatured() . '.jpg');
            }
        }

        $twig->assign('featured', $f);
        return $twig->render('adm/featured/delete.twig');
    }

    /**
     * Validation du formulaire featured
     *
     * @param array<string,mixed> $data tableau des données
     *
     * @return array<string,string>
     */
    private static function validateForm(array $data): array
    {
        $errors = [];

        if (!(isset($data['title']) && (strlen($data['title']) > 0))) {
            $errors['title'] = "Vous devez saisir un titre";
        }
        if (!(isset($data['description']) && (strlen($data['description']) > 0))) {
            $errors['description'] = "Vous devez saisir une description";
        }
        if (!(isset($data['url']) && (strlen($data['url']) > 0))) {
            $errors['url'] = "Vous devez saisir un lien de destination";
        }
        if (!(isset($data['datdeb']) && (strlen($data['datdeb']) > 0))) {
            $errors['datdeb'] = "Vous devez choisir une date de début de programmation";
        }
        if (!(isset($data['datfin']) && (strlen($data['datfin']) > 0))) {
            $errors['datfin'] = "Vous devez saisir une date de fin de programmation";
        }

        return $errors;
    }
}
