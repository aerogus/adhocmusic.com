<?php declare(strict_types=1);

final class Controller
{
    /**
     * Homepage
     *
     * @return string
     */
    static function index(): string
    {
        $smarty = new AdHocSmarty();

        $smarty->assign(
            [
                'title' => "♫ AD'HOC : les Musiques Actuelles en Essonne",
                'description' => "Portail de référence sur les musiques actuelles en Essonne, Agenda culturel géolocalisé, Vidéos de concerts, promotion d'artistes...",
                'og_type' => 'website',
                'og_image' => HOME_URL . '/img/screenshot-homepage.jpg',
            ]
        );

        $smarty->assign(
            'videos', Video::find(
                [
                    'id_lieu' => 1,
                    'has_groupe' => true,
                    'online' => true,
                    'order_by' => 'random',
                    'sort' => 'DESC',
                    'start' => 0,
                    'limit' => 6,
                ]
            )
        );

        $smarty->assign(
            'featured', Featured::find(
                [
                    'online' => true,
                    'current' => true,
                    'order_by' => 'modified_at',
                    'sort' => 'DESC',
                    'limit' => 6,
                ]
            )
        );

        $smarty->enqueue_script('/js/swipe.min.js');
        $smarty->enqueue_script('/js/featured.js');

        $_events = Event::find(
            [
                'datdeb' => date('Y-m-d'),
                'online' => true,
                'order_by' => 'date',
                'sort' => 'ASC',
                'limit' => 30,
            ]
        );

        // tri par mois
        $events = [];
        foreach ($_events as $event) {
            $month = substr($event->getDate(), 0, 7) . '-01';
            if (!array_key_exists($month, $events)) {
                $events[$month] = [];
            }
            $events[$month][] = $event;
        }
        $smarty->assign('events', $events);

        return $smarty->fetch('index.tpl');
    }

    /**
     * Les partenaires
     *
     * @return string
     */
    static function partners(): string
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('title', "♫ Les Partenaires de l'association AD'HOC");
        $smarty->assign('description', "Les Partenaires de l'Association AD'HOC");

        Trail::getInstance()
            ->addStep("Partenaires");

        $smarty->assign('partners', Partner::findAll());

        return $smarty->fetch('partners.tpl');
    }

    /**
     * Formulaire de contact
     *
     * @return string
     */
    static function contact(): string
    {
        $smarty = new AdHocSmarty();

        $smarty->enqueue_script('/js/contact.js');

        Trail::getInstance()
            ->addStep("Contact");

        $smarty->assign('title', "Contacter l'Association AD'HOC");
        $smarty->assign('description', "Association oeuvrant pour le développement de la vie musicale en Essonne depuis 1996. Promotion d'artistes, Pédagogie musicale, Agenda concerts, Communauté de musiciens ..");

        $smarty->assign('faq', FAQ::findAll());

        if (!Tools::isSubmit('form-contact')) {

            $smarty->assign('show_form', true);

            // valeurs par défaut
            $data = [
                'name'    => '',
                'email'   => '',
                'subject' => '',
                'text'    => '',
                'mailing' => false,
                'check'   => Tools::getCSRFToken(),
            ];

            // si identifié, préremplissage de certains champs
            if (!empty($_SESSION['membre'])) {
                if ($_SESSION['membre']->getFirstName() || $_SESSION['membre']->getLastName()) {
                    $data['name'] = $_SESSION['membre']->getFirstName() . ' ' . $_SESSION['membre']->getLastName() . ' (' . $_SESSION['membre']->getPseudo() . ')';
                } else {
                    $data['name'] = $_SESSION['membre']->getPseudo();
                }
                $data['email'] = $_SESSION['membre']->getEmail();
            }

        } else {

            $data = [
                'name'    => trim((string) Route::params('name')),
                'email'   => trim((string) Route::params('email')),
                'subject' => trim((string) Route::params('subject')),
                'text'    => trim((string) Route::params('text')),
                'mailing' => (bool) Route::params('mailing'),
                'check'   => (string) Route::params('check'),
            ];
            $errors = [];

            self::_validateContactForm($data, $errors);

            if (empty($errors)) {

                // 1. envoi du mail aux destinataires
                $data['email_reply_to'] = $data['email'];
                if (Email::send(CONTACT_FORM_TO, $data['subject'], 'form-contact-to', $data)) {
                    $smarty->assign('sent_ok', true);
                } else {
                    $smarty->assign('sent_ko', true);
                }

                // 2. envoi de la copie à l'expéditeur
                $data['email_reply_to'] = 'contact@adhocmusic.com';
                if (Email::send($data['email'], '[cc] ' . $data['subject'], 'form-contact-cc', $data)) {
                    if ($data['mailing']) {
                        Newsletter::addEmail($data['email']);
                    }
                }

            } else {

                // erreur dans le form
                $smarty->assign('sent_ko', true);
                $smarty->assign('show_form', true);
                foreach ($errors as $k => $v) {
                    $smarty->assign('error_' . $k, $v);
                }

            }

        }

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
    static function sitemap(): string
    {
        $smarty = new AdHocSmarty();

        $smarty->assign(
            'groupes', Groupe::find(
                [
                    'online' => true,
                    'order_by' => 'name',
                    'sort' => 'ASC',
                ]
            )
        );

        $smarty->assign(
            'lieux', Lieu::find(
                [
                    'online' => true,
                    'order_by' => 'id_lieu',
                    'sort' => 'ASC',
                ]
            )
        );

        $smarty->assign(
            'events', Event::find(
                [
                    'online' => true,
                    'order_by' => 'id_event',
                    'sort' => 'ASC',
                ]
            )
        );

        return $smarty->fetch('sitemap.tpl');
    }

    /**
     * Page plan du site
     *
     * @return string
     */
    static function map(): string
    {
        $smarty = new AdHocSmarty();

        $from = trim((string) Route::params('from'));
        $smarty->assign('from', $from);

        Trail::getInstance()
            ->addStep("Plan du Site");

        return $smarty->fetch('map.tpl');
    }

    /**
     * Page des mentions légales
     *
     * @return string
     */
    static function mentions_legales(): string
    {
        $smarty = new AdHocSmarty();

        Trail::getInstance()
            ->addStep("Mentions Légales");

        return $smarty->fetch('mentions-legales.tpl');
    }

    /**
     * Page des crédits
     *
     * @return string
     */
    static function credits(): string
    {
        $smarty = new AdHocSmarty();

        Trail::getInstance()
            ->addStep("Crédits");

        return $smarty->fetch('credits.tpl');
    }

    /**
     * Player vidéo HLS pour les événéments en direct
     */
    static function onair(): string
    {
        $smarty = new AdHocSmarty();

        $smarty->enqueue_script('/js/hls.min.js');
        $smarty->enqueue_script('/js/onair.js');

        $smarty->enqueue_script_var('videoSrc', 'https://live.adhocmusic.com/hls/onair.m3u8');

        Trail::getInstance()
            ->addStep("ON AIR");

        return $smarty->fetch('onair.tpl');
    }

    /**
     * Page dynamique issu du CMS
     *
     * @return string
     */
    static function cms(): string
    {
        $id = (int) Route::params('id');
        $cms = CMS::getInstance($id);

        if ($cms->getAuth()) {
            Tools::auth(Membre::TYPE_INTERNE);
        }

        $smarty = new AdHocSmarty();

        return
            $smarty->fetch('common/header.tpl')
          . $cms->getContent()
          . $smarty->fetch('common/footer.tpl');
    }

    /**
     * Redirection après tracking liens newsletter
     * 
     * Ex: /r/XXX||YYY
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
        Newsletter::addHit((int) $id_newsletter, (int) $id_contact, $url);
        Tools::redirect($url);
    }

    /**
     * Routine de validation des données du formulaire
     *
     * @param array $data   tableau des données
     * @param array $errors tableau des erreurs (par référence)
     *
     * @return bool
     */
    private static function _validateContactForm(array $data, array &$errors): bool
    {
        if (empty($data['name'])) {
            $errors['name'] = "Vous devez renseigner votre nom";
        }
        if (empty($data['email'])) {
            $errors['email'] = "Vous devez préciser votre email";
        } elseif (!Email::validate($data['email'])) {
            $errors['email'] = "Votre email semble invalide ...";
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
            $errors['text'] = "Message un peu douteux...";
        }
        if (!Tools::checkCSRFToken($data['check'])) {
            $errors['check'] = "Code de vérification invalide";
        }
        return true;
    }
}
