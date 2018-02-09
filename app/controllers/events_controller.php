<?php

define('NB_EVENTS_PER_PAGE', 100);

class Controller
{
    static function index()
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'agenda');

        $smarty->enqueue_script('/js/events.js');

        $trail = Trail::getInstance();
        $trail->addStep("Agenda");

        $smarty->assign('create', (bool) Route::params('create'));
        $smarty->assign('edit', (bool) Route::params('edit'));
        $smarty->assign('delete', (bool) Route::params('delete'));

        $year  = (int) Route::params('y');
        $month = (int) Route::params('m');
        $day   = (int) Route::params('d');
        $page  = (int) Route::params('page');

        if($year && $month && $day) {
            $datdeb = date('Y-m-d H:i:s', mktime(0, 0, 0, $month, $day, $year));
            $datfin = date('Y-m-d H:i:s', mktime(23, 59, 59, $month, $day, $year));
        } elseif($year && $month) {
            $datdeb = date('Y-m-d H:i:s', mktime(0, 0, 0, $month, 1, $year));
            $datfin = date('Y-m-d H:i:s', mktime(23, 59, 59, $month, 31, $year));
        } else {
            $datdeb = date('Y-m-d H:i:s');
            $datfin = date('Y-m-d H:i:s', mktime(23, 59, 59, date("m") + 1, date("d"), date("Y")));
        }

        $_events = Event::getEvents(array(
            'online' => true,
            'sort'   => 'date',
            'sens'   => 'ASC',
            'datdeb' => $datdeb,
            'datfin' => $datfin,
            'limit'  => 1000,
            'fetch_fb' => true,
        ));

        $nb_events = count($_events);
        $_events = array_slice($_events, $page * NB_EVENTS_PER_PAGE, NB_EVENTS_PER_PAGE);

        $events = [];
        foreach($_events as $event) {
            $_day = substr($event['date'], 0, 10);
            if(!array_key_exists($_day, $events)) {
                $events[$_day] = [];
            }
            $events[$_day][$event['id']] = [
                'tab' => $event,
                'obj' => Event::getInstance($event['id'])
            ];
        }

        $smarty->assign('title', "Agenda Concerts");
        $smarty->assign('description', "Agenda Concert");

        // sous forme de tableau et d'objet ...
        $smarty->assign('_events', $_events);
        $smarty->assign('events', $events);

        $smarty->assign('nb_items', $nb_events);
        $smarty->assign('nb_items_per_page', NB_EVENTS_PER_PAGE);
        $smarty->assign('page', $page);

        $smarty->assign('year', ($year ? $year : date('Y')));
        $smarty->assign('month', ($month ? $month : date('m')));
        $smarty->assign('day', ($day ? $day : date('d')));

        return $smarty->fetch('events/index.tpl');
    }

    static function fetch()
    {
        return '';
    }

    static function my()
    {
        return self::index();
    }

    static function show()
    {
        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        $smarty->enqueue_script('/js/events-show.js');

        $smarty->assign('js_gmap', true);
        $smarty->assign('menuselected', 'agenda');

        $trail = Trail::getInstance();
        $trail->addStep("Agenda", "/events/");

        try {
            $event = Event::getInstance((int) $id);
        } catch(Exception $e) {
            Route::set_http_code('404');
            $smarty->assign('unknown_event', true);
            return $smarty->fetch('events/show.tpl');
        }

        $smarty->assign('year', $event->getYear());
        $smarty->assign('month', $event->getMonth());
        $smarty->assign('day', $event->getDay());

        $smarty->assign('event', $event);

        $lieu = Lieu::getInstance($event->getIdLieu());
        $smarty->assign('lieu', $lieu);

        $smarty->assign('title', "♫ ". $event->getName());
        $smarty->assign('description', "Date : " . Date::mysql_datetime($event->getDate(), 'd/m/Y') . " | Lieu : " . $lieu->getName() . " " . $lieu->getAddress() . " " . $lieu->getCp() . " " . $lieu->getCity());

        // alerting
        if(Tools::isAuth()) {
            if(!Alerting::getIdByIds($_SESSION['membre']->getId(), 'e', $event->getId())) {
                $smarty->assign('alerting_sub_url', 'http://www.adhocmusic.com/alerting/sub?type=e&id_content='.$event->getId());
            } else {
                $smarty->assign('alerting_unsub_url', 'http://www.adhocmusic.com/alerting/unsub?type=e&id_content='.$event->getId());
            }
        } else {
            $smarty->assign('alerting_auth_url', 'http://www.adhocmusic.com/auth/login');
        }

        $smarty->assign('photos', Photo::getPhotos(array(
            'event'  => $event->getId(),
            'online' => true,
            'sort'   => 'random',
            'limit'  => 100,
        )));

        $smarty->assign('audios', Audio::getAudios(array(
            'event'  => $event->getId(),
            'online' => true,
            'sort'   => 'random',
            'limit'  => 100,
        )));

        $smarty->assign('videos', Video::getVideos(array(
            'event'  => $event->getId(),
            'online' => true,
            'sort'   => 'id',
            'sens'   => 'ASC',
            'limit'  => 100,
        )));

        $smarty->assign('comments', Comment::getComments(array(
           'type'       => 'e',
           'id_content' => $event->getId(),
           'online'     => true,
           'sort'       => 'created_on',
           'sens'       => 'ASC',
        )));

        $smarty->assign('jour', Date::mysql_datetime($event->getDate(), "d/m/Y"));
        $smarty->assign('heure', Date::mysql_datetime($event->getDate(), "H:i"));

        $smarty->assign('groupes', $event->getGroupes());

        if ($event->getIdContact()) {
            try {
                // le membre peut avoir été supprimé ...
                $membre = Membre::getInstance($event->getIdContact());
                $smarty->assign('membre', $membre);
            } catch (Exception $e) {
                mail('gus@adhocmusic.com', "[AD'HOC] Bug : evenement " . $event->getId() . " avec membre " . $event->getIdContact() . " introuvable", print_r($e, true));
            }
        }

        if (file_exists(ADHOC_ROOT_PATH . '/static/media/event/' . $event->getId() . '.jpg')) {
            $smarty->assign('flyer', true);
            $smarty->assign('og_image', $event->getFlyerUrl($event->getId()));
        }

        return $smarty->fetch('events/show.tpl');
    }

    static function create()
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $smarty = new AdHocSmarty();

        $smarty->enqueue_style('/css/jquery-ui.min.css');

        $smarty->enqueue_script('/js/jquery-ui.min.js');
        $smarty->enqueue_script('/js/jquery-ui-datepicker-fr.js');
        $smarty->enqueue_script('/js/geopicker.js');
        $smarty->enqueue_script('/js/events-create.js');

        $smarty->assign('menuselected', 'agenda');

        $trail = Trail::getInstance();
        $trail->addStep("Agenda", "/events/");
        $trail->addStep("Ajouter une date");

        // filtrage de la date
        // $date = (string) $_GET['date'];
        // si date non valide : date du jour
        $date = '';
        if(isset($_GET['date'])) {
            $date = $_GET['date'];
        }
        if(!(preg_match("/^(\d{4})-(\d{2})-(\d{2})$/", $date, $regs) && checkdate($regs[2], $regs[3], $regs[1]))) {
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
        if(isset($_GET['groupe'])) {
            $id_groupe = (int) $_GET['groupe'];
        }

        // défaut
        $id_country = 'FR';
        $id_region = 'A8';
        $id_departement = '91';
        $id_city = 91216;
        $id_lieu = 1;

        if(isset($_GET['lieu'])) {
            $id_lieu = (int) $_GET['lieu'];
            $lieu = Lieu::getInstance($id_lieu);
            $id_country = $lieu->getIdCountry();
            $id_region  = $lieu->getIdRegion();
            $id_departement = $lieu->getIdDepartement();
            $id_city = $lieu->getCity();
            $smarty->assign('lieu', $lieu);
        }

        $id_structure = 0;
        if(isset($_GET['structure'])) {
            $id_structure = (int) $_GET['structure'];
        }

        // valeurs par défaut
        $data = array(
            'id_country' => $id_country,
            'id_region' => $id_region,
            'id_departement' => $id_departement,
            'id_city' => $id_city,
            'id_lieu' => $id_lieu,
            'name'    => '',
            'date'    => array(
                'year'   => $year,
                'month'  => $month,
                'day'    => $day,
                'hour'   => $hour,
                'minute' => $minute,
                'hourminute' => $hour . ':' . $minute,
                'date'   => $year . '-' . $month . '-' . $day,
            ),
            'file' => '',
            'flyer_url' => '',
            'groupes' => array(
                0 => $id_groupe,
                1 => 0,
                2 => 0,
                3 => 0,
                4 => 0,
            ),
            'styles' => array(
                0 => 0,
                1 => 0,
                2 => 0,
            ),
            'structures' => array(
               0 => $id_structure,
               1 => 0,
               2 => 0,
            ),
            'text' => '',
            'price' => '',
            'facebook_event_id' => '',
            'facebook_event_create' => false,
            'more_event' => false,
        );

        if(Tools::isSubmit('form-event-create'))
        {
            list($day, $month, $year) = explode('/', (string) Route::params('date'));
            $date       = $year . '-' . $month . '-' . $day;
            $hourminute = (string) Route::params('hourminute');
            $dt         = $date . ' '. $hourminute . ':00';

            $data = array(
                'name'       => (string) Route::params('name'),
                'id_lieu'    => (int) Route::params('id_lieu'),
                'date'       => $dt,
                'flyers'     => Route::params('flyer'),
                'text'       => (string) Route::params('text'),
                'price'      => (string) Route::params('price'),
                'id_contact' => $_SESSION['membre']->getId(),
                'online'     => true,
                'more-event' => (bool) Route::params('more-event'),
                'flyer_url'  => (string) Route::params('flyer_url'),
                'facebook_event_id' => (string) Route::params('facebook_event_id'),
                'facebook_event_create' => (string) Route::params('facebook_event_create'),
            );

            if(self::_validate_form_event_create($data, $errors)) {

                $event = Event::init();
                $event->setName($data['name']);
                $event->setIdLieu($data['id_lieu']);
                $event->setDate($data['date']);
                $event->setText($data['text']);
                $event->setPrice($data['price']);
                $event->setIdContact($data['id_contact']);
                $event->setOnline(true);
                $event->setFacebookEventId($data['facebook_event_id']);
                $event->setCreatedNow();
                if($event->save()) {

                    if(is_uploaded_file($_FILES['flyer']['tmp_name'])) {
                        $img = new Image($_FILES['flyer']['tmp_name']);
                        $img->setType(IMAGETYPE_JPEG);
                        $img->setKeepRatio(true);
                        $img->setMaxWidth(1024);
                        $img->setMaxHeight(768);
                        $img->setDestFile(Event::getBasePath() . '/' . $event->getId() . '.jpg');
                        $img->write();
                        $img = '';
                    }

                    if($data['flyer_url']) {
                        $tmpname = tempnam('/tmp', 'import-flyer-event');
                        $handle = fopen($tmpname, "w");
                        fwrite($handle, file_get_contents($data['flyer_url']));
                        fclose($handle);

                        $img = new Image($tmpname);
                        $img->setType(IMAGETYPE_JPEG);
                        $img->setKeepRatio(true);
                        $img->setMaxWidth(1024);
                        $img->setMaxHeight(768);
                        $img->setDestFile(Event::getBasePath() . '/' . $event->getId() . '.jpg');
                        $img->write();
                        $img = '';

                        unlink($tmpname);
                    }

                    /*
                    foreach(Route::params('style') as $idx => $id_style) {
                        if($id_style != 0) {
                            $event->linkStyle($id_style, $idx + 1);
                        }
                    }
                    */

                    foreach(Route::params('structure') as $idx => $id_structure) {
                        if($id_structure != 0) {
                            $event->linkStructure($id_structure);
                        }
                    }

                    foreach(Route::params('groupe') as $idx => $id_groupe) {
                        if($id_groupe != 0) {
                            $event->linkGroupe($id_groupe);
                        }
                    }

                    Log::action(Log::ACTION_EVENT_CREATE, $event->getId());

                    if($data['facebook_event_create']) {
                        // créer l'évenement sur facebook
                    }

                    if((bool) Route::params('more-event')) {
                        Tools::redirect('/events/create?lieu=' . $event->getIdLieu());
                    } else {
                        Tools::redirect('/events/?create=1&date=' . $date);
                    }

                } else {

                    // erreur create

                }

            } else {

                // erreur

            }
        }

        $smarty->assign('data', $data);

        $smarty->assign('styles', Style::getHashTable());
        $smarty->assign('groupes', Groupe::getGroupes(array(
            'sort'  => 'name',
            'sens'  => 'ASC',
        )));
        $smarty->assign('structures', Structure::getStructures());

        return $smarty->fetch('events/create.tpl');
    }

    /**
     * validation du formulaire de création event
     *
     * @param array $data
     * @param array &$errors
     * @return bool
     */
    protected static function _validate_form_event_create($data, &$errors)
    {
        $errors = [];

        if (count($errors)) {
            return false;
        }
        return true;
    }

    static function edit()
    {
        $id = (int) Route::params('id');

        Tools::auth(Membre::TYPE_STANDARD);

        $trail = Trail::getInstance();
        $trail->addStep("Agenda", "/events/");
        $trail->addStep("Modifier une date");

        $smarty = new AdHocSmarty();

        $smarty->enqueue_style('/css/jquery-ui.min.css');

        $smarty->enqueue_script('/js/jquery-ui.min.js');
        $smarty->enqueue_script('/js/jquery-ui-datepicker-fr.js');
        $smarty->enqueue_script('/js/geopicker.js');
        $smarty->enqueue_script('/js/events-edit.js');

        $smarty->assign('menuselected', 'agenda');

        $event = Event::getInstance((int) $id);
        $lieu = Lieu::getInstance($event->getIdLieu());

        $data = array(
            'id' => $event->getId(),
            'name' => $event->getName(),
            'date' => array(
                'year' => $event->getYear(),
                'month' => $event->getMonth(),
                'day' => $event->getDay(),
                'hour' => $event->getHour(),
                'minute' => $event->getMinute(),
                'date' => $event->getDate(),
                'hourminute' => $event->getHour() . ':' . $event->getMinute(),
            ),
            'text' => $event->getText(),
            'price' => $event->getPrice(),
            'file' => '',
            'flyer_url' => '',
            'facebook_event_id' => $event->getFacebookEventId(),
            'facebook_event_create' => false,
            'online' => $event->getOnline(),
        );

        if(Tools::isSubmit('form-event-edit'))
        {
            list($day, $month, $year) = explode('/', (string) Route::params('date'));
            $date       = $year . '-' . $month . '-' . $day;
            $hourminute = Route::params('hourminute');
            $dt         = $date . ' ' . $hourminute . ':00';

            $data = array(
                'id' => (int) Route::params('id'),
                'name' => (string) Route::params('name'),
                'id_lieu' => (int) Route::params('id_lieu'),
                'date' => $dt,
                'flyer' => Route::params('flyer'),
                'flyer_url' => (string) Route::params('flyer_url'),
                'text' => (string) Route::params('text'),
                'price' => (string) Route::params('price'),
                'facebook_event_id' => (string) Route::params('facebook_event_id'),
                'facebook_event_create' => (string) Route::params('facebook_event_create'),
                'online' => (bool) Route::params('online'),
            );

            if(self::_validate_form_event_edit($data, $errors)) {

                $event = Event::getInstance($data['id']);
                $event->setName($data['name']);
                $event->setIdLieu($data['id_lieu']);
                $event->setDate($data['date']);
                $event->setText($data['text']);
                $event->setPrice($data['price']);
                $event->setOnline($data['online']);
                $event->setFacebookEventId($data['facebook_event_id']);
                $event->setModifiedNow();
                $event->save();

                if(is_uploaded_file($_FILES['flyer']['tmp_name'])) {
                    $img = new Image($_FILES['flyer']['tmp_name']);
                    $img->setType(IMAGETYPE_JPEG);
                    $img->setKeepRatio(true);
                    $img->setMaxWidth(1024);
                    $img->setMaxHeight(768);
                    $img->setDestFile(Event::getBasePath() . '/' . $event->getId() . '.jpg');
                    $img->write();
                    $img = "";

                    Event::invalidateFlyerInCache($event->getId(), '100', '100');
                    Event::invalidateFlyerInCache($event->getId(), '400', '400');
                }

                if($data['flyer_url']) {
                    $tmpname = tempnam('/tmp', 'import-flyer-event');
                    $handle = fopen($tmpname, "w");
                    fwrite($handle, file_get_contents($data['flyer_url']));
                    fclose($handle);

                    $img = new Image($tmpname);
                    $img->setType(IMAGETYPE_JPEG);
                    $img->setKeepRatio(true);
                    $img->setMaxWidth(1024);
                    $img->setMaxHeight(768);
                    $img->setDestFile(Event::getBasePath() . '/' . $event->getId() . '.jpg');
                    $img->write();
                    $img = '';

                    unlink($tmpname);

                    Event::invalidateFlyerInCache($event->getId(), '100', '100');
                    Event::invalidateFlyerInCache($event->getId(), '400', '400');
                }

                /*
                $event->unlinkStyles();
                foreach(Route::params('style') as $idx => $id_style) {
                    if($id_style != 0) {
                        $event->linkStyle($id_style, $idx + 1);
                    }
                }
                */

                $event->unlinkStructures();
                foreach(Route::params('structure') as $idx => $id_structure) {
                    if($id_structure != 0) {
                        $event->linkStructure($id_structure);
                    }
                }

                $event->unlinkGroupes();
                foreach(Route::params('groupe') as $idx => $id_groupe) {
                    if($id_groupe != 0) {
                        $event->linkGroupe($id_groupe);
                    }
                }

                Log::action(Log::ACTION_EVENT_EDIT, $event->getId());

                Tools::redirect('/events/?edit=1&y='.$year.'&m='.$month.'&d='.$day);

            } else {

                // errors à gérer
            }
        }

        $smarty->assign('data', $data);

        $smarty->assign('event', $event);
        $smarty->assign('lieu', $lieu);

        $smarty->assign('styles', Style::getHashTable());
        $smarty->assign('groupes', Groupe::getGroupes(array(
            'sort'  => 'name',
            'sens'  => 'ASC',
        )));
        $smarty->assign('structures', Structure::getStructures());

        return $smarty->fetch('events/edit.tpl');
    }

    /**
     * validation du formulaire de modification event
     *
     * @param array $data
     * @param array &$errors
     * @return bool
     */
    protected static function _validate_form_event_edit($data, &$errors)
    {
        $errors = [];

        if (count($errors)) {
            return false;
        }
        return true;
    }

    /**
     * @return string ou HTTP:Redirect
     */
    static function delete()
    {
        Tools::auth(Membre::TYPE_ADMIN);

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'agenda');

        $trail = Trail::getInstance();
        $trail->addStep("Agenda", "/events/");
        $trail->addStep("Supprimer une date");

        try {
            $event = Event::getInstance((int) Route::params('id'));
        } catch(Exception $e) {
            Route::set_http_code('404');
            $smarty->assign('unknown_event', true);
            return $smarty->fetch('events/show.tpl');
        }

        if(Tools::isSubmit('form-event-delete'))
        {
            if($event->delete()) {
                Log::action(Log::ACTION_EVENT_DELETE, $event->getId());
                Tools::redirect('/events/?delete=1');
            }
        }

        $smarty->assign('event', $event);
        $smarty->assign('lieu', Lieu::getInstance($event->getIdLieu()));

        return $smarty->fetch('events/delete.tpl');
    }

    /**
     * @return array
     */
    static function get_events_by_lieu()
    {
        $id_lieu = (int) Route::params('l');

        if (!$id_lieu) {
            return [];
        }

        return Event::getEvents([
            'online' => true,
            'lieu'   => $id_lieu,
            'sort'   => 'date',
            'sens'   => 'ASC',
            'limit'  => 100,
        ]);
    }
}
