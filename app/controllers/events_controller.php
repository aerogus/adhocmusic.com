<?php declare(strict_types=1);

use \Reference\Style;

final class Controller
{
    /**
     * @return string
     */
    static function index(): string
    {
        $smarty = new AdHocSmarty();

        $smarty->enqueue_script('/js/events/index.js');

        Trail::getInstance()
            ->addStep('Agenda');

        $smarty->assign('create', (bool) Route::params('create'));
        $smarty->assign('edit', (bool) Route::params('edit'));
        $smarty->assign('delete', (bool) Route::params('delete'));

        $year  = (int) Route::params('y');
        $month = (int) Route::params('m');
        $day   = (int) Route::params('d');

        if ($year && $month && $day) { // filtrage d'un jour donné
            $datdeb = date('Y-m-d H:i:s', mktime(0, 0, 0, $month, $day, $year)); // début de la journée
            $datfin = date('Y-m-d H:i:s', mktime(23, 59, 59, $month, $day, $year)); // fin de la journée
        } elseif ($year && $month) { // filtrage au mois
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

        $smarty->assign('title', "Agenda Concerts");
        $smarty->assign('description', "Agenda Concert");

        $smarty->assign('events', $events);

        $smarty->assign('year', ($year ? $year : date('Y')));
        $smarty->assign('month', ($month ? $month : date('m')));
        $smarty->assign('day', ($day ? $day : date('d')));

        return $smarty->fetch('events/index.tpl');
    }

    /**
     * Retourne le .ics (calendrier) pour l'événement
     * Dépendance composer de Eluceo\iCal
     *
     * @return string
     */
    static function ical(): string
    {
        $id = (int) Route::params('id');

        try {
            $event = Event::getInstance((int) $id);
        } catch (Exception $e) {
            Route::set_http_code(404);
            return 'not found';
        }

        $vCalendar = new \Eluceo\iCal\Component\Calendar('adhocmusic.com');
        $vEvent = new \Eluceo\iCal\Component\Event();
        $vEvent
            ->setDtStart(new \DateTime($event->getDate()))
            ->setDtEnd(new \DateTime($event->getDate()))
            ->setNoTime(true)
            ->setSummary($event->getName());
        $vCalendar->addComponent($vEvent);
        return $vCalendar->render();
    }

    /**
     * @return string
     */
    static function show(): string
    {
        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        $smarty->enqueue_style('/css/baguetteBox.min.css');

        $smarty->enqueue_script('/js/masonry-4.2.2.min.js');
        $smarty->enqueue_script('/js/imagesloaded-4.1.4.min.js');
        $smarty->enqueue_script('/js/baguetteBox-1.11.0.min.js');

        $smarty->enqueue_script('/js/events/show.js');

        $trail = Trail::getInstance()
            ->addStep('Agenda', '/events');

        try {
            $event = Event::getInstance((int) $id);
            $trail->addStep($event->getName());
        } catch (Exception $e) {
            Route::set_http_code(404);
            $trail->addStep("Évènement introuvable");
            $smarty->assign('unknown_event', true);
            return $smarty->fetch('events/show.tpl');
        }

        $smarty->assign('year', $event->getYear());
        $smarty->assign('month', $event->getMonth());
        $smarty->assign('day', $event->getDay());

        $smarty->assign('event', $event);

        $smarty->assign('title', "♫ ". $event->getName());
        $smarty->assign('description', "Date : " . Date::mysql_datetime($event->getDate(), 'd/m/Y') . " | Lieu : " . $event->getLieu()->getName() . " " . $event->getLieu()->getAddress() . " " . $event->getLieu()->getCity()->getCp() . " " . $event->getLieu()->getCity()->getName());

        $smarty->assign(
            'photos', Photo::find(
                [
                    'id_event' => $event->getIdEvent(),
                    'online' => true,
                    'limit' => 100,
                ]
            )
        );

        $smarty->assign(
            'audios', Audio::find(
                [
                    'id_event' => $event->getIdEvent(),
                    'online' => true,
                    'order_by' => 'random',
                    'limit' => 100,
                ]
            )
        );

        $smarty->assign(
            'videos', Video::find(
                [
                    'id_event' => $event->getIdEvent(),
                    'online' => true,
                    'order_by' => 'id_video',
                    'sort' => 'ASC',
                    'limit' => 100,
                ]
            )
        );

        $smarty->assign('jour', Date::mysql_datetime($event->getDate(), "d/m/Y"));
        $smarty->assign('heure', Date::mysql_datetime($event->getDate(), "H:i"));

        if ($event->getIdContact()) {
            try {
                // le membre peut avoir été supprimé ...
                $membre = Membre::getInstance($event->getIdContact());
                $smarty->assign('membre', $membre);
            } catch (Exception $e) {
                mail(DEBUG_EMAIL, "[AD'HOC] Bug : evenement " . $event->getId() . " avec membre " . $event->getIdContact() . " introuvable", print_r($e, true));
            }
        }

        if (file_exists(Event::getBasePath() . '/' . $event->getIdEvent() . '.jpg')) {
            $smarty->assign('og_image', $event->getThumbUrl());
        }

        return $smarty->fetch('events/show.tpl');
    }

    /**
     * @return string
     */
    static function create(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $smarty = new AdHocSmarty();

        $smarty->enqueue_style('/css/jquery-ui.min.css');

        $smarty->enqueue_script('/js/jquery-ui.min.js');
        $smarty->enqueue_script('/js/jquery-ui-datepicker-fr.js');
        $smarty->enqueue_script('/js/geopicker.js');
        $smarty->enqueue_script('/js/events/create.js');

        Trail::getInstance()
            ->addStep("Agenda", "/events")
            ->addStep("Ajouter une date");

        // filtrage de la date
        // $date = (string) $_GET['date'];
        // si date non valide : date du jour
        $date = '';
        if (isset($_GET['date'])) {
            $date = $_GET['date'];
        }
        if (!(preg_match("/^(\d{4})-(\d{2})-(\d{2})$/", $date, $regs) && checkdate($regs[2], $regs[3], $regs[1]))) {
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
            $smarty->assign('lieu', $lieu);
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
            $dt         = $date . ' '. $hourminute . ':00';

            $data = [
                'name'       => (string) Route::params('name'),
                'id_lieu'    => (int) Route::params('id_lieu'),
                'date'       => $dt,
                'text'       => (string) Route::params('text'),
                'price'      => (string) Route::params('price'),
                'id_contact' => $_SESSION['membre']->getId(),
                'online'     => true,
                'more_event' => (bool) Route::params('more_event'),
                'flyer_url'  => (string) Route::params('flyer_url'),
                'facebook_event_id' => (string) Route::params('facebook_event_id'),
            ];
            $errors = [];

            if (self::_validateEventCreateForm($data, $errors)) {

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
                    if (is_uploaded_file($_FILES['flyer']['tmp_name'])) {
                        $importFlyer = true;
                        $tmpName = $_FILES['flyer']['tmp_name'];
                    } elseif ($data['flyer_url']) {
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
                            ->setDestFile(Event::getBasePath() . '/' . $event->getId() . '.jpg')
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

                    foreach (Route::params('structure') as $id_structure) {
                        $id_structure = (int) $id_structure;
                        if ($id_structure !== 0) {
                            $event->linkStructure($id_structure);
                        }
                    }

                    foreach (Route::params('groupe') as $id_groupe) {
                        $id_groupe = (int) $id_groupe;
                        if ($id_groupe !== 0) {
                            $event->linkGroupe($id_groupe);
                        }
                    }

                    Log::action(Log::ACTION_EVENT_CREATE, $event->getId());

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

        $smarty->assign('data', $data);

        $smarty->assign(
            'styles', Style::find(
                [
                    'order_by' => 'name',
                    'sort' => 'ASC',
                ]
            )
        );

        $smarty->assign(
            'groupes', Groupe::find(
                [
                    'order_by' => 'name',
                    'sort' => 'ASC',
                ]
            )
        );

        $smarty->assign(
            'structures', Structure::find(
                [
                    'order_by' => 'name',
                    'sort' => 'ASC',
                ]
            )
        );

        $smarty->enqueue_script_vars(
            [
                'id_lieu' => $id_lieu,
                'id_country' => $id_country,
                'id_region' => $id_region,
                'id_departement' => $id_departement,
                'id_city' => $id_city,
            ]
        );

        return $smarty->fetch('events/create.tpl');
    }

    /**
     * @return string
     */
    static function edit(): string
    {
        $id = (int) Route::params('id');

        Tools::auth(Membre::TYPE_STANDARD);

        Trail::getInstance()
            ->addStep("Agenda", "/events")
            ->addStep("Modifier une date");

        $smarty = new AdHocSmarty();

        $smarty->enqueue_style('/css/jquery-ui.min.css');

        $smarty->enqueue_script('/js/jquery-ui.min.js');
        $smarty->enqueue_script('/js/jquery-ui-datepicker-fr.js');
        $smarty->enqueue_script('/js/geopicker.js');
        $smarty->enqueue_script('/js/events/edit.js');

        try {
            $event = Event::getInstance($id);
        } catch (Exception $e) {
            Route::set_http_code(404);
            return '404';
        }

        $lieu = Lieu::getInstance($event->getIdLieu());

        $data = [
            'id' => $event->getId(),
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
            $errors = [];

            if (self::_validateEventEditForm($data, $errors)) {

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
                if (is_uploaded_file($_FILES['flyer']['tmp_name'])) {
                    $importFlyer = true;
                    $tmpName = $_FILES['flyer']['tmp_name'];
                } elseif ($data['flyer_url']) {
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
                        ->setDestFile(Event::getBasePath() . '/' . $event->getId() . '.jpg')
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

                Log::action(Log::ACTION_EVENT_EDIT, $event->getId());

                Tools::redirect('/events?edit=1&y='.$year.'&m='.$month.'&d='.$day);

            } else {

                // errors à gérer

            }
        }

        $smarty->assign('data', $data);

        $smarty->assign('event', $event);
        $smarty->assign('lieu', $lieu);

        $smarty->assign(
            'styles', Style::find(
                [
                    'order_by' => 'name',
                    'sort' => 'ASC',
                ]
            )
        );

        $smarty->assign(
            'groupes', Groupe::find(
                [
                    'order_by' => 'name',
                    'sort' => 'ASC',
                ]
            )
        );

        $smarty->assign(
            'structures', Structure::find(
                [
                    'order_by' => 'name',
                    'sort' => 'ASC',
                ]
            )
        );

        $smarty->enqueue_script_vars(
            [
                'id_lieu' => $lieu->getIdLieu(),
                'id_country' => $lieu->getIdCountry(),
                'id_region' => $lieu->getIdRegion(),
                'id_departement' => $lieu->getIdDepartement(),
                'id_city' => $lieu->getIdCity(),
            ]
        );

        return $smarty->fetch('events/edit.tpl');
    }

    /**
     * @return string ou HTTP:Redirect
     */
    static function delete(): string
    {
        Tools::auth(Membre::TYPE_ADMIN);

        $smarty = new AdHocSmarty();

        Trail::getInstance()
            ->addStep("Agenda", "/events")
            ->addStep("Supprimer une date");

        try {
            $event = Event::getInstance((int) Route::params('id'));
        } catch (Exception $e) {
            Route::set_http_code(404);
            $smarty->assign('unknown_event', true);
            return $smarty->fetch('events/show.tpl');
        }

        if (Tools::isSubmit('form-event-delete')) {
            if ($event->delete()) {
                Log::action(Log::ACTION_EVENT_DELETE, $event->getId());
                Tools::redirect('/events?delete=1');
            }
        }

        $smarty->assign('event', $event);
        $smarty->assign('lieu', Lieu::getInstance($event->getIdLieu()));

        return $smarty->fetch('events/delete.tpl');
    }

    /**
     * @return array
     */
    static function get_events_by_lieu(): array
    {
        $id_lieu = (int) Route::params('l');

        if (!$id_lieu) {
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
            }, $events
        );
    }

    /**
     * Validation du formulaire de création event
     *
     * @param array $data   tableau des données
     * @param array $errors tableau des erreurs (par référence)
     *
     * @return bool
     */
    private static function _validateEventCreateForm(array $data, array &$errors): bool
    {
        if (count($errors)) {
            return false;
        }
        return true;
    }

    /**
     * Validation du formulaire de modification event
     *
     * @param array $data   tableau des données
     * @param array $errors tableau des erreurs (par référence)
     *
     * @return bool
     */
    private static function _validateEventEditForm(array $data, array &$errors): bool
    {
        if (count($errors)) {
            return false;
        }
        return true;
    }
}
