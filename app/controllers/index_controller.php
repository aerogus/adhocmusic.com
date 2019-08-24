<?php

final class Controller
{
    /**
     * Homepage
     *
     * @return string
     */
    static function index() : string
    {
        $page = (int) Route::params('page');

        $smarty = new AdHocSmarty();

        $smarty->assign('title', "♫ AD'HOC : les Musiques Actuelles en Essonne");
        $smarty->assign('description', "Portail de référence sur les musiques actuelles en Essonne, Agenda culturel géolocalisé, Vidéos de concerts, promotion d'artistes ...");
        $smarty->assign('og_type', 'website');
        $smarty->assign('og_image', HOME_URL . '/img/screenshot-homepage.jpg');

        $smarty->assign(
            'videos', Video::getVideos(
                [
                    'online' => true,
                    'sort'   => 'random',
                    'lieu'   => 1,
                    'limit'  => 6,
                ]
            )
        );

        $smarty->assign('featured', Featured::getFeaturedHomepage());
        $smarty->enqueue_script('/js/swipe.min.js');
        $smarty->enqueue_script('/js/featured.js');

        $events = Event::getEvents(
            [
                'online' => true,
                'sort'   => 'date',
                'sens'   => 'ASC',
                'limit'  => 30,
                'datdeb' => date('Y-m-d'),
            ]
        );

        // tri par mois
        $evts = [];
        foreach ($events as $event) {
            $month = substr($event['date'], 0, 7).'-01';
            if (!array_key_exists($month, $evts)) {
                $evts[$month] = [];
            }
            $evts[$month][] = $event;
        }
        $smarty->assign('evts', $evts);

        $smarty->assign('events', $events);

        return $smarty->fetch('index.tpl');
    }

    /**
     * Les partenaires
     *
     * @return string
     */
    static function partners() : string
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('title', "♫ Les Partenaires de l'association AD'HOC / Devenir Partenaire");
        $smarty->assign('description', "Les Partenaires de l'Association AD'HOC");

        $trail = Trail::getInstance();
        $trail->addStep("Partenaires");

        return $smarty->fetch('partners.tpl');
    }

    /**
     * Formulaire de contact
     *
     * @return string
     */
    static function contact() : string
    {
        $smarty = new AdHocSmarty();

        $smarty->enqueue_script('/js/contact.js');

        $trail = Trail::getInstance();
        $trail->addStep("Contact");

        $smarty->assign('title', "Contacter l'Association AD'HOC");
        $smarty->assign('description', "Association oeuvrant pour le développement de la vie musicale en Essonne depuis 1996. Promotion d'artistes, Pédagogie musicale, Agenda concerts, Communauté de musiciens ..");

        $smarty->assign('faq', FAQ::getFAQs());

        // valeurs par défaut
        $data = [
            'name'    => '',
            'email'   => '',
            'subject' => '',
            'text'    => '',
            'date'    => date('Y-m-d H:i:s'),
            'mailing' => true,
            'check'   => Tools::getCSRFToken(),
        ];

        if (!empty($_SESSION['membre'])) {
            $data['name'] = $_SESSION['membre']->getFirstName() . " " . $_SESSION['membre']->getLastName() . " (" . $_SESSION['membre']->getPseudo() . ")";
            $data['email'] = $_SESSION['membre']->getEmail();
        }

        if (Tools::isSubmit('form-contact')) {

            if (Tools::checkCSRFToken((string) Route::params('check')) === false) {
                //die(); // mauvais code sécurité
            }

            $data = [
                'name'        => trim((string) Route::params('name')),
                'email'       => trim((string) Route::params('email')),
                'subject'     => trim((string) Route::params('subject')),
                'text'        => trim((string) Route::params('text')),
                'date'        => date('Y-m-d H:i:s'),
                'mailing'     => (bool) Route::params('mailing'),
                'check'       => (string) Route::params('check'),
            ];
            $errors = [];

            self::_validateContactForm($data, $errors);

            if (empty($errors)) {

                // 1 - envoi du mail au destinataire
                $data['email_reply_to'] = $data['email'];
                if (Email::send(['bureau@adhocmusic.com', 'site@adhocmusic.com', 'contact@adhocmusic.com'], $data['subject'], 'form-contact-to', $data)) {
                    $smarty->assign('sent_ok', true);
                } else {
                    $smarty->assign('sent_ko', true);
                }

                // 2 - envoi de la copie à l'expéditeur
                $data['email_reply_to'] = 'site@adhocmusic.com';
                Email::send($data['email'], "[cc]" . $data['subject'], 'form-contact-cc', $data);

                if ($data['mailing']) {
                    Newsletter::addEmail($data['email']);
                }

            } else {

                // erreur dans le form
                $smarty->assign('show_form', true);
                foreach ($errors as $k => $v) {
                    $smarty->assign('error_' . $k, $v);
                }

            }

        }

        $smarty->assign('show_form', true);
        $smarty->assign('name', $data['name']);
        $smarty->assign('email', $data['email']);
        $smarty->assign('subject', $data['subject']);
        $smarty->assign('text', $data['text']);
        $smarty->assign('mailing', $data['mailing']);
        $smarty->assign('check', $data['check']);

        return $smarty->fetch('contact.tpl');
    }

    /**
     * Plan du site
     *
     * @return string
     */
    static function sitemap() : string
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('groupes', Groupe::getGroupes([
            'sort'   => 'id',
            'sens'   => 'ASC',
            'online' => true,
            'limit'  => false,
        ]));

        $smarty->assign('lieux', Lieu::getLieux([
            'sort'   => 'id',
            'sens'   => 'ASC',
            'online' => true,
            'limit'  => false,
        ]));

        $smarty->assign('events', Event::getEvents([
            'sort'   => 'id',
            'sens'   => 'ASC',
            'online' => true,
            'limit'  => false,
        ]));

        return $smarty->fetch('sitemap.tpl');
    }

    static function map() : string
    {
        $smarty = new AdHocSmarty();

        $from = trim((string) Route::params('from'));
        $smarty->assign('from', $from);

        $trail = Trail::getInstance();
        $trail->addStep("Plan du Site");

        return $smarty->fetch('map.tpl');
    }

    static function mentions_legales() : string
    {
        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Mentions Légales");

        return $smarty->fetch('mentions-legales.tpl');
    }

    static function cms() : string
    {
        $id = (int) Route::params('id');
        $cms = CMS::getInstance($id);

        if ($cms->getAuth()) {
            Tools::auth(Membre::TYPE_INTERNE);
        }

        $smarty = new AdHocSmarty();

        return $smarty->fetch('common/header.tpl') . $cms->getContent() . $smarty->fetch('common/footer.tpl');
    }

    /**
     * Redirection après tracking liens newsletter
     * 
     * ex: /r/XXX||YYY
     * avec XXX = url de redirection en base64
     * et   YYY = id_newsletter|id_contact en base64
     */
    static function r()
    {
        $url = urldecode((string) Route::params('url'));
        list($url, $from) = explode('||', $url);
        $url = Tools::base64_url_decode($url);
        $from = Tools::base64_url_decode($from);
        list($id_newsletter, $id_contact) = explode('|', $from);
        Newsletter::addHit($id_newsletter, $id_contact, $url);
        Tools::redirect($url);
    }

    /**
     * Page guide de style
     */
    static function styleguide() : string
    {
        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Guide de style");

        return $smarty->fetch('styleguide.tpl');
    }

    /**
     * Routine de validation des données du formulaire
     *
     * @param array $data   tableau des données
     * @param array $errors tableau des erreurs (par référence)
     *
     * @return bool
     */
    private static function _validateContactForm(array $data, array &$errors) : bool
    {
        if (empty($data['name'])) {
            $errors['name'] = "Vous devez renseigner votre nom";
        }
        if (empty($data['email'])) {
            $errors['email'] = "Vous devez préciser votre email";
        } elseif (!Email::validate($data['email'])) {
            $errors['email'] = "Votre Email semble invalide ...";
        }
        if (empty($data['subject'])) {
            $errors['subject'] = "Vous devez saisir un sujet";
        }
        if (empty($data['text'])) {
            $errors['text'] = "Vous devez écrire quelque chose !";
        } elseif (strlen($data['text']) < 8) {
            $errors['text'] = "Message un peu court !";
        } elseif ((strpos($data['text'], '[link=') !== false)
            || (strpos($data['text'], '[url=') !== false)
            || (strpos($data['text'], '<a href=') !== false)
        ) {
            $errors['text'] = "Message un peu douteux Michel !";
        }
        return true;
    }
}
