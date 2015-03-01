<?php

class Controller
{
    public static function index()
    {
        $page = (int) Route::params('page');

        $smarty = new AdHocSmarty();

        $smarty->assign('title', "♫ AD'HOC : les Musiques Actuelles en Essonne");
        $smarty->assign('description', "Portail de référence sur les musiques actuelles en Essonne, Agenda culturel géolocalisé, Vidéos de concerts, promotion d'artistes ...");
        $smarty->assign('og_type', 'website');
        $smarty->assign('og_image', STATIC_URL . '/img/screenshot-homepage.jpg');

        $smarty->assign('menuselected', 'home');

        $smarty->assign('videos', Video::getVideos(array(
            'online' => true,
            'sort'   => 'random',
            'lieu'   => 1,
            'limit'  => 6,
        )));

        $smarty->assign('featured', Featured::getFeaturedHomepage());

        $events = Event::getEvents(array(
            'online'      => true,
            'sort'        => 'date',
            'sens'        => 'ASC',
            'limit'       => 30,
            'departement' => '91,92,93,94,95,75,78',
            'datdeb'      => date('Y-m-d'),
            'fetch_fb'    => false,
        ));

        // tri par mois
        $evts = array();
        foreach($events as $event)
        {
            $month = substr($event['date'], 0, 7).'-01';
            if(!array_key_exists($month, $evts)) {
                $evts[$month] = array();
            }
            $evts[$month][] = $event;
        }
        $smarty->assign('evts', $evts);

        $smarty->assign('events', $events);

        return $smarty->fetch('index.tpl');
    }

    public static function shop()
    {
        $smarty = new AdHocSmarty();
        return $smarty->fetch('shop.tpl');
    }

    public static function news()
    {
        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        try {
            $news = News::getInstance($id);
        } catch(AdHocUserException $e) {
            Route::set_http_code('404');
            $smarty->assign('unknown_news', true);
            return $smarty->fetch('news.tpl');
        }

        $smarty->assign('menuselected', 'home');

        $trail = Trail::getInstance();
        $trail->addStep("News", "/");
        $trail->addStep($news->getTitle(), "/news/" . $news->getId());

        $smarty->assign('title', "♫ AD'HOC News : " . $news->getTitle());
        $smarty->assign('description', substr(str_replace("\r", "", str_replace("\n", " ", trim(strip_tags($news->getText())))), 0, 175) . " ...");

        $smarty->assign('news', $news);
        $smarty->assign('newslist', News::getNewsList(array(
            'online' => true,
            'sort'   => 'created_on',
            'sens'   => 'DESC',
            'debut'  => 0,
            'limit'  => 10,
        )));
        return $smarty->fetch('news.tpl');
    }

    public static function partners()
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('title', "♫ Les Partenaires de l'association AD'HOC / Devenir Partenaire");
        $smarty->assign('description', "Les Partenaires de l'Association AD'HOC");

        $smarty->assign('menuselected', 'home');

        $trail = Trail::getInstance();
        $trail->addStep("Partenaires");

        return $smarty->fetch('partners.tpl');
    }

    public static function visuels()
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('title', "♫ Les Visuels de l'association AD'HOC");
        $smarty->assign('description', "Les visuels d'AD'HOC");

        $smarty->assign('menuselected', 'home');

        $trail = Trail::getInstance();
        $trail->addStep("Visuels");

        return $smarty->fetch('visuels.tpl');
    }

    public static function contact()
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'contact');

        $trail = Trail::getInstance();
        $trail->addStep("Nous Contacter");

        $smarty->assign('title', "Contacter l'Association AD'HOC");
        $smarty->assign('description', "Association oeuvrant pour le développement de la vie musicale en Essonne depuis 1996. Promotion d'artistes, Pédagogie musicale, Agenda concerts, Communauté de musiciens ..");

        $smarty->assign('faq', FAQ::getFAQs());

        // valeurs par défaut
        $data = array(
            'name'       => '',
            'email'      => '',
            'subject'    => '',
            'text'       => '',
            'date'       => date('Y-m-d H:i:s'),
            'cc'         => true,
            'mailing'    => true,
            'attachment' => '',
            'check'      => Tools::getCSRFToken(),
        );

        if(!empty($_SESSION['membre'])) {
            $data['name'] = $_SESSION['membre']->getFirstName() . " " . $_SESSION['membre']->getLastName() . " (" . $_SESSION['membre']->getPseudo() . ")";
            $data['email'] = $_SESSION['membre']->getEmail();
        }

        if(Tools::isSubmit('form-contact'))
        {
            if(Tools::checkCSRFToken((string) Route::params('check')) === false) {
                //die(); // mauvais code sécurité
            }

            $data = array(
                'name'        => trim((string) Route::params('name')),
                'email'       => trim((string) Route::params('email')),
                'subject'     => trim((string) Route::params('subject')),
                'text'        => trim((string) Route::params('text')),
                'date'        => date('Y-m-d H:i:s'),
                'cc'          => (bool) Route::params('cc'),
                'mailing'     => (bool) Route::params('mailing'),
                'attachment'  => Route::params('attachment'),
                'check'       => (string) Route::params('check'),
            );

            self::_validate_form_contact($data, $errors);

            if(empty($errors)) {

                // 1 - envoi du mail au destinataire
                $data['email_reply_to'] = $data['email'];
                if(Email::send(array('bureau@adhocmusic.com', 'site@adhocmusic.com', 'contact@adhocmusic.com'), $data['subject'], 'form-contact-to', $data)) {
                    $smarty->assign('sent_ok', true);
                } else {
                    $smarty->assign('sent_ko', true);
                }
    
                // 2 - envoi de la copie à l'expéditeur
                if($data['cc']) {
                     $data['email_reply_to'] = 'site@adhocmusic.com';
                     Email::send($data['email'], "[cc]" . $data['subject'], 'form-contact-cc', $data);
                }
    
                if($data['mailing']) {
                    Newsletter::addEmail($data['email']);
                }

            } else {

                // erreur dans le form
                $smarty->assign('show_form', true);
                foreach($errors as $k => $v) {
                    $smarty->assign('error_' . $k, $v);
                }

            }

        }

        $smarty->assign('show_form', true);
        $smarty->assign('name', $data['name']);
        $smarty->assign('email', $data['email']);
        $smarty->assign('subject', $data['subject']);
        $smarty->assign('text', $data['text']);
        $smarty->assign('cc', $data['cc']);
        $smarty->assign('mailing', $data['mailing']);
        $smarty->assign('attachment', $data['attachment']);
        $smarty->assign('check', $data['check']);

        return $smarty->fetch('contact.tpl');
    }

    protected static function _validate_form_contact($data, &$errors)
    {
        $errors = array();
        if(empty($data['name'])) {
            $errors['name'] = "Vous devez renseigner votre nom";
        }
        if(empty($data['email'])) {
            $errors['email'] = "Vous devez préciser votre email";
        } elseif(!Email::validate($data['email'])) {
            $errors['email'] = "Votre Email semble invalide ...";
        }
        if(empty($data['subject'])) {
            $errors['subject'] = "Vous devez saisir un sujet";
        }
        if(empty($data['text'])) {
            $errors['text'] = "Vous devez écrire quelque chose !";
        } elseif(strlen($data['text']) < 8) {
            $errors['text'] = "Message un peu court !";
        } elseif((strpos($data['text'], '[link=') !== false)
              || (strpos($data['text'], '[url=') !== false)
              || (strpos($data['text'], '<a href=') !== false)) {
            $errors['text'] = "Message un peu douteux Michel !";
        }
        return true;
    }

    public static function sitemap()
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('groupes', Groupe::getGroupes(array(
            'sort'   => 'id',
            'sens'   => 'ASC',
            'online' => true,
            'limit'  => false,
        )));

        $smarty->assign('lieux', Lieu::getLieux(array(
            'sort'   => 'id',
            'sens'   => 'ASC',
            'online' => true,
            'limit'  => false,
        )));

        $smarty->assign('events', Event::getEvents(array(
            'sort'   => 'id',
            'sens'   => 'ASC',
            'online' => true,
            'limit'  => false,
        )));

        $smarty->assign('articles', Article::getArticles(array(
            'sort'   => 'id',
            'sens'   => 'ASC',
            'online' => true,
            'limit'  => false,
        )));

        return $smarty->fetch('sitemap.tpl');
    }

    public static function map()
    {
        $smarty = new AdHocSmarty();

        $from = trim((string) Route::params('from'));
        $smarty->assign('from', $from);

        $smarty->assign('menuselected', 'home');

        $trail = Trail::getInstance();
        $trail->addStep("Plan du Site");

        return $smarty->fetch('map.tpl');
    }

    public static function mentions_legales()
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'home');

        $trail = Trail::getInstance();
        $trail->addStep("Mentions Légales");

        return $smarty->fetch('mentions-legales.tpl');
    }

    public static function cms()
    {
        $id = (int) Route::params('id');
        $cms = CMS::getInstance($id);

        if($cms->getAuth()) {
            Tools::auth(Membre::TYPE_INTERNE);
        }

        $smarty = new AdHocSmarty();

        return $smarty->fetch('common/header.tpl') . $cms->getContent() . $smarty->fetch('common/footer.tpl');
    }    

    public static function r()
    {
        $url = urldecode((string) Route::params('url'));
        list($url, $from) = explode('||', $url);
        $from = Tools::base64_url_decode($from);
        $url = Tools::base64_url_decode($url);
        list($id_newsletter, $id_contact) = explode('|', $from);
        Newsletter::addHit($id_newsletter, $id_contact, $url);
        // todo: track le hit
        Tools::redirect($url);
    }
}
