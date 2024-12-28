<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\Audio;
use Adhoc\Model\Event;
use Adhoc\Model\Groupe;
use Adhoc\Model\Lieu;
use Adhoc\Model\Membre;
use Adhoc\Model\Photo;
use Adhoc\Model\Structure;
use Adhoc\Model\Video;
use Adhoc\Model\Style;
use Adhoc\Utils\AdHocTwig;
use Adhoc\Utils\Conf;
use Adhoc\Utils\Date;
use Adhoc\Utils\Log;
use Adhoc\Utils\Image;
use Adhoc\Utils\Route;
use Adhoc\Utils\Tools;

final class Controller
{
    /**
     * @return string
     */
    public static function index(): string
    {
        $twig = new AdHocTwig();

        $twig->enqueueScript('/js/events/index.js');

        $twig->assign('breadcrumb', [
            ['title' => '🏠', 'link' => '/'],
            'Agenda',
        ]);

        $twig->assign('create', (bool) Route::params('create'));
        $twig->assign('edit', (bool) Route::params('edit'));
        $twig->assign('delete', (bool) Route::params('delete'));

        $year  = (int) Route::params('y');
        $month = (int) Route::params('m');
        $day   = (int) Route::params('d');

        if ($year > 0 && $month > 0 && $day > 0) { // filtrage d'un jour donné
            $datdeb = date('Y-m-d H:i:s', mktime(0, 0, 0, $month, $day, $year)); // début de la journée
            $datfin = date('Y-m-d H:i:s', mktime(23, 59, 59, $month, $day, $year)); // fin de la journée
        } elseif ($year > 0 && $month > 0) { // filtrage au mois
            $datdeb = date('Y-m-d H:i:s', mktime(0, 0, 0, $month, 1, $year)); // 1er du mois
            $datfin = date('Y-m-d H:i:s', mktime(23, 59, 59, $month, 31, $year)); // dernier du mois
        } else { // par défaut filtrage des 3 prochains mois
            $datdeb = date('Y-m-d H:i:s', mktime(0, 0, 0, (int) date('m'), (int) date('d'), (int) date('Y'))); // aujourd'hui
            $datfin = date('Y-m-d H:i:s', mktime(23, 59, 59, (int) date('m') + 3, (int) date('d'), (int) date('Y')));
        }

        $_events = Event::find(
            [
                'datdeb' => $datdeb,
                'datfin' => $datfin,
                'online' => true,
                'order_by' => 'date',
                'sort' => 'ASC',
            ]
        );

        $events = [];
        foreach ($_events as $event) {
            $_day = substr($event->getDate(), 0, 10);
            if (!array_key_exists($_day, $events)) {
                $events[$_day] = [];
            }
            $events[$_day][] = Event::getInstance($event->getIdEvent());
        }

        $twig->assign('title', "Agenda Concerts");
        $twig->assign('description', "Agenda Concert");

        $twig->assign('events', $events);

        $twig->assign('year', ($year > 0 ? $year : date('Y')));
        $twig->assign('month', ($month > 0 ? $month : date('m')));
        $twig->assign('day', ($day > 0 ? $day : date('d')));

        return $twig->render('events/index.twig');
    }

    /**
     * Retourne le .ics (calendrier) pour l'événement
     * Dépendance composer de Eluceo\iCal
     *
     * @return string
     */
    public static function ical(): string
    {
        $id_event = (int) Route::params('id');

        try {
            $event = Event::getInstance($id_event);
        } catch (\Exception $e) {
            Route::setHttpCode(404);
            return 'not found';
        }

        $vEvent = (new \Eluceo\iCal\Domain\Entity\Event())
            ->setSummary($event->getName())
            ->setDescription($event->getText())
            ->setOccurrence(
                new \Eluceo\iCal\Domain\ValueObject\SingleDay(
                    new \Eluceo\iCal\Domain\ValueObject\Date(
                        \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $event->getDate())
                    )
                )
            );

        $vCalendar = new \Eluceo\iCal\Domain\Entity\Calendar([$vEvent]);
        $vComponentFactory = new \Eluceo\iCal\Presentation\Factory\CalendarFactory();

        return (string) $vComponentFactory->createCalendar($vCalendar);
    }

    /**
     * @return string
     */
    public static function show(): string
    {
        $id_event = (int) Route::params('id');

        $twig = new AdHocTwig();

        $twig->enqueueStyle('/static/library/baguetteBox@1.11.1/baguetteBox.min.css');
        $twig->enqueueScript('/static/library/masonry@4.2.2/masonry.min.js');
        $twig->enqueueScript('/static/library/imagesloaded@4.1.4/imagesloaded.min.js');
        $twig->enqueueScript('/static/library/baguetteBox@1.11.1/baguetteBox.min.js');
        $twig->enqueueScript('/js/events/show.js');

        $breadcrumb = [
            ['title' => '🏠', 'link' => '/'],
            ['title' => 'Agenda', 'link' => '/events'],
        ];

        try {
            $event = Event::getInstance($id_event);
            $breadcrumb[] = $event->getName();
        } catch (\Exception $e) {
            Route::setHttpCode(404);
            $breadcrumb[] = "Évènement introuvable";
            $twig->assign('breadcrumb', $breadcrumb);
            $twig->assign('unknown_event', true);
            return $twig->render('events/show.twig');
        }

        $twig->assign('year', $event->getYear());
        $twig->assign('month', $event->getMonth());
        $twig->assign('day', $event->getDay());

        $twig->assign('event', $event);

        $twig->assign('title', '♫ ' . $event->getName());
        $twig->assign('description', "Date : " . Date::mysqlDatetime($event->getDate(), 'd/m/Y') . " | Lieu : " . $event->getLieu()->getName() . " " . $event->getLieu()->getAddress() . " " . $event->getLieu()->getCity()->getCp() . " " . $event->getLieu()->getCity()->getName());

        $twig->assign(
            'photos',
            Photo::find(
                [
                    'id_event' => $event->getIdEvent(),
                    'online' => true,
                    'limit' => 100,
                ]
            )
        );

        $twig->assign(
            'audios',
            Audio::find(
                [
                    'id_event' => $event->getIdEvent(),
                    'online' => true,
                    'order_by' => 'random',
                    'limit' => 100,
                ]
            )
        );

        $twig->assign(
            'videos',
            Video::find(
                [
                    'id_event' => $event->getIdEvent(),
                    'online' => true,
                    'order_by' => 'id_video',
                    'sort' => 'ASC',
                    'limit' => 100,
                ]
            )
        );

        $twig->assign('jour', Date::mysqlDatetime($event->getDate(), "d/m/Y"));
        $twig->assign('heure', Date::mysqlDatetime($event->getDate(), "H:i"));

        if (!is_null($event->getIdContact())) {
            try {
                // le membre peut avoir été supprimé ...
                $membre = Membre::getInstance($event->getIdContact());
                $twig->assign('membre', $membre);
            } catch (\Exception $e) {
                mail(DEBUG_EMAIL, "[AD'HOC] Bug : evenement " . $event->getIdEvent() . " avec membre " . $event->getIdContact() . " introuvable", print_r($e, true));
            }
        }

        if (file_exists(Event::getBasePath() . '/' . $event->getIdEvent() . '.jpg')) {
            $twig->assign('og_image', $event->getThumbUrl());
        }

        $twig->assign('breadcrumb', $breadcrumb);
        return $twig->render('events/show.twig');
    }

    /**
     * @return string
     */
    public static function create(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $twig = new AdHocTwig();

        $twig->enqueueScript('/js/geopicker.js');
        $twig->enqueueScript('/js/events/create.js');
        
        $twig->assign('breadcrumb', [
            ['title' => '🏠', 'link' => '/'],
            ['title' => 'Agenda', 'link' => '/events'],
            'Ajouter une date',
        ]);

        // filtrage de la date
        // $date = (string) $_GET['date'];
        // si date non valide : date du jour
        $date = '';
        if (isset($_GET['date'])) {
            $date = $_GET['date'];
        }
        if (!(preg_match("/^(\d{4})-(\d{2})-(\d{2})$/", $date, $regs) && checkdate((int) $regs[2], (int) $regs[3], (int) $regs[1]))) {
            $year  = date('Y');
            $month = date('m');
            $day   = date('d');
        } else {
            $year  = $regs[1];
            $month = $regs[2];
            $day   = $regs[3];
        }

        $hour   = 20;
        $minute = 30;

        $id_groupe = 0;
        if (isset($_GET['groupe'])) {
            $id_groupe = (int) $_GET['groupe'];
        }

        // défaut
        $id_country = 'FR';
        $id_region = '08'; // Île-de-France
        $id_departement = '91'; // Essonne
        $id_city = 91216; // "Épinay-sur-Orge
        $id_lieu = 1; // Salle G. Pompidou

        if (isset($_GET['lieu'])) {
            $id_lieu = (int) $_GET['lieu'];
            $lieu = Lieu::getInstance($id_lieu);
            $id_country = $lieu->getIdCountry();
            $id_region  = $lieu->getIdRegion();
            $id_departement = $lieu->getIdDepartement();
            $id_city = $lieu->getIdCity();
            $twig->assign('lieu', $lieu);
        }

        $id_structure = 0;
        if (isset($_GET['structure'])) {
            $id_structure = (int) $_GET['structure'];
        }

        // valeurs par défaut
        $data = [
            'id_country' => $id_country,
            'id_region' => $id_region,
            'id_departement' => $id_departement,
            'id_city' => $id_city,
            'id_lieu' => $id_lieu,
            'name'    => '',
            'date'    => [
                'year'   => $year,
                'month'  => $month,
                'day'    => $day,
                'hour'   => $hour,
                'minute' => $minute,
                'hourminute' => $hour . ':' . $minute,
                'date'   => $year . '-' . $month . '-' . $day,
            ],
            'file' => '',
            'flyer_url' => '',
            'groupes' => [
                $id_groupe,
                0,
                0,
                0,
                0,
            ],
            'styles' => [
                0,
                0,
                0,
            ],
            'structures' => [
               $id_structure,
               0,
               0,
            ],
            'text' => '',
            'price' => '',
            'facebook_event_id' => '',
            'more_event' => false,
        ];

        if (Tools::isSubmit('form-event-create')) {
            list($day, $month, $year) = explode('/', (string) Route::params('date'));
            $date       = $year . '-' . $month . '-' . $day;
            $hourminute = (string) Route::params('hourminute');
            $dt         = $date . ' ' . $hourminute . ':00';

            $data = [
                'name'       => (string) Route::params('name'),
                'id_lieu'    => (int) Route::params('id_lieu'),
                'date'       => $dt,
                'text'       => (string) Route::params('text'),
                'price'      => (string) Route::params('price'),
                'id_contact' => $_SESSION['membre']->getIdContact(),
                'online'     => true,
                'more_event' => (bool) Route::params('more_event'),
                'flyer_url'  => (string) Route::params('flyer_url'),
                'facebook_event_id' => (string) Route::params('facebook_event_id'),
            ];

            $errors = self::validateEventCreateForm($data);
            if (count($errors) === 0) {
                $event = (new Event())
                    ->setName($data['name'])
                    ->setIdLieu($data['id_lieu'])
                    ->setDate($data['date'])
                    ->setText($data['text'])
                    ->setPrice($data['price'])
                    ->setIdContact($data['id_contact'])
                    ->setOnline(true)
                    ->setFacebookEventId($data['facebook_event_id']);

                if ($event->save()) {
                    $importFlyer = false;
                    $tmpName = '';
                    if (is_uploaded_file($_FILES['flyer']['tmp_name'])) {
                        $importFlyer = true;
                        $tmpName = $_FILES['flyer']['tmp_name'];
                    } elseif (strlen($data['flyer_url']) > 0) {
                        if ($tmpContent = file_get_contents($data['flyer_url'])) {
                            $importFlyer = true;
                            $tmpName = tempnam('/tmp', 'import-flyer-event');
                            file_put_contents($tmpName, $tmpContent);
                        }
                    }

                    if ($importFlyer && file_exists($tmpName)) {
                        // création du répertoire de stockage si inexistant
                        if (!is_dir(Event::getBasePath())) {
                            mkdir(Event::getBasePath(), 0755, true);
                        }

                        $confEvent = Conf::getInstance()->get('event');
                        (new Image($tmpName))
                            ->setType(IMAGETYPE_JPEG)
                            ->setKeepRatio(true)
                            ->setMaxWidth($confEvent['max_width'])
                            ->setMaxHeight($confEvent['max_height'])
                            ->setDestFile(Event::getBasePath() . '/' . $event->getIdEvent() . '.jpg')
                            ->write();
                        unlink($tmpName);

                        foreach ($confEvent['thumb_width'] as $maxWidth) {
                            $event->genThumb($maxWidth);
                        }
                    }

                    foreach (Route::params('style') as $id_style) {
                        $id_style = (int) $id_style;
                        if ($id_style !== 0) {
                            $event->linkStyle($id_style);
                        }
                    }

                    foreach (Route::params('structure') as $_id_structure) {
                        if (intval($_id_structure) !== 0) {
                            $event->linkStructure(intval($_id_structure));
                        }
                    }

                    foreach (Route::params('groupe') as $_id_groupe) {
                        if (intval($id_groupe) !== 0) {
                            $event->linkGroupe(intval($id_groupe));
                        }
                    }

                    Log::info("Event create " . $event->getIdEvent());

                    if ((bool) Route::params('more-event')) {
                        Tools::redirect('/events/create?lieu=' . $event->getIdLieu());
                    } else {
                        Tools::redirect('/events?create=1&date=' . $date);
                    }
                } else {
                    // erreur create
                }
            } else {
                // erreur
            }
        }

        $twig->assign('data', $data);

        $twig->assign(
            'styles',
            Style::find(
                [
                    'order_by' => 'name',
                    'sort' => 'ASC',
                ]
            )
        );

        $twig->assign(
            'groupes',
            Groupe::find(
                [
                    'order_by' => 'name',
                    'sort' => 'ASC',
                ]
            )
        );

        $twig->assign(
            'structures',
            Structure::find(
                [
                    'order_by' => 'name',
                    'sort' => 'ASC',
                ]
            )
        );

        $twig->enqueueScriptVars(
            [
                'id_lieu' => $id_lieu,
                'id_country' => $id_country,
                'id_region' => $id_region,
                'id_departement' => $id_departement,
                'id_city' => $id_city,
            ]
        );

        return $twig->render('events/create.twig');
    }

    /**
     * @return string
     */
    public static function edit(): string
    {
        $id = (int) Route::params('id');

        Tools::auth(Membre::TYPE_STANDARD);

        $twig = new AdHocTwig();

        $twig->assign('breadcrumb', [
            ['title' => '🏠', 'link' => '/'],
            ['title' => 'Agenda', 'link' => '/events'],
            'Modifier une date',
        ]);

        $twig->enqueueScript('/js/geopicker.js');
        $twig->enqueueScript('/js/events/edit.js');

        try {
            $event = Event::getInstance($id);
        } catch (\Exception $e) {
            Route::setHttpCode(404);
            return '404';
        }

        $lieu = Lieu::getInstance($event->getIdLieu());

        $data = [
            'id' => $event->getIdEvent(),
            'name' => $event->getName(),
            'date' => [
                'year' => $event->getYear(),
                'month' => $event->getMonth(),
                'day' => $event->getDay(),
                'hour' => $event->getHour(),
                'minute' => $event->getMinute(),
                'date' => $event->getDate(),
                'hourminute' => $event->getHour() . ':' . $event->getMinute(),
            ],
            'text' => $event->getText(),
            'price' => $event->getPrice(),
            'flyer_url' => '',
            'groupes' => $event->getGroupes(),
            'styles' => $event->getStyles(),
            'structures' => $event->getStructures(),
            'facebook_event_id' => $event->getFacebookEventId(),
            'online' => $event->getOnline(),
        ];

        if (Tools::isSubmit('form-event-edit')) {
            list($day, $month, $year) = explode('/', (string) Route::params('date'));
            $date       = $year . '-' . $month . '-' . $day;
            $hourminute = Route::params('hourminute');
            $dt         = $date . ' ' . $hourminute . ':00';

            $data = [
                'id' => (int) Route::params('id'),
                'name' => (string) Route::params('name'),
                'id_lieu' => (int) Route::params('id_lieu'),
                'date' => $dt,
                'flyer' => Route::params('flyer'),
                'flyer_url' => (string) Route::params('flyer_url'),
                'text' => (string) Route::params('text'),
                'price' => (string) Route::params('price'),
                'facebook_event_id' => (string) Route::params('facebook_event_id'),
                'online' => (bool) Route::params('online'),
            ];

            $errors = self::validateEventEditForm($data);
            if (count($errors) === 0) {
                $event = Event::getInstance($data['id'])
                    ->setName($data['name'])
                    ->setIdLieu($data['id_lieu'])
                    ->setDate($data['date'])
                    ->setText($data['text'])
                    ->setPrice($data['price'])
                    ->setOnline($data['online'])
                    ->setFacebookEventId($data['facebook_event_id']);

                $event->save();

                $importFlyer = false;
                $tmpName = '';
                if (is_uploaded_file($_FILES['flyer']['tmp_name'])) {
                    $importFlyer = true;
                    $tmpName = $_FILES['flyer']['tmp_name'];
                } elseif (strlen($data['flyer_url']) > 0) {
                    if ($tmpContent = file_get_contents($data['flyer_url'])) {
                        $importFlyer = true;
                        $tmpName = tempnam('/tmp', 'import-flyer-event');
                        file_put_contents($tmpName, $tmpContent);
                    }
                }

                if ($importFlyer && file_exists($tmpName)) {
                    $confEvent = Conf::getInstance()->get('event');
                    (new Image($tmpName))
                        ->setType(IMAGETYPE_JPEG)
                        ->setKeepRatio(true)
                        ->setMaxWidth($confEvent['max_width'])
                        ->setMaxHeight($confEvent['max_height'])
                        ->setDestFile(Event::getBasePath() . '/' . $event->getIdEvent() . '.jpg')
                        ->write();
                    unlink($tmpName);

                    foreach ($confEvent['thumb_width'] as $maxWidth) {
                        $event->clearThumb($maxWidth);
                        $event->genThumb($maxWidth);
                    }
                }

                $event->unlinkStyles();
                foreach (Route::params('style') as $id_style) {
                    $id_style = (int) $id_style;
                    if ($id_style !== 0) {
                        $event->linkStyle($id_style);
                    }
                }

                $event->unlinkStructures();
                foreach (Route::params('structure') as $id_structure) {
                    $id_structure = (int) $id_structure;
                    if ($id_structure !== 0) {
                        $event->linkStructure($id_structure);
                    }
                }

                $event->unlinkGroupes();
                foreach (Route::params('groupe') as $id_groupe) {
                    $id_groupe = (int) $id_groupe;
                    if ($id_groupe !== 0) {
                        $event->linkGroupe($id_groupe);
                    }
                }

                $event->save(); // clear le cache après les liaisons externes

                Log::info("Event edit " . $event->getIdEvent());

                Tools::redirect('/events?edit=1&y=' . $year . '&m=' . $month . '&d=' . $day);
            } else {
                // errors à gérer
            }
        }

        $twig->assign('data', $data);
        $twig->assign('event', $event);
        $twig->assign('lieu', $lieu);

        $twig->assign(
            'styles',
            Style::find(
                [
                    'order_by' => 'name',
                    'sort' => 'ASC',
                ]
            )
        );

        $twig->assign(
            'groupes',
            Groupe::find(
                [
                    'order_by' => 'name',
                    'sort' => 'ASC',
                ]
            )
        );

        $twig->assign(
            'structures',
            Structure::find(
                [
                    'order_by' => 'name',
                    'sort' => 'ASC',
                ]
            )
        );

        $twig->enqueueScriptVars(
            [
                'id_lieu' => $lieu->getIdLieu(),
                'id_country' => $lieu->getIdCountry(),
                'id_region' => $lieu->getIdRegion(),
                'id_departement' => $lieu->getIdDepartement(),
                'id_city' => $lieu->getIdCity(),
            ]
        );

        return $twig->render('events/edit.twig');
    }

    /**
     * @return string ou HTTP:Redirect
     */
    public static function delete(): string
    {
        Tools::auth(Membre::TYPE_ADMIN);

        $twig = new AdHocTwig();

        $twig->assign('breadcrumb', [
            ['title' => '🏠', 'link' => '/'],
            ['title' => 'Agenda', 'link' => '/events'],
            'Supprimer une date',
        ]);

        try {
            $event = Event::getInstance((int) Route::params('id'));
        } catch (\Exception $e) {
            Route::setHttpCode(404);
            $twig->assign('unknown_event', true);
            return $twig->render('events/show.twig');
        }

        if (Tools::isSubmit('form-event-delete')) {
            if ($event->delete()) {
                Log::info("Event delete " . $event->getIdEvent());
                Tools::redirect('/events?delete=1');
            }
        }

        $twig->assign('event', $event);
        $twig->assign('lieu', Lieu::getInstance($event->getIdLieu()));

        return $twig->render('events/delete.twig');
    }

    /**
     * @return array<\stdClass>
     */
    public static function getEventsByLieu(): array
    {
        $id_lieu = (int) Route::params('l');

        if ($id_lieu === 0) {
            return [];
        }

        $events = Event::find(
            [
                'id_lieu' => $id_lieu,
                'online' => true,
                'order_by' => 'date',
                'sort' => 'ASC',
                'limit' => 100,
            ]
        );

        return array_map(
            function ($event) {
                return (object) [
                    'id' => $event->getIdEvent(),
                    'date' => $event->getDate(),
                    'name' => $event->getName(),
                ];
            },
            $events
        );
    }

    /**
     * Validation du formulaire de création event
     *
     * @param array<string,mixed> $data tableau des données
     *
     * @return array<string,true>
     */
    private static function validateEventCreateForm(array $data): array
    {
        $errors = [];

        // checker certains champs ?

        return $errors;
    }

    /**
     * Validation du formulaire de modification event
     *
     * @param array<string,mixed> $data tableau des données
     *
     * @return array<string,true>
     */
    private static function validateEventEditForm(array $data): array
    {
        $errors = [];

        // checker certains champs ?

        return $errors;
    }
}
