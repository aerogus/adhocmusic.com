<?php

class Controller
{
    static function index()
    {
        $smarty = new AdHocSmarty();

        $lat = $_SESSION['lat'];
        $lng = $_SESSION['lng'];

        $trail = Trail::getInstance();
        $trail->addStep("Lieux de diffusion", "/lieux/");

        $lieux_proches = Lieu::fetchLieuxByRadius([
            'lat'      => $lat,
            'lng'      => $lng,
            'distance' => 5000,
            'sort'     => 'rand',
            'limit'    => 25,
        ]);

        $lieux_proches = array_slice($lieux_proches, 0, 5);

        $smarty->assign('lat', $lat);
        $smarty->assign('lng', $lng);
        $smarty->assign('my_geocode', $lat . ', ' . $lng);
        $smarty->assign('lieux', $lieux_proches);

        $comments = Comment::getComments([
            'type' => 'l',
            'sort' => 'id',
            'sens' => 'DESC',
            'debut' => 0,
            'limit' => 5,
        ]);
        $smarty->assign('comments', $comments);

        return $smarty->fetch('lieux/index.tpl');
    }

    static function my()
    {
        $page = (int) Route::params('page');

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Lieux de diffusion", "/lieux/");
        $trail->addStep("Mes lieux");

        $smarty->assign('lieux', Lieu::getLieux());

        $smarty->assign('nb_items', Lieu::getLieuxCount());
        $smarty->assign('nb_items_per_page', 200);
        $smarty->assign('page', $page);

        return $smarty->fetch('lieux/my.tpl');

    }

    static function show()
    {
        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        $smarty->assign('create', (bool) Route::params('create'));
        $smarty->assign('edit', (bool) Route::params('edit'));

        try {
            $lieu = Lieu::getInstance($id);
        } catch (Exception $e) {
            Route::set_http_code('404');
            $smarty->assign('unknown_lieu', true);
            return $smarty->fetch('lieux/show.tpl');
        }

        $smarty->enqueue_script_var('lieu', [
            'lat' => number_format($lieu->getLat(), 6, '.', ''),
            'lng' => number_format($lieu->getLng(), 6, '.', ''),
            'name' => $lieu->getName()
        ]); 
        $smarty->enqueue_script('/js/lieux-show.js');
        $smarty->enqueue_script('https://maps.googleapis.com/maps/api/js?key=' . GOOGLE_MAPS_API_KEY . '&callback=adhocLieuInitMap');

        if (!$lieu->getLat() && !$lieu->getLng()) {
            $smarty->assign('geocode', true);
            $smarty->assign('geocode_id_lieu', $lieu->getId());
            $smarty->assign('geocode_address', $lieu->getAddress() . ' ' . $lieu->getCp() . ' ' . $lieu->getCity());
        }

        $smarty->assign('og_image', $lieu->getMapUrl('160x160', 15, 'roadmap'));

        $smarty->assign('lieu', $lieu);

        $trail = Trail::getInstance();
        $trail->addStep("Lieux de diffusion", "/lieux/");
        $trail->addStep(WorldCountry::getName($lieu->getIdCountry()), "/lieux/?c=" . $lieu->getIdCountry());
        $trail->addStep(WorldRegion::getName($lieu->getIdCountry(), $lieu->getIdRegion()), "/lieux/?c=" . $lieu->getIdCountry() . "&r=" . $lieu->getIdRegion());
        if ($lieu->getIdCountry() === 'FR') {
            $trail->addStep(Departement::getName($lieu->getIdDepartement()), "/lieux/?c=" . $lieu->getIdCountry() . "&r=" . $lieu->getIdRegion() . "&d=" . $lieu->getIdDepartement());
        }
        $trail->addStep($lieu->getName());

        $smarty->assign('title', $lieu->getName() . " - " . $lieu->getAddress() . " - " . $lieu->getCp() . " " . $lieu->getCity());
        $smarty->assign('description', $lieu->getName() . " - " . $lieu->getAddress() . " - " . $lieu->getCp() . " " . $lieu->getCity());

        $smarty->assign('events_f', Event::getEvents([
            'online' => true,
            'limit'  => 500,
            'datdeb' => date('Y-m-d H:i:s'),
            'lieu'   => $lieu->getId(),
            'sort'   => 'date',
            'sens'   => 'ASC',
        ]));

        $smarty->assign('events_p', Event::getEvents([
            'online' => true,
            'limit'  => 500,
            'datfin' => date('Y-m-d H:i:s'),
            'lieu'   => $lieu->getId(),
            'sort'   => 'date',
            'sens'   => 'DESC',
        ]));

        $smarty->assign('photos', Photo::getPhotos([
            'lieu'   => $lieu->getId(),
            'online' => true,
            'limit'  => 100,
            'sort'   => 'random',
        ]));

        $smarty->assign('audios', Audio::getAudios([
            'lieu'   => $lieu->getId(),
            'online' => true,
            'sort'   => 'random',
        ]));

        $smarty->assign('videos', Video::getVideos([
            'lieu'   => $lieu->getId(),
            'online' => true,
            'limit'  => 80,
            'sort'   => 'random',
        ]));

        $smarty->assign('comments', Comment::getComments([
            'type'       => 'l',
            'id_content' => $lieu->getId(),
            'online'     => true,
            'sort'       => 'created_on',
            'sens'       => 'ASC',
        ]));

        // alerting
        if (Tools::isAuth()) {
            if (!Alerting::getIdByIds($_SESSION['membre']->getId(), 'l', $lieu->getId())) {
                $smarty->assign('alerting_sub_url', 'https://www.adhocmusic.com/alerting/sub?type=l&id_content='.$lieu->getId());
            } else {
                $smarty->assign('alerting_unsub_url', 'https://www.adhocmusic.com/alerting/unsub?type=l&id_content='.$lieu->getId());
            }
        } else {
            $smarty->assign('alerting_auth_url', 'https://www.adhocmusic.com/auth/login');
        }

        return $smarty->fetch('lieux/show.tpl');
    }

    static function create()
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $smarty = new AdHocSmarty();

        $smarty->enqueue_script('/js/geopicker.js');
        $smarty->enqueue_script('/js/lieux-create.js');

        if (Tools::isSubmit('form-lieu-create'))
        {
            //$city = City::getInstance((int) Route::params('id_city'));

            $data = [
                'id_country'     => (string) Route::params('id_country'),
                'id_region'      => (string) Route::params('id_region'),
                'id_departement' => (string) Route::params('id_departement'),
                'id_city'        => (int) Route::params('id_city'),
                'id_type'        => (int) Route::params('id_type'),
                'name'           => (string) Route::params('name'),
                'address'        => (string) Route::params('address'),
                'cp'             => City::getCp((int) Route::params('id_city')),
                'city'           => City::getName((int) Route::params('id_city')),
                'text'           => (string) Route::params('text'),
                'tel'            => (string) Route::params('tel'),
                'fax'            => (string) Route::params('fax'),
                'email'          => (string) Route::params('email'),
                'site'           => (string) Route::params('site'),
                'lat'            => (float) Route::params('lat'),
                'lng'            => (float) Route::params('lng'),
                'id_contact'     => $_SESSION['membre']->getId(),
            ];

            if (self::_validate_form_lieu_create($data, $errors))
            {
                $lieu = Lieu::init();
                $lieu->setIdCountry($data['id_country']);
                $lieu->setIdRegion($data['id_region']);
                $lieu->setIdDepartement($data['id_departement']);
                $lieu->setIdCity($data['id_city']);
                $lieu->setIdType($data['id_type']);
                $lieu->setName($data['name']);
                $lieu->setAddress($data['address']);
                $lieu->setCp($data['cp']);
                $lieu->setCity($data['city']);
                $lieu->setText($data['text']);
                $lieu->setTel($data['tel']);
                $lieu->setFax($data['fax']);
                $lieu->setEmail($data['email']);
                $lieu->setSite($data['site']);
                $lieu->setIdContact($data['id_contact']);
                $lieu->setCreatedNow();
                $lieu->save();

                /* récupération des coordonnées si non précisées */
//                if (!$lieu->getLng() || !$lieu->getLat()) {
                    $addr = $lieu->getAddress() . ' ' . $lieu->getCp() . ' ' . $lieu->getCity();
                    if ($coords = GoogleMaps::getGeocode($addr)) {
                        $lieu->setLat($coords['lat']);
                        $lieu->setLng($coords['lng']);
                        $lieu->save();
                    }
//                }

                /* Upload de la photo */
                if (is_uploaded_file($_FILES['photo']['tmp_name'])) {
                    $objImg = new Image($_FILES['photo']['tmp_name']);
                    $objImg->setType(IMAGETYPE_JPEG);
                    $objImg->setMaxWidth(400);
                    $objImg->setMaxHeight(400);
                    $objImg->setDestFile(Lieu::getBasePath() . '/' . $lieu->getId() . '.jpg');
                    $objImg->write();
                    $objImg = "";
                }

                Log::action(Log::ACTION_LIEU_CREATE, $lieu->getId());

                Tools::redirect('/lieux/' . $lieu->getId() . '?create=1');
            }
            else
            {
                // erreurs
            }
        }

        $trail = Trail::getInstance();
        $trail->addStep("Lieux de diffusion", "/lieux/");
        $trail->addStep("Ajouter");

        $smarty->assign('types_lieu', Lieu::getTypes());

        return $smarty->fetch('lieux/create.tpl');
    }

    /**
     * validation du formulaire de création lieu
     * @param array $data
     * @param array &$errors
     * @return bool
     */
    protected static function _validate_form_lieu_create($data, &$errors)
    {
        $errors = [];
        if (empty($data['name'])) {
            $errors['name'] = true;
        }
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
        $trail->addStep("Lieux de diffusion", "/lieux/");
        $trail->addStep("Modifier");

        $smarty = new AdHocSmarty();

        $smarty->enqueue_script('/js/geopicker.js');
        $smarty->enqueue_script('/js/lieux-edit.js');

        try {
            $lieu = Lieu::getInstance($id);
            $smarty->assign('lieu', $lieu);
            $smarty->assign('types_lieu', Lieu::getTypes());
        } catch (Exception $e) {
            Route::set_http_code('404');
            $smarty->assign('unknown_lieu', true);
            return $smarty->fetch('lieux/edit.tpl');
        }

        if (Tools::isSubmit('form-lieu-edit'))
        {
            $data = [
                'id'             => (int) Route::params('id'),
                'id_country'     => (string) Route::params('id_country'),
                'id_region'      => (string) Route::params('id_region'),
                'id_departement' => (string) Route::params('id_departement'),
                'id_city'        => (int) Route::params('id_city'),
                'id_type'        => (int) Route::params('id_type'),
                'name'           => (string) Route::params('name'),
                'address'        => (string) Route::params('address'),
                'cp'             => City::getCp((int) Route::params('id_city')),
                'city'           => City::getName((int) Route::params('id_city')),
                'text'           => (string) Route::params('text'),
                'tel'            => (string) Route::params('tel'),
                'fax'            => (string) Route::params('fax'),
                'email'          => (string) Route::params('email'),
                'site'           => (string) Route::params('site'),
                'id_contact'     => $_SESSION['membre']->getId(),
                'lat'            => (string) Route::params('lat'),
                'lng'            => (string) Route::params('lng'),
            ];

            if (self::_validate_form_lieu_edit($data, $errors))
            {
                $lieu = Lieu::getInstance($data['id']);
                $lieu->setIdCountry($data['id_country']);
                $lieu->setIdRegion($data['id_region']);
                $lieu->setIdDepartement($data['id_departement']);
                $lieu->setIdCity($data['id_city']);
                $lieu->setIdType($data['id_type']);
                $lieu->setName($data['name']);
                $lieu->setAddress($data['address']);
                $lieu->setCp($data['cp']);
                $lieu->setCity($data['city']);
                $lieu->setText($data['text']);
                $lieu->setTel($data['tel']);
                $lieu->setFax($data['fax']);
                $lieu->setEmail($data['email']);
                $lieu->setSite($data['site']);
                $lieu->setLat($data['lat']);
                $lieu->setLng($data['lng']);
                $lieu->setModifiedNow();

                if ($lieu->save())
                {
                    /* récupération des coordonnées si non précisées */
//                    if (!$lieu->getLng() || !$lieu->getLat()) {
                        $addr = $lieu->getAddress() . ' ' . $lieu->getCp() . ' ' . $lieu->getCity();
                        if ($coords = GoogleMaps::getGeocode($addr)) {
                            $lieu->setLat($coords['lat']);
                            $lieu->setLng($coords['lng']);
                            $lieu->save();
                        }
//                    }

                    /* Upload de la photo */
                    if (is_uploaded_file($_FILES['photo']['tmp_name'])) {
                        $objImg = new Image($_FILES['photo']['tmp_name']);
                        $objImg->setType(IMAGETYPE_JPEG);
                        $objImg->setMaxWidth(400);
                        $objImg->setMaxHeight(400);
                        $objImg->setDestFile(Lieu::getBasePath() . '/' . $lieu->getId() . '.jpg');
                        $objImg->write();
                        $objImg = "";
                    }

                    Log::action(Log::ACTION_LIEU_EDIT, $lieu->getId());

                    Tools::redirect('/lieux/' . $lieu->getId() . '?edit=1');
                }
            } else {
                // erreurs
            }
        }

        return $smarty->fetch('lieux/edit.tpl');
    }

    /**
     * validation du formulaire de modification membre
     * @param array $data
     * @param array &$errors
     * @return bool
     */
    protected static function _validate_form_lieu_edit($data, &$errors)
    {
        $errors = [];
        if (empty($data['name'])) {
            $errors['name'] = true;
        }
        if (count($errors)) {
            return false;
        }
        return true;
    }

    static function delete()
    {
        Tools::auth(Membre::TYPE_ADMIN);

        $id = (int) Route::params('id');

        $trail = Trail::getInstance();
        $trail->addStep("Lieux de diffusion", "/lieux/");
        $trail->addStep("Supprimer");

        $smarty = new AdHocSmarty();

        try {
            $lieu = Lieu::getInstance($id);
            $smarty->assign('lieu', $lieu);
        } catch (Exception $e) {
            Route::set_http_code('404');
            $smarty->assign('unknown_lieu', true);
            return $smarty->fetch('lieux/delete.tpl');
        }

        if (Tools::isSubmit('form-lieu-delete'))
        {
            if ($lieu->delete()) {
                Log::action(Log::ACTION_LIEU_DELETE, $lieu->getId());
                Tools::redirect('/lieux/?delete=1');
            }
        }

        return $smarty->fetch('lieux/delete.tpl');
    }

    static function geocode()
    {
        $q  = (string) Route::params('q');
        return GoogleMaps::getGeocode($q);
    }

    static function fetch()
    {
        $mode  = (string) Route::params('mode'); // radius|boundary|admin
        $lat   = (float) Route::params('lat');
        $lng   = (float) Route::params('lng');
        if (!$lat) {
            $lat = $_SESSION['lat'];
        }
        if ($lng) {
            $lng = $_SESSION['lng'];
        }
        $limit = (int) Route::params('limit');
        if (!$limit) {
            $limit = 20;
        }

        switch ($mode)
        {
            case 'radius':
                $distance = (int) Route::params('distance');
                return Lieu::fetchLieuxByRadius([
                    'lat'      => $lat,
                    'lng'      => $lng,
                    'distance' => $distance,
                    'order'    => 'distance',
                    'limit'    => $limit,
                ]);
                break;

            case 'boundary':
                $lat_min = (float) Route::params('lat_min');
                $lat_max = (float) Route::params('lat_max');
                $lng_min = (float) Route::params('lng_min');
                $lng_max = (float) Route::params('lng_max');
                $points  = (string) Route::params('points');
                if ($points) {
                    list($lat_min, $lng_min, $lat_max, $lng_max) = explode(',', $points);
                    if ($lat_min > $lat_max) {
                        $lat_tmp = $lat_max;
                        $lat_max = $lat_min;
                        $lat_min = $lat_tmp;
                    }
                    if ($lng_min > $lng_max) {
                        $lng_tmp = $lng_max;
                        $lng_max = $lng_min;
                        $lng_min = $lng_tmp;
                    }
                }
                return Lieu::fetchLieuxByBoundary([
                    'lat'     => $lat,
                    'lng'     => $lng,
                    'lat_min' => $lat_min,
                    'lat_max' => $lat_max,
                    'lng_min' => $lng_min,
                    'lng_max' => $lng_max,
                    'limit'   => $limit,
                ]);
                break;

            case 'admin':
                $id_country     = (string) Route::params('id_country');
                $id_region      = (string) Route::params('id_region');
                $id_departement = (string) Route::params('id_departement');
                return Lieu::fetchLieuxByAdmin([
                    'lat'            => $lat,
                    'lng'            => $lng,
                    'id_country'     => $id_country,
                    'id_region'      => $id_region,
                    'id_departement' => $id_departement,
                    'limit'          => $limit,
                ]);
                break;

            default:
                return [];
                break;
        }
    }
}
