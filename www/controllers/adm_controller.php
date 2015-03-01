<?php

define('ADM_TAG_NB_TAGS_PER_PHOTO', 4);
define('ADM_TAG_NB_PHOTOS_PER_PAGE', 180);

define('ADM_NB_MEMBERS_PER_PAGE', 25);

define('ADM_NB_GROUPES_PER_PAGE', 1000);

define('ADM_NEWSLETTER_CURRENT_ID', 62);
define('ADM_NEWSLETTER_NB_EMAILS_PER_LOT', 400);
define('ADM_NEWSLETTER_GROUPE_CURRENT_ID', 37);

define('ADM_FEATURED_IMG_WIDTH', 427);
define('ADM_FEATURED_IMG_HEIGHT', 240);

class Controller
{
    public static function index()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        $smarty->assign('title', "AD'HOC : Administration du site");
        $smarty->assign('description', "Association oeuvrant pour le développement de la vie musicale en Essonne depuis 1996. Promotion d'artistes, Pédagogie musicale, Agenda concerts, Communauté de musiciens ...");

        $trail = Trail::getInstance();
        $trail->addStep("Privé");

        $smarty->assign('forums', ForumPrive::getForums());

        return $smarty->fetch('adm/index.tpl');
    }

    public static function billing()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Facturation OVH");

        $ovh = OvhApi::getInstance('sg81-ovh');
        $invoices1 = $ovh->billingInvoiceList();

        $ovh = OvhApi::getInstance('dg48001-ovh');
        $invoices2 = $ovh->billingInvoiceList();

        $invoices = array_merge($invoices1, $invoices2);

        $i = array();
        $d = array();
        $total = 0;
        foreach($invoices as $invoice) {
            $d[] = $invoice->date;
            $i[] = get_object_vars($invoice);
            $total += $invoice->totalPriceWithVat;
        }

        unset($invoices);
        array_multisort($d, SORT_ASC, $i);

        $smarty->assign('invoices', $i);
        $smarty->assign('total', $total);

        return $smarty->fetch('adm/billing.tpl');
    }

    public static function domains()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Nos domaines");

        $ovh = OvhApi::getInstance('sg81-ovh');
        $domains = $ovh->domainList();
        $d = array();
        foreach($domains as $domain) {
            $d[] = $ovh->domainInfo($domain);
        }

        $smarty->assign('domains', $d);

        return $smarty->fetch('adm/domains.tpl');
    }

    public static function exposants_index()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

    	$trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Exposants");

        $smarty->assign('exposants', Exposant::getExposants());

        return $smarty->fetch('adm/exposants/index.tpl');
    }

    public static function exposants_create()
    {
    	Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Exposants", "/adm/exposants/");
        $trail->addStep("Ajout");

        if(Tools::isSubmit('form-exposants-create'))
        {
            $data = array(
                'name'  => (string) Route::params('name'),
                'email' => (string) Route::params('email'),
                'phone' => (string) Route::params('phone'),
                'site'  => (string) Route::params('site'),
                'type'  => (string) Route::params('type'),
                'city'  => (string) Route::params('city'),
                'state' => (string) Route::params('state'),
             );
 
             $exposant = Exposant::init();
             $exposant->setName($data['name']);
             $exposant->setEmail($data['email']);
             $exposant->setPhone($data['phone']);
             $exposant->setSite($data['site']);
             $exposant->setType($data['type']);
             $exposant->setCity($data['city']);
             $exposant->setState($data['state']);
             $exposant->setCreatedNow();
             $exposant->save();
 
             Tools::redirect('/adm/exposants/');
        }

        return $smarty->fetch('adm/exposants/create.tpl');
    }

    public static function exposants_edit()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Exposants", "/adm/exposants/");
        $trail->addStep("Edition");

        $exposant = Exposant::getInstance($id);

        if(Tools::isSubmit('form-exposants-edit'))
        {
            $data = array(
                'name'  => (string) Route::params('name'),
                'email' => (string) Route::params('email'),
                'phone' => (string) Route::params('phone'),
                'site'  => (string) Route::params('site'),
                'type'  => (string) Route::params('type'),
                'city'  => (string) Route::params('city'),
                'state' => (string) Route::params('state'),
            );

            $exposant->setName($data['name']);
            $exposant->setEmail($data['email']);
            $exposant->setPhone($data['phone']);
            $exposant->setSite($data['site']);
            $exposant->setType($data['type']);
            $exposant->setCity($data['city']);
            $exposant->setState($data['state']);
            $exposant->setModifiedNow();
            $exposant->save();

            Tools::redirect('/adm/exposants/');
        }

        $smarty->assign('exposant', $exposant);

        return $smarty->fetch('adm/exposants/edit.tpl');
    }

    public static function exposants_delete()
    {
    	Tools::auth(Membre::TYPE_INTERNE);

        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Exposants", "/adm/exposants/");
        $trail->addStep("Suppression");

        $exposant = Exposant::getInstance($id);

        if(Tools::isSubmit('form-exposants-delete'))
        {
            $exposant->delete();
            Tools::redirect('/adm/exposants/?delete=1');
        }

        $smarty->assign('exposant', $exposant);

        return $smarty->fetch('adm/exposants/delete.tpl');
    }

    public static function news_index()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("News");

        $smarty->assign('newslist', News::getNewsList(array(
            'sort'   => 'created_on',
            'sens'   => 'DESC',
            'debut'  => 0,
            'limit'  => 100,
        )));

        return $smarty->fetch('adm/news/index.tpl');
    }

    public static function news_create()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("News", "/adm/news/");
        $trail->addStep("Ajouter");

        if(Tools::isSubmit('form-news-create'))
        {
             $data = array(
                'title'  => (string) Route::params('title'),
                'intro'  => (string) Route::params('intro'),
                'text'   => (string) Route::params('text'),
                'online' => (bool) Route::params('online'),
            );

            $news = News::init();
            $news->setTitle($data['title']);
            $news->setIntro($data['intro']);
            $news->setText($data['text']);
            $news->setOnline($data['online']);
            $news->setCreatedNow();
            $news->save();

            Tools::redirect('/adm/news/');
        }

        $smarty->assign('form', true);

        return $smarty->fetch('adm/news/create.tpl');
    }

    public static function news_edit()
    {
        $id_news = (int) Route::params('id');

        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("News", "/adm/news/");
        $trail->addStep("Editer");

        if(Tools::isSubmit('form-news-edit'))
        {
            $data = array(
                'id_news' => (int) Route::params('id_news'),
                'title'   => (string) Route::params('title'),
                'intro'   => (string) Route::params('intro'),
                'text'    => (string) Route::params('text'),
                'online'  => (bool) Route::params('online'),
            );

            $news = News::getInstance($data['id_news']);
            $news->setTitle($data['title']);
            $news->setIntro($data['intro']);
            $news->setText($data['text']);
            $news->setOnline($data['online']);
            $news->setModifiedNow();
            $news->save();

            Tools::redirect('/adm/news/');
        }

        $smarty->assign('news', News::getNews($id_news));
        $smarty->assign('form', true);

        return $smarty->fetch('adm/news/edit.tpl');
    }

    public static function news_delete()
    {
        $id_news = (int) Route::params('id');

        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("News", "/adm/news/");
        $trail->addStep("Effacer");

        if(Tools::isSubmit('form-news-delete'))
        {
            $id_news = (int) Route::params('id_news');
            $news = News::getInstance($id_news);
            $news->delete();

            Tools::redirect('/adm/news/');
        }

        $smarty->assign('news', News::getNews($id_news));

        return $smarty->fetch('adm/news/delete.tpl');
    }

    public static function newsletter_index()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'prive');

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Newsletter");

        $smarty->assign('newsletters', Newsletter::getNewsletters(array(
            'limit' => 100,
        )));
        $smarty->assign('nb_sub', Newsletter::getSubscribersCount());

        return $smarty->fetch('adm/newsletter/index.tpl');
    }

    public static function newsletter_create()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'prive');

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Newsletter", "/adm/newsletter/");
        $trail->addStep("Ajout");

        $data = array(
            'title' => Newsletter::getDefaultTitle(),
            'content' => Newsletter::getDefaultRawContent(),
        );

        $smarty->assign('data', $data);

        return $smarty->fetch('adm/newsletter/create.tpl');
    }

    public static function newsletter_create_submit()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $data = array(
            'title'   => trim((string) Route::params('title')),
            'content' => trim((string) Route::params('content')),
        );

        $newsletter = Newsletter::init();
        $newsletter->save();

        $newsletter->setTitle($data['title']);
        $newsletter->setContent($data['content']);
        $newsletter->save();
 
        Tools::redirect('/adm/newsletter/?create=1');
    }

    public static function newsletter_edit()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'prive');

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Newsletter", "/adm/newsletter/");
        $trail->addStep("Edition");

        $smarty->assign('newsletter', Newsletter::getInstance($id));

        return $smarty->fetch('adm/newsletter/edit.tpl');
    }

    public static function newsletter_edit_submit()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $data = array(
            'id'      => (int) Route::params('id'),
            'title'   => trim((string) Route::params('title')),
            'content' => trim((string) Route::params('content')),
        );

        $newsletter = Newsletter::getInstance($data['id']);
        $newsletter->setTitle($data['title']);
        $newsletter->setContent($data['content']);
        $newsletter->save();

        Tools::redirect('/adm/newsletter/edit/'.(int) Route::params('id').'?edit=1');
    }

    public static function groupes_index()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $sens = (string) Route::params('sens');
        $sort = (string) Route::params('sort');

        if($sens === 'DESC') {
            $sens = 'DESC';
            $sensinv = 'ASC';
        } else {
            $sens = 'ASC';
            $sensinv = 'DESC';
        }

        if(!$sort) {
            $sort = 'id_contact';
        }

        $page = (int) Route::params('page');

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Groupes");

        $smarty = new AdHocSmarty();

        $groupes = Groupe::getGroupes(array(
            'sort'  => $sort,
            'sens'  => $sens,
            'debut' => $page * ADM_NB_GROUPES_PER_PAGE,
            'limit' => ADM_NB_GROUPES_PER_PAGE,
        ));

        $nb_groupes = Groupe::getGroupesCount(null, true);

        $smarty->assign('sensinv', $sensinv);
        $smarty->assign('groupes', $groupes);

        // pagination
        $smarty->assign('page', $page);
        $smarty->assign('nb_items', $nb_groupes);
        $smarty->assign('nb_items_per_page', ADM_NB_GROUPES_PER_PAGE);

        return $smarty->fetch('adm/groupes/index.tpl');
    }

    public static function groupes_show()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id_groupe = (int) Route::params('id');

        $groupe = Groupe::getInstance($id_groupe);

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Groupes", "/adm/groupes/");
        $trail->addStep($groupe->getName());

        $smarty = new AdHocSmarty();
        $smarty->assign('groupe', $groupe);
        return $smarty->fetch('adm/groupes/show.tpl');
    }

    public static function membres_index()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        if(((string) Route::params('sens') === 'DESC')) {
            $sens = 'DESC';
            $sensinv = 'ASC';
        } else {
            $sens = 'ASC';
            $sensinv = 'DESC';
        }

        if((string) Route::params('sort')) {
            $sort = (string) Route::params('sort');
        } else {
            $sort = 'id_contact';
        }

        $page = (int) Route::params('page');

        $pseudo = trim((string) Route::params('pseudo'));
        $email = trim((string) Route::params('email'));
        $last_name = trim((string) Route::params('last_name'));
        $first_name = trim((string) Route::params('first_name'));

        $tab_id = array();
        //$with_groupe = (bool) Route::params('with_groupe');
        //$id_groupe = (int) Route::params('id_groupe');
        //$id_type_musicien = (int) Route::params('id_type_musicien');

        $membres = Membre::getMembres(array(
            /*'id'         => $tab_id,*/
            'pseudo'     => $pseudo,
            'email'      => $email,
            'last_name'  => $last_name,
            'first_name' => $first_name,
            'sort'  => $sort,
            'sens'  => $sens,
            'debut' => $page * ADM_NB_MEMBERS_PER_PAGE,
            'limit' => ADM_NB_MEMBERS_PER_PAGE,
        ));

        $nb_membres = Membre::getMembresCount(); // hors critères !

        $smarty = new AdHocSmarty();

        $smarty->assign('membres',  $membres);

        $smarty->assign('sens', $sens);
        $smarty->assign('sensinv', $sensinv);
        $smarty->assign('page', $page);

        // test ajax
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest')
        {
            return $smarty->fetch('adm/membres/index-res.tpl');
        }

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Membres", "/adm/membres/");

        $smarty->assign('types_membre', Membre::getTypesMembre());
        $smarty->assign('types_musicien', Membre::getTypesMusicien());

        $smarty->assign('search', array(
            'pseudo' => $pseudo,
            'last_name' => $last_name,
            'first_name' => $first_name,
            'email' => $email,
            'with_groupe' => false,
            'id_groupe' => 0,
            'id_type_musicien' => 0,
        ));

        // pagination
        $smarty->assign('nb_items', $nb_membres);
        $smarty->assign('nb_items_per_page', ADM_NB_MEMBERS_PER_PAGE);
        $smarty->assign('link_base_params', 'sort='.$sort.'&sens='.$sens);

        return $smarty->fetch('adm/membres/index.tpl');
    }

    public static function membres_show()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id = (int) Route::params('id');

        $membre = Membre::getInstance($id);

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Membres", "/adm/membres/");
        $trail->addStep($membre->getPseudo());

        $smarty = new AdHocSmarty();
        $smarty->assign('membre', $membre);
        return $smarty->fetch('adm/membres/show.tpl');
    }

    public static function membres_delete()
    {
        Tools::auth(Membre::TYPE_ADMIN);

        $id = (int) Route::params('id');

        $membre = Membre::getInstance($id);

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Membres", "/adm/membres/");
        $trail->addStep("Suppresion de " . $membre->getPseudo());

        // ***

        //$membre->delete();
        //$contact = Contact::getInstance($id);
        //$contact->delete();

        // ***

        $smarty = new AdHocSmarty();
        $smarty->assign('membre', $membre);
        return $smarty->fetch('adm/membres/delete.tpl');
    }

    public static function featured_index()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("A l'Affiche");

        $smarty = new AdHocSmarty();
        $smarty->assign('featured',  Featured::getFeaturedAdmin());
        return $smarty->fetch('adm/featured/index.tpl');
    }

    public static function featured_create()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("A l'Affiche", "/adm/featured/");
        $trail->addStep("Ajouter");

        $smarty = new AdHocSmarty();

        // valeurs par défaut
        $data = array(
            'title'       => '',
            'description' => '',
            'link'        => '',
            'datdeb'      => '',
            'datfin'      => '',
            'slot'        => 0,
            'online'      => false,
        );

        if(Tools::isSubmit('form-featured-create'))
        {
            $data = array(
                'title'       => trim((string) Route::params('title')),
                'description' => trim((string) Route::params('description')),
                'link'        => trim((string) Route::params('link')),
                'image'       => '',
                'datdeb'      => trim((string) Route::params('datdeb') . ' 00:00:00'),
                'datfin'      => trim((string) Route::params('datfin') . ' 23:59:59'),
                'slot'        => (int) Route::params('slot'),
                'online'      => false,
            );

            if(self::_validate_form_featured($data, $errors)) {

                $f = Featured::init();
                $f->setTitle($data['title']);
                $f->setDescription($data['description']);
                $f->setLink($data['link']);
                $f->setDatDeb($data['datdeb']);
                $f->setDatFin($data['datfin']);
                $f->setSlot($data['slot']);
                $f->setOnline($data['online']);
                $f->save();

                if(is_uploaded_file($_FILES['image']['tmp_name'])) {
                    $i = new Image($_FILES['image']['tmp_name']);
                    $i->setType(IMAGETYPE_JPEG);
                    $i->setMaxWidth(ADM_FEATURED_IMG_WIDTH);
                    $i->setMaxHeight(ADM_FEATURED_IMG_HEIGHT);
                    $i->setDestFile(ADHOC_ROOT_PATH . '/static/media/featured/' . (int) $f->getId() . '.jpg');
                    $i->write();
                }

                Tools::redirect('/adm/featured/?create=1');

            }

            if (!empty($errors)) {
                foreach($errors as $k => $v) {
                    $smarty->assign('error_' . $k, $v);
                }
            }
        }

        $smarty->assign('data', $data);
        $smarty->assign('slots', Featured::getSlots());
        $smarty->assign('events', Event::getEvents(array(
            'online' => true,
            'datdeb' => date('Y-m-d H:i:s'),
            'sort'   => 'date',
            'sens'   => 'ASC',
            'limit'  => 500,
        )));

        return $smarty->fetch('adm/featured/create.tpl');
    }

    public static function featured_edit()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("A l'Affiche", "/adm/featured/");
        $trail->addStep("Modifier");

        $smarty = new AdHocSmarty();

        $id = (int) Route::params('id');
        $f = Featured::getInstance($id);

        $data = array(
            'id'          => $f->getId(),
            'title'       => $f->getTitle(),
            'description' => $f->getDescription(),
            'link'        => $f->getLink(),
            'image'       => $f->getImage(),
            'datdeb'      => $f->getDatDeb(),
            'datfin'      => $f->getDatFin(),
            'slot'        => $f->getSlot(),
            'online'      => $f->getOnline(),
        );

        if(Tools::isSubmit('form-featured-edit'))
        {
            $data = array(
                'id'          => $f->getId(),
                'title'       => trim((string) Route::params('title')),
                'description' => trim((string) Route::params('description')),
                'link'        => trim((string) Route::params('link')),
                'image'       => '',
                'datdeb'      => trim((string) Route::params('datdeb') . ' 00:00:00'),
                'datfin'      => trim((string) Route::params('datfin') . ' 23:59:59'),
                'slot'        => (int) Route::params('slot'),
                'online'      => (bool) Route::params('online'),
            );

            if(self::_validate_form_featured($data, $errors)) {

                $f->setTitle($data['title']);
                $f->setDescription($data['description']);
                $f->setLink($data['link']);
                $f->setDatDeb($data['datdeb']);
                $f->setDatFin($data['datfin']);
                $f->setSlot($data['slot']);
                $f->setOnline($data['online']);
                $f->save();

                if(is_uploaded_file($_FILES['image']['tmp_name'])) {
                    $i = new Image($_FILES['image']['tmp_name']);
                    $i->setType(IMAGETYPE_JPEG);
                    $i->setMaxWidth(ADM_FEATURED_IMG_WIDTH);
                    $i->setMaxHeight(ADM_FEATURED_IMG_HEIGHT);
                    $i->setDestFile(ADHOC_ROOT_PATH . '/static/media/featured/' . $f->getId() . '.jpg');
                    $i->write();
                    Featured::invalidateImageInCache($f->getId(), 120, 120);
                }

                Tools::redirect('/adm/featured/?edit=1');

            }

            if (!empty($errors)) {
                foreach($errors as $k => $v) {
                    $smarty->assign('error_' . $k, $v);
                }
            }
        }

        $smarty->assign('data', $data);
        $smarty->assign('slots', Featured::getSlots());

        return $smarty->fetch('adm/featured/edit.tpl');
    }

    /**
     * validation du formulaire featured
     * @param array $data
     * @param array &$errors
     * @return bool
     */
    protected static function _validate_form_featured($data, &$errors)
    {
        $errors = array();
        if(empty($data['slot'])) {
            $errors['slot'] = "Vous devez choisir un slot.";
        } elseif(!is_numeric($data['slot']) || $data['slot'] == 0) {
            $errors['slot'] = "Vous devez choisir un slot.";
        }
        if(empty($data['title'])) {
            $errors['title'] = "Vous devez saisir un titre";
        }
        if(empty($data['description'])) {
            $errors['description'] = "Vous devez saisir une description";
        }
        if(empty($data['link'])) {
            $errors['link'] = "Vous devez saisir un lien de destination";
        }
        if(empty($data['datdeb'])) {
            $errors['datdeb'] = "Vous devez choisir une date de début de programmation";
        }
        if(empty($data['datfin'])) {
            $errors['datfin'] = "Vous devez saisir une date de fin de programmation";
        }
        if(count($errors)) {
            return false;
        }
        return true;
    }

    public static function featured_delete()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("A l'Affiche", "/adm/featured/");
        $trail->addStep("Supprimer");

        $smarty = new AdHocSmarty();

        $id = (int) Route::params('id');
        $f = Featured::getInstance($id);

        if(Tools::isSubmit('form-featured-delete'))
        {
            if($f->delete()) {
                Tools::redirect('/adm/featured/?delete=1');
                unlink(ADHOC_ROOT_PATH . '/static/media/featured/' . $f->getId() . '.jpg');
            }
        }

        $smarty->assign('featured', $f);
        return $smarty->fetch('adm/featured/delete.tpl');
    }

    public static function stats()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $m = false;
        if(isset($_GET['m'])) {
            $m = substr($_GET['m'], 0, 1);
        }

        $domaine = false;
        if(isset($_GET['domaine'])) {
            $domaine = $_GET['domaine'];
        }

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'prive');

        $smarty->assign('title', "AD'HOC : Administration du site");
        $smarty->assign('description', "Association oeuvrant pour le développement de la vie musicale en Essonne depuis 1996. Promotion d'artistes, Pédagogie musicale, Agenda concerts, Communauté de musiciens ...");

        $modules = array(
            '1' => "Inscriptions membres par mois",
            '2' => "Inscriptions groupes par mois",
            '3' => "Top contributeurs photos",
            '4' => "Top contributeurs audios",
            '5' => "Top contributeurs vidéos",
            '6' => "Top contributeurs messages forums",
            '7' => "Top contributeurs lieux",
            '8' => "Top contributeurs dates",
            '9' => "Dernières connexions",
            'A' => "Top lieux",
            'B' => "Nombre de lieux par département",
            'C' => "Nombre de lieux par région",
            'D' => "Top Visites Groupes",
            'E' => "Top Visites Articles",
            'F' => "Membres les plus taggés",
            'G' => "Membres les plus taggeurs",
            'H' => "Domaines Emails",
            'I' => "Nombre d'événements annoncés par mois",
            'J' => "Répartition des vidéos par hébergeur",
            'K' => "Nombre de photos par lieu",
        );

        $smarty->assign('modules', $modules);

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Statistiques", "/adm/stats");
        if($m) {
            $trail->addStep($modules[$m]);
        }

        switch($m)
        {
            case '1': $module = Stats::getNbInscriptionMembreByMonth(); break;
            case '2': $module = Stats::getNbInscriptionGroupeByMonth(); break;
            case '3': $module = Stats::getTopPhotosSenders(); break;
            case '4': $module = Stats::getTopAudiosSenders(); break;
            case '5': $module = Stats::getTopVideosSenders(); break;
            case '6': $module = Stats::getTopMessagesForumsSenders(); break;
            case '7': $module = Stats::getTopLieuxSenders(); break;
            case '8': $module = Stats::getTopEventsSenders(); break;
            case '9': $module = Stats::getLastConnexions(50); break;
            case 'A': $module = Stats::getTopLieux(); break;
            case 'B': $module = Stats::getNbLieuxByDepartement(); break;
            case 'C': $module = Stats::getNbLieuxByRegion(); break;
            case 'D': $module = Stats::getTopVisitesGroupes(); break;
            case 'E': $module = Stats::getTopVisitesArticles(); break;
            case 'F': $module = Stats::getTopTagges(200); break;
            case 'G': $module = Stats::getTopTaggeurs(200); break;
            case 'H': $module = Stats::getEmailsForDomaine($domaine); break;
            case 'H': $module = Stats::getEmailsDomaines(); break;
            case 'I': $module = Stats::getNbEventsByMonth(); break;
            case 'J': $module = Stats::getRepartitionVideos(); break;
            case 'K': $module = Stats::getTopPhotosLieux(); break;
            default:  $module = false; break;
        }

        $smarty->assign('m', $m);
        $smarty->assign('module', $module);

        return $smarty->fetch('adm/stats.tpl');
    }

    public static function stats_top_groupes()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Statistiques", "/adm/stats");
        $trail->addStep("Top Groupes");

        $db = DataBase::getInstance();

        $smarty->assign('menuselected', 'prive');

        $smarty->assign('title', "AD'HOC : Administration du site");
        $smarty->assign('description', "Association oeuvrant pour le développement de la vie musicale en Essonne depuis 1996. Promotion d'artistes, Pédagogie musicale, Agenda concerts, Communauté de musiciens ...");

        // liste des groupes ayant le plus joué à Epinay
        $sql = "SELECT `g`.`id_groupe`, `g`.`name` AS `nom_groupe`, "
             . "`e`.`id_event`, `e`.`name` AS `nom_event`, `e`.`date` "
             . "FROM `adhoc_event` `e`, `adhoc_participe_a` `p`, `adhoc_groupe` `g`, `adhoc_organise_par` `o` "
             . "WHERE `e`.`id_event` = `o`.`id_event` "
             . "AND `p`.`id_event` = `e`.`id_event` "
             . "AND `p`.`id_groupe` = `g`.`id_groupe` "
             . "AND `o`.`id_structure` = 1 "
             . "AND `e`.`id_lieu` IN(1, 383, 404, 507) "
             . "ORDER BY `e`.`date` DESC";

        $rows = $db->queryWithFetch($sql);

        $tab = array();
        foreach($rows as $row)
        {
            $tab[$row['id_groupe']]['id_groupe'] = $row['id_groupe'];
            $tab[$row['id_groupe']]['nom_groupe'] = $row['nom_groupe'];
            $tab[$row['id_groupe']]['events'][] = array(
                'id'   => $row['id_event'],
                'name' => $row['nom_event'],
                'date' => $row['date'],
            );
        }

        $ordre = array();
        foreach($tab as $id_groupe => $inf)
        {
            $ordre[$id_groupe] = count($inf['events']);
        }

        arsort($ordre);

        $data = array();
        $rank = 1;
        foreach($ordre as $id_groupe => $nb)
        {
            $data[$rank] = $tab[$id_groupe];
            $data[$rank]['nb'] = $nb;
            $rank++;
        }

        $smarty->assign('tops', $data);

        return $smarty->fetch('adm/stats-top-groupes.tpl');
    }

    public static function stats_top_membres()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Statistiques", "/adm/stats");
        $trail->addStep("Top Membres");

        $db = DataBase::getInstance();

        $smarty->assign('menuselected', 'prive');

        $smarty->assign('title', "AD'HOC : Administration du site");
        $smarty->assign('description', "Association oeuvrant pour le développement de la vie musicale en Essonne depuis 1996. Promotion d'artistes, Pédagogie musicale, Agenda concerts, Communauté de musiciens ...");

        // listes des membres ayant le plus joué à Epinay
        $sql = "SELECT `m`.`id_contact`, `m`.`last_name`, `m`.`first_name`, "
             . "`g`.`id_groupe`, `g`.`name` AS `nom_groupe`, "
             . "`e`.`id_event`, `e`.`date`, `e`.`name` AS `nom_event` "
             . "FROM `adhoc_membre` `m`, `adhoc_appartient_a` `a`, `adhoc_event` `e`, `adhoc_participe_a` `p`, `adhoc_groupe` `g`, `adhoc_organise_par` `o` "
             . "WHERE `e`.`id_event` = `o`.`id_event` "
             . "AND `p`.`id_event` = `e`.`id_event` "
             . "AND `m`.`id_contact` = `a`.`id_contact` "
             . "AND `a`.`id_groupe` = `g`.`id_groupe` "
             . "AND `p`.`id_groupe` = `g`.`id_groupe` "
             . "AND `o`.`id_structure` = 1 "
             . "AND `e`.`id_lieu` IN(1, 383, 404, 507) "
             . "ORDER BY `e`.`date` DESC ";

        $rows = $db->queryWithFetch($sql);

        $tab = array();
        foreach($rows as $row)
        {
            $tab[$row['id_contact']]['id_contact'] = $row['id_contact'];
            $tab[$row['id_contact']]['first_name'] = $row['first_name'];
            $tab[$row['id_contact']]['last_name'] = $row['last_name'];
            $tab[$row['id_contact']]['events'][] = array(
                'id_groupe'  => $row['id_groupe'],
                'nom_groupe' => $row['nom_groupe'],
                'id_event'   => $row['id_event'],
                'nom_event'  => $row['nom_event'],
                'date_event' => $row['date'],
            );
        }

        $ordre = array();
        foreach($tab as $contact => $inf)
        {
            $ordre[$contact] = count($inf['events']);
        }

        arsort($ordre);

        $data = array();
        $rank = 1;

        foreach($ordre as $id_contact => $nb)
        {
            $data[$rank] = $tab[$id_contact];
            $data[$rank]['nb'] = $nb;
            $rank++;
        }

        $smarty->assign('tops', $data);

        return $smarty->fetch('adm/stats-top-membres.tpl');
    }

    public static function stats_nl()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'prive');

        $full = false;
        if(isset($_GET['full'])) {
            $full = true;
        }
        $smarty->assign('full', $full);

        $lastsend = '2014-09-24 12:00:00';

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Statistiques", "/adm/stats");
        $trail->addStep("Newsletter");

        $db = DataBase::getInstance();

        // nombre d'abonnés actifs instantanés
        $smarty->assign('nb_subscribers', Newsletter::getSubscribersCount());

        // nombre d'ouvertures
        $sql = "SELECT `id_contact` "
             . "FROM `adhoc_statsnl` "
             . "WHERE `date` > '" . $db->escape($lastsend) . "' ";
        $res = $db->query($sql);
        $smarty->assign('nbo', $db->numRows($res));

        // nombre d'ouvertures uniques
        $sql = "SELECT DISTINCT `id_contact` "
             . "FROM `adhoc_statsnl` "
             . "WHERE `date` > '" . $db->escape($lastsend) . "' ";
        $res = $db->query($sql);
        $smarty->assign('nbou', $db->numRows($res));

        // on extrait tout
        $sql = "SELECT `adhoc_statsnl`.`id_newsletter`, `adhoc_statsnl`.`id_contact`, `adhoc_membre`.`pseudo`, `adhoc_contact`.`email`, `adhoc_statsnl`.`date`, "
             . "`adhoc_statsnl`.`host`, `adhoc_statsnl`.`ip`, `adhoc_statsnl`.`useragent` "
             . "FROM (`adhoc_statsnl`) "
             . "LEFT JOIN `adhoc_membre` ON (`adhoc_statsnl`.`id_contact` = `adhoc_membre`.`id_contact`) "
             . "LEFT JOIN `adhoc_contact` ON (`adhoc_statsnl`.`id_contact` = `adhoc_contact`.`id_contact`) "
             . "WHERE `adhoc_statsnl`.`date` > '" . $db->escape($lastsend) . "' "
             . "ORDER BY `adhoc_statsnl`.`date` DESC";
        $res = $db->queryWithFetch($sql);

        $smarty->assign('nls', $res);

        // les hits
        $sql = "SELECT `adhoc_newsletter_hit`.`id_newsletter`, `adhoc_newsletter_hit`.`id_contact`, `adhoc_membre`.`pseudo`, `adhoc_contact`.`email`, `adhoc_newsletter_hit`.`date`, "
             . "`adhoc_newsletter_hit`.`host`, `adhoc_newsletter_hit`.`ip`, `adhoc_newsletter_hit`.`useragent`, `adhoc_newsletter_hit`.`url` "
             . "FROM (`adhoc_newsletter_hit`) "
             . "LEFT JOIN `adhoc_membre` ON (`adhoc_newsletter_hit`.`id_contact` = `adhoc_membre`.`id_contact`) "
             . "LEFT JOIN `adhoc_contact` ON (`adhoc_newsletter_hit`.`id_contact` = `adhoc_contact`.`id_contact`) "
             . "WHERE `adhoc_newsletter_hit`.`date` > '" . $db->escape($lastsend) . "' "
             . "ORDER BY `adhoc_newsletter_hit`.`date` DESC";
        $res = $db->queryWithFetch($sql);

        $smarty->assign('hits', $res);

        return $smarty->fetch('adm/stats-nl.tpl');
    }

    public static function groupe_de_style()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'prive');

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Groupe de Style");

        $db = DataBase::getInstance();

        $sql = "SELECT `id_groupe` AS `id`, `name`, `style`, `text`, `mini_text`, `influences` "
             . "FROM `adhoc_groupe` "
             . "ORDER BY `name` ASC";
        $res = $db->queryWithFetch($sql);

        $tab_groupes = array();
        foreach($res as $_res) {
            $tab_groupes[$_res['id']] = $_res;
        }

        foreach($tab_groupes as $id_grp => $grp)
        {
            $sql = "SELECT `id_style`, `ordre` "
                 . "FROM `adhoc_groupe_style` "
                 . "WHERE `id_groupe` = " . (int) $grp['id'] . " "
                 . "ORDER BY `ordre` ASC";
            $res = $db->query($sql);

            $cpt = 0;
            while(list($grp_style_id, $grp_style_ordre) = $db->fetchRow($res)) {
                $tab_groupes[$id_grp]['styles'][$grp_style_ordre] = Style::getName($grp_style_id);
                $cpt++;
            }
            if($cpt > 0) {
                $tab_groupes[$id_grp]['bgcolor'] = '#009900'; // au moins 1 style : bien
            } else {
                $tab_groupes[$id_grp]['bgcolor'] = '#990000'; // aucun style : mal
            }
        }

        $smarty->assign('groupes', $tab_groupes);

        return $smarty->fetch('adm/groupe-de-style.tpl');
    }

    public static function groupe_de_style_id()
    {
        if(Tools::isSubmit('form-groupe-de-style')) {
            return self::groupe_de_style_submit();
        }

        Tools::auth(Membre::TYPE_INTERNE);

        $id = (int) Route::params('id');

        $db = DataBase::getInstance();
        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'prive');

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Groupe de Style", "/adm/groupe-de-style");

        $groupe = Groupe::getInstance($id);

        $trail->addStep($groupe->getName());

        // styles du groupe sélectionné
        $sql = "SELECT `id_style` "
             . "FROM `adhoc_groupe_style` "
             . "WHERE `id_groupe` = " . $groupe->getId() . " "
             . "ORDER BY `ordre` ASC "
             . "LIMIT 0, 3";
        $res = $db->query($sql);
        $sty = array(0, 0, 0);
        $cpt = 0;
        while(list($id_style) = $db->fetchRow($res)) {
            $sty[$cpt] = $id_style;
            $cpt++;
        }

        // todo: dans le tpl !!
        $form_style = array();
        for($cpt_style = 0 ; $cpt_style < 3 ; $cpt_style ++) {
            $form_style[$cpt_style]  = '';
            $form_style[$cpt_style] .= "<select name=\"style[" . $cpt_style . "]\">";
            $form_style[$cpt_style] .= "<option value=\"0\">---</option>\n";
            foreach(Style::getHashTable() as $id_style => $nom_style) {
                $form_style[$cpt_style] .= "<option value=\"" . $id_style . "\"";
                if($id_style == $sty[$cpt_style]) {
                    $form_style[$cpt_style] .= " selected=\"selected\"";
                }
                $form_style[$cpt_style] .= ">" . $nom_style . "</option>\n";
            }
            $form_style[$cpt_style] .= "</select>";
        }

        $smarty->assign('groupe', $groupe);
        $smarty->assign('form_style', $form_style);

        return $smarty->fetch('adm/groupe-de-style-id.tpl');
    }

    public static function groupe_de_style_submit()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $db = DataBase::getInstance();

        $style = Route::params('style');
        $id_groupe = (int) Route::params('id_groupe');

        // todo: dans un objet !!
        $sql = "DELETE FROM `adhoc_groupe_style` "
             . "WHERE `id_groupe` = " . (int) $id_groupe;
        $res = $db->query($sql);

        foreach($style as $ordre => $id_style) {
            $ordre += 1;
            if($id_style > 0) {
                $sql = "INSERT INTO `adhoc_groupe_style` "
                     . "(`id_groupe`, `id_style`, `ordre`) "
                     . "VALUES (" . $id_groupe . ", " . $id_style . ", " . $ordre . ")";
                try{
                    $res = $db->query($sql);
                }
                catch(Exception $e) {
                    die($e->getMessage());
                }
            }
        }

        Tools::redirect('/adm/groupe-de-style');
    }

    public static function log_action()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $action = (int) Route::params('action');

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Log Action");

        $smarty = new AdHocSmarty();
        $smarty->assign('actions', Log::getActions());
        $smarty->assign('logs', Log::getLogsAction($action));
        return $smarty->fetch('adm/log-action.tpl');
    }

    public static function est_marque_sur()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Taggage des photos");

        $page = (int) Route::params('page');
        $tag = (string) Route::params('tag');

        $photos = Photo::getPhotos(array(
            'limit' => ADM_TAG_NB_PHOTOS_PER_PAGE,
            'debut' => $page * ADM_TAG_NB_PHOTOS_PER_PAGE,
            'sort'  => 'id',
            'sens'  => 'DESC',
        ));

        $nb_photos = count($photos);

        if($nb_photos) {
            foreach($photos as $key => $photo) {
                if(is_array($photo['tag']) && count($photo['tag'])) {
                    $photos[$key]['bgcolor'] = '#00ff00';
                    $photos[$key]['nb_tags'] = count($photo['tag']);
                    if($photos[$key]['nb_tags'] > 1) {
                        $photos[$key]['nb_tags_lib'] = $photos[$key]['nb_tags'] . ' tags';
                    } else {
                        $photos[$key]['nb_tags_lib'] = '1 tag';
                    }
                } else {
                    $photos[$key]['bgcolor'] = '#ff0000';
                    $photos[$key]['nb_tags'] = 0;
                    $photos[$key]['nb_tags_lib'] = '0 tag';
                }
            }
        }

        $smarty = new AdHocSmarty();
        $smarty->assign('photos', $photos);
        $smarty->assign('nb_photos', $nb_photos);
        $smarty->assign('page', $page);
        $smarty->assign('show_list', true);

        if($tag == 'ok') {
            $smarty->assign('tag_ok', true);
        }

        return $smarty->fetch('adm/est-marque-sur.tpl');
    }

    public static function est_marque_sur_id()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id = (int) Route::params('id');
        $page = (int) Route::params('page');

        $photo = Photo::getInstance($id);

        // listing membre
        $db = DataBase::getInstance();
        $sql = "SELECT `id_contact`, `last_name`, `first_name`, `pseudo` "
             . "FROM `adhoc_membre` "
             . "ORDER BY `last_name` ASC, `first_name` ASC, `pseudo` ASC";
        $membres = $db->queryWithFetch($sql);

        $smarty = new AdHocSmarty();
        $smarty->assign('page', $page);
        $smarty->assign('photo', $photo);
        $smarty->assign('show_photo', true);
        $smarty->assign('membres', $membres);
        $smarty->assign('nb_tags_per_photo', ADM_TAG_NB_TAGS_PER_PHOTO);
        $smarty->assign('tags', $photo->getTag());
        return $smarty->fetch('adm/est-marque-sur.tpl');
    }

    public static function est_marque_sur_submit()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $page = (int) Route::params('page');
        $id_photo = (int) Route::params('id_photo');

        // purge tags
        $db = DataBase::getInstance();
        $sql = "DELETE FROM `adhoc_est_marque_sur` "
             . "WHERE `id_type_media` = " . (int) ObjectModel::TYPE_MEDIA_PHOTO . " "
             . "AND `id_media` = " . (int) $id_photo;
        $db->query($sql);

        // insert tags
        for($cpt = 0 ; $cpt < ADM_TAG_NB_TAGS_PER_PHOTO ; $cpt++) {
            $var = 'id_contact_' . $cpt;
            if($_POST[$var] != 0) {
                $sql = "INSERT IGNORE INTO `adhoc_est_marque_sur` "
                     . "(`id_media`, `id_type_media`, `id_contact`, `tagge_par`, `date`) "
                     . "VALUES(" . (int) $id_photo . ", " . (int) ObjectModel::TYPE_MEDIA_PHOTO . ", " . (int) $_POST[$var] . ", " . (int) $_SESSION['membre']->getId() . ", NOW())";
                $db->query($sql);
            }
        }

        Tools::redirect('/adm/est-marque-sur?page=' . $page . '&tag=ok');
    }

    public static function delete_account()
    {
        Tools::auth(Membre::TYPE_ADMIN);

        $db = DataBase::getInstance();

        $out = '';

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'prive');

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Suppression Compte");

        !empty($_GET['action']) ? $action = (string) $_GET['action'] : $action = 'show';
        $smarty->assign('action', $action);

        !empty($_GET['email']) ? $email = (string) trim($_GET['email']) : $email = '';
        $smarty->assign('email', $email);

        !empty($_GET['id']) ? $id = (int) $_GET['id'] : $id = '';
        $smarty->assign('id', $id);

        switch($action)
        {
            case 'show':
            default:

                $out .= "<table>";

                if($email != "") {
                    $sql = "SELECT `id_contact`, `email` FROM `adhoc_contact` WHERE `email` = '" . $db->escape($email) . "'";
                    $res = $db->query($sql);
                    if(list($id) = $db->fetchRow($res)) {
                        $out .= "<tr><td>Email <strong>" . $email . "</strong> trouvé - id_contact : <strong>" . $id . "</strong></td></tr>";
                    } else {
                        $out .= "<tr><td>Email <strong>" . $email . "</strong> non trouvé</td></tr>";
                    }
                }

                if($id > 0) {

                    $sql = "SELECT `email` FROM `adhoc_contact` WHERE `id_contact` = " . $id;
                    $res = $db->query($sql);
                    if(list($email) = $db->fetchRow($res)) {
                        $out .= "<tr><td>table contact : <strong>oui</strong> - email = <strong>" . $email . "</strong> - <a href='/adm/delete-account?action=delete&id=" . $id . "'>EFFACER TOUT LE COMPTE</a></td></tr>";
                    } else {
                        $out .= "<tr><td>table contact : <strong>non</strong></td></tr>";
                    }

                    $sql = "SELECT `pseudo`, `last_name`, `first_name`, `created_on`, `modified_on`, `visited_on` FROM `adhoc_membre` WHERE `id_contact` = " . $id;
                    $res = $db->query($sql);
                    if(list($pseudo, $nom, $prenom, $crea, $modif, $visite) = $db->fetchRow($res)) {
                        $out .= "<tr><td>table membre : <strong>oui</strong> - pseudo = <strong>" . $pseudo . "</strong> - nom = <strong>" . $nom . "</strong> - prenom = <strong>" . $prenom . "</strong><br />";
                        $out .= "crea : " . $crea . " - modif : " . $modif . " - visite : " . $visite . "</td></tr>";
                    } else {
                        $out .= "<tr><td>table membre : <strong>non</strong></td></tr>";
                    }

                    $sql  = "SELECT `id_contact` FROM `adhoc_appartient_a` WHERE `id_contact` = " . $id;
                    $res  = $db->query($sql);
                    $nb   = $db->numRows($res);
                    $out .= "<tr><td>table appartient_a <strong>" . $nb . " groupe(s)</strong></td></tr>";

                    $sql  = "SELECT `id_contact` FROM `adhoc_video` WHERE `id_contact` = " . $id;
                    $res  = $db->query($sql);
                    $nb   = $db->numRows($res);
                    $out .= "<tr><td>table video : <strong>" . $nb . " video(s)</strong></td></tr>";

                    $sql  = "SELECT `id_contact` FROM `adhoc_audio` WHERE `id_contact` = " . $id;
                    $res  = $db->query($sql);
                    $nb   = $db->numRows($res);
                    $out .= "<tr><td>table audio : <strong>" . $nb . " audio(s)</strong></td></tr>";

                    $sql  = "SELECT `id_contact` FROM `adhoc_photo` WHERE `id_contact` = " . $id;
                    $res  = $db->query($sql);
                    $nb   = $db->numRows($res);
                    $out .= "<tr><td>table photo : <strong>" . $nb . " photo(s)</strong></td></tr>";
/*
                    $sql  = "SELECT `id_contact` FROM `adhoc_forums` WHERE `id_contact` = " . $id;
                    $res  = $db->query($sql);
                    $nb   = $db->numRows($res);
                    $out .= "<tr><td>table forums : <strong>" . $nb . " message(s)</strong></td></tr>";

                    $sql  = "SELECT `id_contact` FROM `adhoc_suivi_thread` WHERE `id_contact` = " . $id;
                    $res  = $db->query($sql);
                    $nb   = $db->numRows($res);
                    $out .= "<tr><td>table suivi_thread : <strong>" . $nb . " suivi(s)</strong></td></tr>";
*/
                }

                $out .= "</table>";

                break;

            case 'delete':

                $out .= "<form method=\"post\" action=\"/adm/delete-account-submit\">"
                      . "<p>Confirmer suppression de id_contact = " . $id . "</p>"
                      . "<input type=\"submit\" class=\"button\" value=\"OUI\" />"
                      . "<input type=\"hidden\" name=\"confirm\" value=\"1\" />"
                      . "<input type=\"hidden\" name=\"id\" value=\"" . $_GET['id'] . "\" />"
                      . "</form>";

                break;
        }

        $smarty->assign('content', $out);

        return $smarty->fetch('adm/delete-account.tpl');
    }

    public static function delete_account_submit()
    {
        Tools::auth(Membre::TYPE_ADMIN);

        $id = (int) Route::params('id');

        $db = DataBase::getInstance();

        $out = '';

        if(!$id) {
            return 'id invalide';
        }

        // on delete pas l'email dans le cas où c'est juste l'inactivité
        // du compte mais l'email répond bien
        $sql  = "DELETE FROM `adhoc_contact` WHERE `id_contact` = " . $id;
        $out .= $sql . "<br />";
        $db->query($sql);
        $out .= "*** table contact effacée pour id_contact : ". $id . "<br />";

        $sql  = "DELETE FROM `adhoc_membre` WHERE `id_contact` = " . $id;
        $out .= $sql . "<br />";
        $db->query($sql);
        $out .= "*** table membre effacée pour id_contact : " . $id . "<br />";

        /*
        $sql  = "DELETE FROM `adhoc_suivi_thread` WHERE `id_contact` = " . $id;
        $out .= $sql . "<br />";
        $db->query($sql);
        $out .= "*** table suivi_thread effacée pour id_contact : " . $id . "<br />";
        */

        $out .= "<a href=\"/adm/delete-account\" class=\"button\">retour</a>";

        $smarty = new AdHocSmarty();

        $smarty->assign('content', $out);

        return $smarty->fetch('adm/delete-account.tpl');
    }

    public static function forums_index()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'prive');

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Forums", "/adm/forums/");

        $smarty->assign('forums', ForumPrive::getForums());

        return $smarty->fetch('adm/forums/index.tpl');
    }

    public static function forums_forum()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id_forum = Route::params('id_forum');
        $page = (int) Route::params('page');

        $forum = ForumPrive::getForum($id_forum);

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'prive');

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Forums", "/adm/forums/");
        $trail->addStep($forum['title']);

        $smarty->assign('subs', ForumPrive::getSubscribers($id_forum));
        $smarty->assign('forum', $forum);
        $smarty->assign('threads', ForumPrive::getThreads($id_forum, $page));

        $smarty->assign('nb_items', ForumPrive::getThreadsCount($id_forum));
        $smarty->assign('nb_items_per_page', FORUM_NB_THREADS_PER_PAGE);
        $smarty->assign('page', $page);

        return $smarty->fetch('adm/forums/forum.tpl');
    }

    public static function forums_thread()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id_thread = (int) Route::params('id_thread');
        $page = (int) Route::params('page');

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'prive');

        $data = ForumPrive::getMessages($id_thread, $page);
        $forum = ForumPrive::getForum($data['thread']['id_forum']);

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Forums", "/adm/forums/");
        $trail->addStep($forum['title'], "/adm/forums/forum/" . $forum['id_forum']);
        $trail->addStep($data['thread']['subject']);

        $smarty->assign('id_forum', $forum['id_forum']);
        $smarty->assign('id_thread', $id_thread);

        $smarty->assign('subs', ForumPrive::getSubscribers($forum['id_forum']));
        $smarty->assign('thread', $data['thread']);
        $smarty->assign('messages', $data['messages']);

        $smarty->assign('nb_items', $data['thread']['nb_messages']);
        $smarty->assign('nb_items_per_page', FORUM_NB_MESSAGES_PER_PAGE);
        $smarty->assign('page', $page);

        ForumPrive::addView($id_thread);

        // box écrire
        $smarty->assign('text', '');
        $smarty->assign('check', Tools::getCSRFToken());

        return $smarty->fetch('adm/forums/thread.tpl');
    }

    public static function forums_write()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id_forum  = Route::params('id_forum');
        $id_thread = (int) Route::params('id_thread');

        if(Tools::isSubmit('form-forum-write'))
        {
            // a debuger
            /*
            if(Tools::checkCSRFToken((string) Route::params('check')) === false) {
                //die('csrf fail'); // mauvais code sécurité
            }
            */

            $subject   = (string) Route::params('subject');
            $text      = (string) Route::params('text');

            $msg = ForumPrive::addMessage(array(
                'id_contact' => $_SESSION['membre']->getId(),
                'id_forum'   => $id_forum,
                'id_thread'  => $id_thread,
                'subject'    => $subject,
                'text'       => $text,
            ));

            /* début alerte mail aux abonnés */

            $subs = ForumPrive::getSubscribers($msg['id_forum']);
            $forum = ForumPrive::getForum($msg['id_forum']);
            if(!$subject) {
                $msgs = ForumPrive::getMessages($msg['id_thread']);
                $subject = $msgs['thread']['subject'];
            }

            if(sizeof($subs)) {
                require_once COMMON_LIB_PHPMAILER_PATH . '/class.phpmailer.php';
                foreach($subs as $sub) {

                    $data = array(
                        'title' => 'Nouveau message',
                        'pseudo_to' => $sub['pseudo'],
                        'pseudo_from' => $_SESSION['membre']->getPseudo(),
                        'avatar' => $_SESSION['membre']->getAvatarInterne(),
                        'forum_name' => $forum['title'],
                        'id_thread' => $msg['id_thread'],
                        'subject' => $subject,
                        'text' => $text,
                    );

                    Email::send(
                        $sub['email'],
                        "[AD'HOC] " . $_SESSION['membre']->getPseudo() . " a écrit un message dans le forum " . $forum['title'],
                        "forum-prive-new-message",
                        $data
                    );

                }
            }

            /* fin alerte mail aux abonnés */

            Tools::redirect('/adm/forums/forum/' . $msg['id_forum']);
        }

        $smarty = new AdHocSmarty();

        if(is_null($id_forum) && empty($id_thread)) {
            $smarty->assign('error_params', true);
        } elseif(!empty($id_thread)) {
            $id_forum = ForumPrive::getIdForumByIdThread($id_thread);
        } elseif(!is_null($id_forum)) {
            // rien
        }

        $forum = ForumPrive::getForum($id_forum);

        $smarty->assign('menuselected', 'prive');

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Forums", "/adm/forums/");
        $trail->addStep($forum['title'], "/adm/forums/forum/" . $forum['id_forum']);
        $trail->addStep("Ecrire un message");

        // box écrire
        $smarty->assign('subject', '');
        $smarty->assign('text', '');
        $smarty->assign('check', Tools::getCSRFToken());
        $smarty->assign('id_forum', $id_forum);
        $smarty->assign('id_thread', $id_thread);

        return $smarty->fetch('adm/forums/write.tpl');
    }

    public static function sql()
    {
        Tools::auth(Membre::TYPE_ADMIN);

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'prive');

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Requête SQL");

        $q = (string) Route::params('q');
        $smarty->assign('q', $q);

        if(Tools::isSubmit('form-sql'))
        {
            if((stripos($q, 'SELECT') === false)
            && (stripos($q, 'DESCRIBE') === false)
            && (stripos($q, 'SHOW') === false)) {
                return "SELECT, DESCRIBE, SHOW queries only";
            }

            $db = DataBase::getInstance();

            $res = $db->query($q);

            $nb_fields = mysql_num_fields($res);
            $fields = array();
            for ($i = 0; $i < $nb_fields; $i++) {
                $fields[] = mysql_field_name($res, $i);
            }

            $table = array();
            while($row = $db->fetchRow($res)) {
                $table[] = $row;
            }

            $smarty->assign('fields', $fields);
            $smarty->assign('table', $table);
        }

        return $smarty->fetch('adm/sql.tpl');
    }

    public static function appartient_a()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $action = (string) Route::params('action');
        $from = (string) Route::params('from');
        $id_groupe = (int) Route::params('groupe');
        $id_contact = (int) Route::params('membre');
        $id_type_musicien = (int) Route::params('type');
        $datdeb = (string) Route::params('datdeb');
        $datfin = (string) Route::params('datfin');

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'prive');

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Liaison Membre / Groupe");

        if(Tools::isSubmit('form-appartient-a'))
        {
            $groupe = Groupe::getInstance($id_groupe);
            switch($action)
            {
                case 'create':
                    $groupe->linkMember($id_contact, $id_type_musicien, $datdeb, $datfin);
                    break;
                case 'delete':
                    $groupe->unlinkMember($id_contact);
                    break;
                case 'edit':
                    $groupe->unlinkMember($id_contact);
                    $groupe->linkMember($id_contact, $id_type_musicien, $datdeb, $datfin);
                    break;
            }

            switch($from)
            {
                case "groupe":
                    Tools::redirect('/adm/groupes/show/' . $id_groupe);
                    break;
                case "membre":
                    Tools::redirect('/adm/membres/show/' . $id_contact);
                    break;
            }

            return 'KO';
        }

        $smarty->assign('action', $action);
        $smarty->assign('from', $from);
        $smarty->assign('id_groupe', $id_groupe);
        $smarty->assign('id_contact', $id_contact);
        $smarty->assign('types', Membre::getTypesMusicien());

        switch($action)
        {
            case "create":
                $smarty->assign('action_lib', 'Ajouter');
                break;
            case "edit":
                $smarty->assign('action_lib', 'Editer');
                break;
            case "delete":
                $smarty->assign('action_lib', 'Supprimer');
                break;
            default:
                die();
                break;
        }

        return $smarty->fetch('adm/appartient-a.tpl');
    }

    public static function faq_index()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'prive');

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Foire aux questions");

        $smarty->assign('create', (bool) Route::params('create'));
        $smarty->assign('edit', (bool) Route::params('edit'));
        $smarty->assign('delete', (bool) Route::params('delete'));
        $smarty->assign('faq', FAQ::getFAQs());

        return $smarty->fetch('adm/faq/index.tpl');
    }

    public static function faq_create()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'prive');

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Foire aux questions", "/adm/faq/");
        $trail->addStep("Création");

        if(Tools::isSubmit('form-faq-create'))
        {
            $data = array(
                'id_category' => (int) Route::params('id_category'),
                'question'    => (string) Route::params('question'),
                'answer'      => (string) Route::params('answer'),
            );

            $faq = FAQ::init();
            $faq->setIdCategory($data['id_category']);
            $faq->setQuestion($data['question']);
            $faq->setAnswer($data['answer']);
            $faq->save();

            Tools::redirect('/adm/faq/?create=1');
        }

        $smarty->assign('categories', FAQ::getCategories());

        return $smarty->fetch('adm/faq/create.tpl');
    }

    public static function faq_edit()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id_faq = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'prive');

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Foire aux questions", "/adm/faq/");
        $trail->addStep("Edition");

        if(Tools::isSubmit('form-faq-edit'))
        {
            $data = array(
                'id_faq'      => (int) Route::params('id_faq'),
                'id_category' => (int) Route::params('id_category'),
                'question'    => (string) Route::params('question'),
                'answer'      => (string) Route::params('answer'),
            );

            FAQ::getInstance($data['id_faq']);
            $faq->setIdCategory($data['id_category']);
            $faq->setQuestion($data['question']);
            $faq->setAnswer($data['answer']);
            $faq->save();

            Tools::redirect('/adm/faq/?edit=1');
        }

        $smarty->assign('categories', FAQ::getCategories());
        $smarty->assign('faq', FAQ::getInstance($id_faq));

        return $smarty->fetch('adm/faq/edit.tpl');
    }

    public static function faq_delete()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'prive');

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Foire aux questions", "/adm/faq/");
        $trail->addStep("Suppression");

        if(Tools::isSubmit('form-faq-delete'))
        {
            $faq = FAQ::getInstance($id);
            $faq->delete();

            Tools::redirect('/adm/faq/?delete=1');
        }

        $smarty->assign('faq', FAQ::getInstance($id));

        return $smarty->fetch('adm/faq/delete.tpl');
    }

    public static function cms_index()
    {
        Tools::auth(Membre::TYPE_INTERNE);
        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'prive');

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Pages Statiques");

        $smarty->assign('create', (bool) Route::params('create'));
        $smarty->assign('edit', (bool) Route::params('edit'));
        $smarty->assign('delete', (bool) Route::params('delete'));

        $smarty->assign('cmss', CMS::getCMSs());

        return $smarty->fetch('adm/cms/index.tpl');
    }

    public static function cms_create()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'prive');

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Pages Statiques", "/adm/cms/");
        $trail->addStep("Création");

        $smarty->assign('auth', Membre::getTypesMembre());

        if(Tools::isSubmit('form-cms-create'))
        {
            $data = array(
                'alias'        => (string) Route::params('alias'),
                'menuselected' => (string) Route::params('menuselected'),
                'breadcrumb'   => (string) Route::params('breadcrumb'),
                'title'        => (string) Route::params('title'),
                'content'      => (string) Route::params('content'),
                'online'       => (bool) Route::params('online'),
                'auth'         => (int) Route::params('auth'),
            );

            $cms = CMS::init();
            $cms->setAlias($data['alias']);
            $cms->setMenuselected($data['menuselected']);
            $cms->setBreadcrumb($data['breadcrumb']);
            $cms->setTitle($data['title']);
            $cms->setContent($data['content']);
            $cms->setOnline($data['online']);
            $cms->setCreatedNow();
            $cms->setAuth($data['auth']);
            $cms->save();

            Tools::redirect('/adm/cms/?create=1');
        }

        return $smarty->fetch('adm/cms/create.tpl');
    }

    public static function cms_edit()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'prive');

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Pages Statiques", "/adm/cms/");
        $trail->addStep("Edition");

        $smarty->assign('auth', Membre::getTypesMembre());

        if(Tools::isSubmit('form-cms-edit'))
        {
            $data = array(
                'id_cms'       => (int) Route::params('id_cms'),
                'alias'        => (string) Route::params('alias'),
                'menuselected' => (string) Route::params('menuselected'),
                'breadcrumb'   => (string) Route::params('breadcrumb'),
                'title'        => (string) Route::params('title'),
                'content'      => (string) Route::params('content'),
                'online'       => (bool) Route::params('online'),
                'auth'         => (int) Route::params('auth'),
            );

            $cms = CMS::getInstance($data['id_cms']);
            $cms->setAlias($data['alias']);
            $cms->setMenuselected($data['menuselected']);
            $cms->setBreadcrumb($data['breadcrumb']);
            $cms->setTitle($data['title']);
            $cms->setContent($data['content']);
            $cms->setOnline($data['online']);
            $cms->setAuth($data['auth']);
            $cms->setModifiedNow();
            $cms->save();

            Tools::redirect('/adm/cms/?edit=1');
        }

        $smarty->assign('cms', CMS::getInstance($id));

        return $smarty->fetch('adm/cms/edit.tpl');
    }

    public static function cms_delete()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'prive');

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Pages Statiques", "/adm/cms/");
        $trail->addStep("Suppression");

        if(Tools::isSubmit('form-cms-delete'))
        {
           $cms = CMS::getInstance($id);
           $cms->delete();

           Tools::redirect('/adm/cms/?delete=1');
        }

        $smarty->assign('cms', CMS::getInstance($id));

        return $smarty->fetch('adm/cms/delete.tpl');
    }
}
