<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\CMS;
use Adhoc\Model\Event;
use Adhoc\Model\FAQ;
use Adhoc\Model\Featured;
use Adhoc\Model\Groupe;
use Adhoc\Model\Lieu;
use Adhoc\Model\Membre;
use Adhoc\Model\Newsletter;
use Adhoc\Model\Partner;
use Adhoc\Model\Video;
use Adhoc\Utils\AdHocTwig;
use Adhoc\Utils\Email;
use Adhoc\Utils\Route;
use Adhoc\Utils\Tools;
use Adhoc\Utils\Trail;

final class Controller
{
    /**
     * Homepage
     *
     * @return string
     */
    public static function index(): string
    {
        $twig = new AdHocTwig();

        $videos = Video::find([
            'id_lieu' => 1,
            'has_groupe' => true,
            'online' => true,
            'order_by' => 'random',
            'sort' => 'DESC',
            'start' => 0,
            'limit' => 6,
        ]);
        $twig->assign('videos', $videos);

        $featured = Featured::find([
            'online' => true,
            'current' => true,
            'order_by' => 'modified_at',
            'sort' => 'DESC',
            'limit' => 6,
        ]);
        $twig->assign('featured', $featured);

        $twig->enqueueScript('/js/swipe.min.js');
        $twig->enqueueScript('/js/featured.js');

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
        $twig->assign('events', $events);

        return $twig->render('bs/index.twig');
    }

    /**
     * Les partenaires
     *
     * @return string
     */
    public static function partners(): string
    {
        $twig = new AdHocTwig();

        $twig->assign('title', "♫ Les Partenaires de l'association AD'HOC");
        $twig->assign('description', "Les Partenaires de l'Association AD'HOC");

        Trail::getInstance()
            ->addStep("Partenaires");

        $twig->assign('partners', Partner::findAll());

        return $twig->render('partners.twig');
    }

    /**
     * Formulaire de contact
     *
     * @return string
     */
    public static function contact(): string
    {
        $twig = new AdHocTwig();

        $twig->enqueueScript('/js/contact.js');

        Trail::getInstance()
            ->addStep("Contact");

        $twig->assign('title', "Contacter l'Association AD'HOC");
        $twig->assign('description', "Association oeuvrant pour le développement de la vie musicale en Essonne");

        $twig->assign('faq', FAQ::findAll());

        if (!Tools::isSubmit('form-contact')) {
            $twig->assign('show_form', true);

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
                    $data['name'] = $_SESSION['membre']->getFirstName() . ' ' . $_SESSION['membre']->getLastName()
                                  . ' (' . $_SESSION['membre']->getPseudo() . ')';
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

            $errors = self::validateContactForm($data);
            if (count($errors) === 0) {
                // 1. envoi du mail aux destinataires
                $data['email_reply_to'] = $data['email'];
                if (Email::send(CONTACT_FORM_TO, $data['subject'], 'form-contact-to', $data)) {
                    $twig->assign('sent_ok', true);
                } else {
                    $twig->assign('sent_ko', true);
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
                $twig->assign('sent_ko', true);
                $twig->assign('show_form', true);
                foreach ($errors as $k => $v) {
                    $twig->assign('error_' . $k, $v);
                }
            }
        }

        $twig->assign('name', $data['name']);
        $twig->assign('email', $data['email']);
        $twig->assign('subject', $data['subject']);
        $twig->assign('text', $data['text']);
        $twig->assign('mailing', $data['mailing']);
        $twig->assign('check', $data['check']);

        return $twig->render('contact.twig');
    }

    /**
     * Plan du site
     *
     * @return string
     */
    public static function sitemap(): string
    {
        $twig = new AdHocTwig();

        $twig->assign(
            'groupes',
            Groupe::find([
                'online' => true,
                'order_by' => 'name',
                'sort' => 'ASC',
            ])
        );

        $twig->assign(
            'lieux',
            Lieu::find([
                'online' => true,
                'order_by' => 'id_lieu',
                'sort' => 'ASC',
            ])
        );

        $twig->assign(
            'events',
            Event::find([
                'online' => true,
                'order_by' => 'id_event',
                'sort' => 'ASC',
            ])
        );

        return $twig->render('sitemap.twig');
    }

    /**
     * Page plan du site
     *
     * @return string
     */
    public static function map(): string
    {
        $twig = new AdHocTwig();

        $from = trim((string) Route::params('from'));
        $twig->assign('referer', $from);

        Trail::getInstance()
            ->addStep("Plan du Site");

        return $twig->render('map.twig');
    }

    /**
     * Page des mentions légales
     *
     * @return string
     */
    public static function mentionsLegales(): string
    {
        $twig = new AdHocTwig();

        Trail::getInstance()
            ->addStep("Mentions Légales");

        return $twig->render('mentions-legales.twig');
    }

    /**
     * Page des crédits
     *
     * @return string
     */
    public static function credits(): string
    {
        $twig = new AdHocTwig();

        Trail::getInstance()
            ->addStep("Crédits");

        return $twig->render('credits.twig');
    }

    /**
     * Player vidéo HLS pour les événéments en direct
     *
     * @return string
     */
    public static function onair(): string
    {
        $twig = new AdHocTwig();

        $twig->enqueueScript('/js/hls.min.js');
        $twig->enqueueScript('/js/onair.js');

        $twig->enqueueScriptVar('videoSrc', 'https://live.adhocmusic.com/hls/onair.m3u8');

        Trail::getInstance()
            ->addStep("ON AIR");

        return $twig->render('onair.twig');
    }

    /**
     * Page dynamique issu du CMS
     *
     * @return string
     */
    public static function cms(): string
    {
        $id = (int) Route::params('id');
        $cms = CMS::getInstance($id);

        if ($cms->getAuth()) {
            Tools::auth(Membre::TYPE_INTERNE);
        }

        $twig = new AdHocTwig();

        return
            $twig->render('common/header.twig')
          . $cms->getContent()
          . $twig->render('common/footer.twig');
    }

    /**
     * Redirection après tracking liens newsletter
     *
     * Ex: /r/XXX||YYY
     * avec XXX = url de redirection en base64
     * et   YYY = id_newsletter|id_contact en base64
     *
     * @return void
     */
    public static function r(): void
    {
        $url = urldecode((string) Route::params('url'));
        list($url, $from) = explode('||', $url);
        $url = Tools::base64UrlDecode($url);
        $from = Tools::base64UrlDecode($from);
        list($id_newsletter, $id_contact) = explode('|', $from);
        Tools::redirect($url);
    }

    /**
     * Routine de validation des données du formulaire
     *
     * @param array<string,mixed> $data tableau des données
     *
     * @return array<string,string>
     */
    private static function validateContactForm(array $data): array
    {
        $errors = [];

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
        } elseif (
            (strpos($data['text'], '[link=') !== false)
            || (strpos($data['text'], '[url=') !== false)
            || (strpos($data['text'], '<a href=') !== false)
        ) {
            $errors['text'] = "Message un peu douteux...";
        }
        if (!Tools::checkCSRFToken($data['check'])) {
            $errors['check'] = "Code de vérification invalide";
        }

        return $errors;
    }
}
