<?php declare(strict_types=1);

use \Reference\City;
use \Reference\Departement;
use \Reference\LieuType;
use \Reference\WorldCountry;
use \Reference\WorldRegion;

/**
 *
 */
final class Controller
{
    /**
     * @return string
     */
    static function index(): string
    {
        $smarty = new AdHocSmarty();

        $smarty->enqueue_script('/js/lieux/index.js');

        Trail::getInstance()
            ->addStep('Lieux', '/lieux');

        $lieux = [];

        $regions = WorldRegion::find(
            [
                'id_country' => 'FR',
                'order_by' => 'name',
                'sort' => 'ASC'
            ]
        );
        $smarty->assign('regions', $regions);

        $departements = [];
        $_departements = Departement::find(
            [
                'id_country' => 'FR',
                'order_by' => 'name',
                'sort' => 'ASC'
            ]
        );
        foreach ($_departements as $departement) {
            if (!array_key_exists($departement->getIdRegion(), $lieux)) {
                $lieux[$departement->getIdRegion()] = [];
            }
            if (!array_key_exists($departement->getIdDepartement(), $lieux[$departement->getIdRegion()])) {
                $lieux[$departement->getIdRegion()][$departement->getIdDepartement()] = [];
            }
            if (!array_key_exists($departement->getIdRegion(), $departements)) {
                $departements[$departement->getIdRegion()] = [];
            }
            $departements[$departement->getIdRegion()][] = $departement;
        }

        $smarty->assign('departements', $departements);

        $_lieux = Lieu::find(
            [
                'id_country' => 'FR',
                'order_by' => 'id_city',
                'sort' => 'ASC'
            ]
        );

        foreach ($_lieux as $lieu) {
            $lieux[$lieu->getIdRegion()][$lieu->getIdDepartement()][] = $lieu;
        }

        $smarty->assign('lieux', $lieux);

        return $smarty->fetch('lieux/index.tpl');
    }

    /**
     * @return string
     */
    static function my(): string
    {
        $page = (int) Route::params('page');

        $smarty = new AdHocSmarty();

        Trail::getInstance()
            ->addStep("Lieux", "/lieux")
            ->addStep("Mes lieux");

        $smarty->assign('lieux', Lieu::findAll());

        $smarty->assign('nb_items', Lieu::count());
        $smarty->assign('nb_items_per_page', 200);
        $smarty->assign('page', $page);

        return $smarty->fetch('lieux/my.tpl');

    }

    /**
     * @return string
     */
    static function show(): string
    {
        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        $smarty->assign('create', (bool) Route::params('create'));
        $smarty->assign('edit', (bool) Route::params('edit'));

        try {
            $lieu = Lieu::getInstance($id);
        } catch (Exception $e) {
            Route::set_http_code(404);
            $smarty->assign('unknown_lieu', true);
            return $smarty->fetch('lieux/show.tpl');
        }

        $smarty->enqueue_style('/css/baguetteBox-1.11.1.min.css');
        $smarty->enqueue_style('/css/leaflet.css');

        $smarty->enqueue_script('/js/masonry-4.2.2.min.js');
        $smarty->enqueue_script('/js/imagesloaded-4.1.4.min.js');
        $smarty->enqueue_script('/js/baguetteBox-1.11.1.min.js');
        $smarty->enqueue_script('/js/leaflet.js');

        $smarty->enqueue_script_vars(
            [
                'lat' => number_format($lieu->getLat(), 6, '.', ''),
                'lng' => number_format($lieu->getLng(), 6, '.', ''),
                'name' => $lieu->getName()
            ]
        );
        $smarty->enqueue_script('/js/lieux/show.js');

        if (!$lieu->getLat() && !$lieu->getLng()) {
            $smarty->assign('geocode', true);
            $smarty->assign('geocode_id_lieu', $lieu->getId());
            $smarty->assign('geocode_address', $lieu->getAddress() . ' ' . $lieu->getCity()->getCp() . ' ' . $lieu->getCity()->getName());
        }

        $smarty->assign('lieu', $lieu);

        $trail = Trail::getInstance()
            ->addStep("Lieux", "/lieux")
            ->addStep($lieu->getName());

        $smarty->assign('title', $lieu->getName() . " - " . $lieu->getAddress() . " - " . $lieu->getCity()->getCp() . " " . $lieu->getCity()->getName());
        $smarty->assign('description', $lieu->getName() . " - " . $lieu->getAddress() . " - " . $lieu->getCity()->getCp() . " " . $lieu->getCity()->getName());

        $smarty->assign(
            'events_f', Event::find(
                [
                    'id_lieu' => $lieu->getIdLieu(),
                    'online' => true,
                    'datdeb' => date('Y-m-d H:i:s'),
                    'order_by' => 'date',
                    'sort' => 'ASC',
                    'limit' => 500,
                ]
            )
        );

        $smarty->assign(
            'events_p', Event::find(
                [
                    'id_lieu' => $lieu->getIdLieu(),
                    'online' => true,
                    'datfin' => date('Y-m-d H:i:s'),
                    'order_by' => 'date',
                    'sort' => 'DESC',
                    'limit' => 500,
                ]
            )
        );

        $smarty->assign(
            'photos', Photo::find(
                [
                    'id_lieu' => $lieu->getIdLieu(),
                    'online' => true,
                    'order_by' => 'random',
                    'limit' => 100,
                ]
            )
        );

        $smarty->assign(
            'audios', Audio::find(
                [
                    'id_lieu' => $lieu->getIdLieu(),
                    'online' => true,
                    'order_by' => 'random',
                ]
            )
        );

        $smarty->assign(
            'videos', Video::find(
                [
                    'id_lieu' => $lieu->getIdLieu(),
                    'online' => true,
                    'order_by' => 'random',
                    'limit' => 80,
                ]
            )
        );

        // alerting
        /*
        if (Tools::isAuth()) {
            if (!Alerting::getIdByIds($_SESSION['membre']->getId(), 'l', $lieu->getId())) {
                $smarty->assign('alerting_sub_url', HOME_URL . '/alerting/sub?type=l&id_content='.$lieu->getId());
            } else {
                $smarty->assign('alerting_unsub_url', HOME_URL . '/alerting/unsub?type=l&id_content='.$lieu->getId());
            }
        } else {
            $smarty->assign('alerting_auth_url', HOME_URL .  '/auth/auth');
        }
        */

        return $smarty->fetch('lieux/show.tpl');
    }

    /**
     * @return string
     */
    static function create(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $smarty = new AdHocSmarty();

        $smarty->enqueue_script('/js/geopicker.js');
        $smarty->enqueue_script('/js/lieux/create.js');

        if (Tools::isSubmit('form-lieu-create')) {

            $data = [
                'id_country'     => (string) Route::params('id_country'),
                'id_region'      => (string) Route::params('id_region'),
                'id_departement' => (string) Route::params('id_departement'),
                'id_city'        => (int) Route::params('id_city'),
                'id_type'        => (int) Route::params('id_type'),
                'name'           => (string) Route::params('name'),
                'address'        => (string) Route::params('address'),
                'text'           => (string) Route::params('text'),
                'site'           => (string) Route::params('site'),
                'id_contact'     => $_SESSION['membre']->getId(),
                'lat'            => (float) Route::params('lat'),
                'lng'            => (float) Route::params('lng'),
            ];
            $errors = [];

            if (self::_validateLieuCreateForm($data, $errors)) {

                $lieu = (new Lieu())
                    ->setIdCountry($data['id_country'])
                    ->setIdRegion($data['id_region'])
                    ->setIdDepartement($data['id_departement'])
                    ->setIdCity($data['id_city'])
                    ->setIdType($data['id_type'])
                    ->setName($data['name'])
                    ->setAddress($data['address'])
                    ->setText($data['text'])
                    ->setSite($data['site'])
                    ->setIdContact($data['id_contact'])
                    ->setLat($data['lat'])
                    ->setLng($data['lng']);

                $lieu->save();

                // @TODO geocoding via openstreetmap ?
                // calcul des coordonnées
                /*
                $addr = $lieu->getAddress() . ' ' . $lieu->getCity()->getCp() . ' ' . $lieu->getCity()->getName();
                if ($coords = OSM::getGeocode($addr)) { // TODO nouvelle clé API Google (ou autre service de Geocoding !)
                    if ($coords['status'] === 'OK') {
                        $lieu->setLat($coords['lat']);
                        $lieu->setLng($coords['lng']);
                        $lieu->save();
                    }
                }
                */

                /* Upload de la photo */
                if (is_uploaded_file($_FILES['photo']['tmp_name'])) {
                    (new Image($_FILES['photo']['tmp_name']))
                        ->setType(IMAGETYPE_JPEG)
                        ->setMaxWidth(400)
                        ->setMaxHeight(400)
                        ->setDestFile(Lieu::getBasePath() . '/' . $lieu->getId() . '.jpg')
                        ->write();
                }

                Log::action(Log::ACTION_LIEU_CREATE, $lieu->getId());

                Tools::redirect('/lieux/' . $lieu->getId() . '?create=1');
            } else {
                // erreurs
            }
        }

        Trail::getInstance()
            ->addStep("Lieux", "/lieux")
            ->addStep("Ajouter");

        $smarty->assign('lieu_types', LieuType::findAll());

        $smarty->enqueue_script_vars(
            [
                'id_lieu' => 0,
                'id_country' => 'FR',
                'id_region' => '08',
                'id_departement' => '91',
                'id_city' => 91216
            ]
        );

        return $smarty->fetch('lieux/create.tpl');
    }

    /**
     * @return string
     */
    static function edit(): string
    {
        $id = (int) Route::params('id');

        Tools::auth(Membre::TYPE_STANDARD);

        Trail::getInstance()
            ->addStep("Lieux", "/lieux")
            ->addStep("Modifier");

        $smarty = new AdHocSmarty();

        $smarty->enqueue_script('/js/geopicker.js');
        $smarty->enqueue_script('/js/lieux/edit.js');

        try {
            $lieu = Lieu::getInstance($id);
            $smarty->assign('lieu', $lieu);
            $smarty->assign('lieu_types', LieuType::findAll());
        } catch (Exception $e) {
            Route::set_http_code(404);
            $smarty->assign('unknown_lieu', true);
            return $smarty->fetch('lieux/edit.tpl');
        }

        if (Tools::isSubmit('form-lieu-edit')) {

            $data = [
                'id'             => (int) Route::params('id'),
                'id_country'     => (string) Route::params('id_country'),
                'id_region'      => (string) Route::params('id_region'),
                'id_departement' => (string) Route::params('id_departement'),
                'id_city'        => (int) Route::params('id_city'),
                'id_type'        => (int) Route::params('id_type'),
                'name'           => (string) Route::params('name'),
                'address'        => (string) Route::params('address'),
                'text'           => (string) Route::params('text'),
                'site'           => (string) Route::params('site'),
                'id_contact'     => $_SESSION['membre']->getId(),
                'lat'            => (float) Route::params('lat'),
                'lng'            => (float) Route::params('lng'),
            ];
            $errors = [];

            if (self::_validateLieuEditForm($data, $errors)) {

                $lieu = Lieu::getInstance($data['id'])
                    ->setIdCountry($data['id_country'])
                    ->setIdRegion($data['id_region'])
                    ->setIdDepartement($data['id_departement'])
                    ->setIdCity($data['id_city'])
                    ->setIdType($data['id_type'])
                    ->setName($data['name'])
                    ->setAddress($data['address'])
                    ->setText($data['text'])
                    ->setSite($data['site'])
                    ->setLat($data['lat'])
                    ->setLng($data['lng']);

                if ($lieu->save()) {
                    /* récupération des coordonnées si non précisées */
//                    if (!$lieu->getLng() || !$lieu->getLat()) {
                        $addr = $lieu->getAddress() . ' ' . $lieu->getCity()->getCp() . ' ' . $lieu->getCity()->getName();
                        if ($coords = GoogleMaps::getGeocode($addr)) {
                            $lieu->setLat($coords['lat']);
                            $lieu->setLng($coords['lng']);
                            $lieu->save();
                        }
//                    }

                    /* Upload de la photo */
                    if (is_uploaded_file($_FILES['photo']['tmp_name'])) {
                        (new Image($_FILES['photo']['tmp_name']))
                            ->setType(IMAGETYPE_JPEG)
                            ->setMaxWidth(400)
                            ->setMaxHeight(400)
                            ->setDestFile(Lieu::getBasePath() . '/' . $lieu->getId() . '.jpg')
                            ->write();
                    }

                    Log::action(Log::ACTION_LIEU_EDIT, $lieu->getId());

                    Tools::redirect('/lieux/' . $lieu->getId() . '?edit=1');
                }
            } else {
                // erreurs
            }
        }

        $smarty->enqueue_script_vars(
            [
                'id' => $lieu->getId(),
                'id_country' => $lieu->getIdCountry(),
                'id_region' => $lieu->getIdRegion(),
                'id_departement' => $lieu->getIdDepartement(),
                'id_city' => $lieu->getIdCity(),
            ]
        );

        return $smarty->fetch('lieux/edit.tpl');
    }

    /**
     * @return string
     */
    static function delete(): string
    {
        Tools::auth(Membre::TYPE_ADMIN);

        $id = (int) Route::params('id');

        Trail::getInstance()
            ->addStep("Lieux", "/lieux")
            ->addStep("Supprimer");

        $smarty = new AdHocSmarty();

        try {
            $lieu = Lieu::getInstance($id);
            $smarty->assign('lieu', $lieu);
        } catch (Exception $e) {
            Route::set_http_code(404);
            $smarty->assign('unknown_lieu', true);
            return $smarty->fetch('lieux/delete.tpl');
        }

        if (Tools::isSubmit('form-lieu-delete')) {
            if ($lieu->delete()) {
                Log::action(Log::ACTION_LIEU_DELETE, $lieu->getId());
                Tools::redirect('/lieux?delete=1');
            }
        }

        return $smarty->fetch('lieux/delete.tpl');
    }

    /**
     * @return string
     */
    static function geocode(): string
    {
        $q  = (string) Route::params('q');
        return GoogleMaps::getGeocode($q);
    }

    /**
     * @return string
     */
    static function fetch(): string
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
                return Lieu::fetchLieuxByRadius(
                    [
                        'lat'      => $lat,
                        'lng'      => $lng,
                        'distance' => $distance,
                        'order'    => 'distance',
                        'limit'    => $limit,
                    ]
                );
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
                return Lieu::fetchLieuxByBoundary(
                    [
                        'lat'     => $lat,
                        'lng'     => $lng,
                        'lat_min' => $lat_min,
                        'lat_max' => $lat_max,
                        'lng_min' => $lng_min,
                        'lng_max' => $lng_max,
                        'limit'   => $limit,
                    ]
                );
                break;

            case 'admin':
                $id_country     = (string) Route::params('id_country');
                $id_region      = (string) Route::params('id_region');
                $id_departement = (string) Route::params('id_departement');
                return Lieu::fetchLieuxByAdmin(
                    [
                        'lat'            => $lat,
                        'lng'            => $lng,
                        'id_country'     => $id_country,
                        'id_region'      => $id_region,
                        'id_departement' => $id_departement,
                        'limit'          => $limit,
                    ]
                );
                break;

            default:
                return [];
                break;
        }
    }

    /**
     * Validation du formulaire de création lieu
     *
     * @param array $data   tableau des données
     * @param array $errors tableau des erreurs
     *
     * @return bool
     */
    private static function _validateLieuCreateForm(array $data, array &$errors): bool
    {
        if (empty($data['name'])) {
            $errors['name'] = true;
        }
        if (count($errors)) {
            return false;
        }
        return true;
    }

    /**
     * Validation du formulaire de modification membre
     *
     * @param array $data   tableau des données
     * @param array $errors tableau des erreurs (par référence)
     *
     * @return bool
     */
    private static function _validateLieuEditForm(array $data, array &$errors): bool
    {
        if (empty($data['name'])) {
            $errors['name'] = true;
        }
        if (count($errors)) {
            return false;
        }
        return true;
    }
}
