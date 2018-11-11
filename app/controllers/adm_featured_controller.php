<?php

class Controller
{
    const IMG_WIDTH = 1000;
    const IMG_HEIGHT = 375;

    static function index() : string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("A l'Affiche");

        $smarty = new AdHocSmarty();

        $smarty->assign('featured_front', Featured::getFeaturedHomepage());
        $smarty->assign('featured_admin', Featured::getFeaturedAdmin());

        $smarty->enqueue_script('/js/swipe.min.js');
        $smarty->enqueue_script('/js/featured.js');

        return $smarty->fetch('adm/featured/index.tpl');
    }

    static function create() : string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("A l'Affiche", "/adm/featured/");
        $trail->addStep("Ajouter");

        $smarty = new AdHocSmarty();

        $smarty->enqueue_style('/css/jquery-ui.min.css');

        $smarty->enqueue_script('/js/jquery-ui.min.js');
        $smarty->enqueue_script('/js/jquery-ui-datepicker-fr.js');
        $smarty->enqueue_script('/js/adm/featured.js');

        // valeurs par défaut
        $data = [
            'title'       => '',
            'description' => '',
            'link'        => '',
            'datdeb'      => '',
            'datfin'      => '',
            'online'      => false,
        ];

        if (Tools::isSubmit('form-featured-create'))
        {
            $data = [
                'title'       => trim((string) Route::params('title')),
                'description' => trim((string) Route::params('description')),
                'link'        => trim((string) Route::params('link')),
                'image'       => '',
                'datdeb'      => trim((string) Route::params('datdeb') . ' 00:00:00'),
                'datfin'      => trim((string) Route::params('datfin') . ' 23:59:59'),
                'online'      => false,
            ];

            if (self::_validate_form($data, $errors)) {

                $f = Featured::init();
                $f->setTitle($data['title']);
                $f->setDescription($data['description']);
                $f->setLink($data['link']);
                $f->setDatDeb($data['datdeb']);
                $f->setDatFin($data['datfin']);
                $f->setOnline($data['online']);
                $f->save();

                if (is_uploaded_file($_FILES['image']['tmp_name'])) {
                    $i = new Image($_FILES['image']['tmp_name']);
                    $i->setType(IMAGETYPE_JPEG);
                    $i->setMaxWidth(self::IMG_WIDTH);
                    $i->setMaxHeight(self::IMG_HEIGHT);
                    $i->setDestFile(Featured::getBasePath() . '/' . (int) $f->getId() . '.jpg');
                    $i->write();
                }

                Tools::redirect('/adm/featured/?create=1');

            }

            if (!empty($errors)) {
                foreach ($errors as $k => $v) {
                    $smarty->assign('error_' . $k, $v);
                }
            }
        }

        $smarty->assign('data', $data);
        $smarty->assign('events', Event::getEvents([
            'online' => true,
            'datdeb' => date('Y-m-d H:i:s'),
            'sort'   => 'date',
            'sens'   => 'ASC',
            'limit'  => 500,
        ]));

        return $smarty->fetch('adm/featured/create.tpl');
    }

    static function edit() : string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("A l'Affiche", "/adm/featured/");
        $trail->addStep("Modifier");

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
            'link'        => $f->getLink(),
            'image'       => $f->getImage(),
            'datdeb'      => $f->getDatDeb(),
            'datfin'      => $f->getDatFin(),
            'online'      => $f->getOnline(),
        ];

        if (Tools::isSubmit('form-featured-edit'))
        {
            $data = [
                'id'          => $f->getId(),
                'title'       => trim((string) Route::params('title')),
                'description' => trim((string) Route::params('description')),
                'link'        => trim((string) Route::params('link')),
                'image'       => '',
                'datdeb'      => trim((string) Route::params('datdeb') . ' 00:00:00'),
                'datfin'      => trim((string) Route::params('datfin') . ' 23:59:59'),
                'online'      => (bool) Route::params('online'),
            ];

            if (self::_validate_form($data, $errors)) {

                $f->setTitle($data['title']);
                $f->setDescription($data['description']);
                $f->setLink($data['link']);
                $f->setDatDeb($data['datdeb']);
                $f->setDatFin($data['datfin']);
                $f->setOnline($data['online']);
                $f->save();

                if (is_uploaded_file($_FILES['image']['tmp_name'])) {
                    $i = new Image($_FILES['image']['tmp_name']);
                    $i->setType(IMAGETYPE_JPEG);
                    $i->setMaxWidth(self::IMG_WIDTH);
                    $i->setMaxHeight(self::IMG_HEIGHT);
                    $i->setDestFile(Featured::getBasePath() . '/' . $f->getId() . '.jpg');
                    $i->write();
                }

                Tools::redirect('/adm/featured/?edit=1');

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
     * validation du formulaire featured
     * @param array $data
     * @param array &$errors
     * @return bool
     */
    protected static function _validate_form($data, &$errors) : bool
    {
        $errors = [];
        if (empty($data['title'])) {
            $errors['title'] = "Vous devez saisir un titre";
        }
        if (empty($data['description'])) {
            $errors['description'] = "Vous devez saisir une description";
        }
        if (empty($data['link'])) {
            $errors['link'] = "Vous devez saisir un lien de destination";
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

    static function delete() : string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("A l'Affiche", "/adm/featured/");
        $trail->addStep("Supprimer");

        $smarty = new AdHocSmarty();

        $id = (int) Route::params('id');
        $f = Featured::getInstance($id);

        if (Tools::isSubmit('form-featured-delete'))
        {
            if ($f->delete()) {
                Tools::redirect('/adm/featured/?delete=1');
                unlink(ADHOC_ROOT_PATH . '/static/media/featured/' . $f->getId() . '.jpg');
            }
        }

        $smarty->assign('featured', $f);
        return $smarty->fetch('adm/featured/delete.tpl');
    }
}
