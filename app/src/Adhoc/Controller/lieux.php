<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\Audio;
use Adhoc\Model\Event;
use Adhoc\Model\Lieu;
use Adhoc\Model\Membre;
use Adhoc\Model\Photo;
use Adhoc\Model\Reference\City;
use Adhoc\Model\Reference\Departement;
use Adhoc\Model\Reference\LieuType;
use Adhoc\Model\Reference\WorldCountry;
use Adhoc\Model\Reference\WorldRegion;
use Adhoc\Model\Video;
use Adhoc\Utils\AdHocTwig;
use Adhoc\Utils\Log;
use Adhoc\Utils\Route;
use Adhoc\Utils\Tools;
use Adhoc\Utils\Trail;
use Adhoc\Utils\Image;

/**
 *
 */
final class Controller
{
    /**
     * @return string
     */
    public static function index(): string
    {
        $twig = new AdHocTwig();

        $twig->enqueueScript('/js/lieux/index.js');

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
        $twig->assign('regions', $regions);

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

        $twig->assign('departements', $departements);

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

        $twig->assign('lieux', $lieux);

        return $twig->render('lieux/index.twig');
    }

    /**
     * @return string
     */
    public static function my(): string
    {
        $page = (int) Route::params('page');

        $twig = new AdHocTwig();

        Trail::getInstance()
            ->addStep("Lieux", "/lieux")
            ->addStep("Mes lieux");

        $twig->assign('lieux', Lieu::findAll());

        $twig->assign('nb_items', Lieu::count());
        $twig->assign('nb_items_per_page', 200);
        $twig->assign('page', $page);

        return $twig->render('lieux/my.twig');
    }

    /**
     * @return string
     */
    public static function show(): string
    {
        $id = (int) Route::params('id');

        $twig = new AdHocTwig();

        $twig->assign('create', (bool) Route::params('create'));
        $twig->assign('edit', (bool) Route::params('edit'));

        try {
            $lieu = Lieu::getInstance($id);
        } catch (\Exception $e) {
            Route::setHttpCode(404);
            $twig->assign('unknown_lieu', true);
            return $twig->render('lieux/show.twig');
        }

        $twig->enqueueStyle('/css/baguetteBox-1.11.1.min.css');
        $twig->enqueueStyle('/css/leaflet.css');

        $twig->enqueueScript('/js/masonry-4.2.2.min.js');
        $twig->enqueueScript('/js/imagesloaded-4.1.4.min.js');
        $twig->enqueueScript('/js/baguetteBox-1.11.1.min.js');
        $twig->enqueueScript('/js/leaflet.js');

        $twig->enqueueScriptVars(
            [
                'lat' => number_format((float) $lieu->getLat(), 6, '.', ''),
                'lng' => number_format((float) $lieu->getLng(), 6, '.', ''),
                'name' => $lieu->getName()
            ]
        );
        $twig->enqueueScript('/js/lieux/show.js');

        if (!$lieu->getLat() && !$lieu->getLng()) {
            $twig->assign('geocode', true);
            $twig->assign('geocode_id_lieu', $lieu->getId());
            $twig->assign('geocode_address', $lieu->getAddress() . ' ' . $lieu->getCity()->getCp() . ' ' . $lieu->getCity()->getName());
        }

        $twig->assign('lieu', $lieu);

        $trail = Trail::getInstance()
            ->addStep("Lieux", "/lieux")
            ->addStep($lieu->getName());

        $twig->assign('title', $lieu->getName() . " - " . $lieu->getAddress() . " - " . $lieu->getCity()->getCp() . " " . $lieu->getCity()->getName());
        $twig->assign('description', $lieu->getName() . " - " . $lieu->getAddress() . " - " . $lieu->getCity()->getCp() . " " . $lieu->getCity()->getName());

        $twig->assign(
            'events_f',
            Event::find(
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

        $twig->assign(
            'events_p',
            Event::find(
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

        $twig->assign(
            'photos',
            Photo::find(
                [
                    'id_lieu' => $lieu->getIdLieu(),
                    'online' => true,
                    'order_by' => 'random',
                    'limit' => 100,
                ]
            )
        );

        $twig->assign(
            'audios',
            Audio::find(
                [
                    'id_lieu' => $lieu->getIdLieu(),
                    'online' => true,
                    'order_by' => 'random',
                ]
            )
        );

        $twig->assign(
            'videos',
            Video::find(
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
                $twig->assign('alerting_sub_url', HOME_URL . '/alerting/sub?type=l&id_content='.$lieu->getId());
            } else {
                $twig->assign('alerting_unsub_url', HOME_URL . '/alerting/unsub?type=l&id_content='.$lieu->getId());
            }
        } else {
            $twig->assign('alerting_auth_url', HOME_URL .  '/auth/auth');
        }
        */

        return $twig->render('lieux/show.twig');
    }

    /**
     * @return string
     */
    public static function create(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $twig = new AdHocTwig();

        $twig->enqueueScript('/js/geopicker.js');
        $twig->enqueueScript('/js/lieux/create.js');

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

            $errors = self::validateLieuCreateForm($data);
            if (count($errors) === 0) {
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

        $twig->assign('lieu_types', LieuType::findAll());

        $twig->enqueueScriptVars(
            [
                'id_lieu' => 0,
                'id_country' => 'FR',
                'id_region' => '08',
                'id_departement' => '91',
                'id_city' => 91216
            ]
        );

        return $twig->render('lieux/create.twig');
    }

    /**
     * @return string
     */
    public static function edit(): string
    {
        $id = (int) Route::params('id');

        Tools::auth(Membre::TYPE_STANDARD);

        Trail::getInstance()
            ->addStep("Lieux", "/lieux")
            ->addStep("Modifier");

        $twig = new AdHocTwig();

        $twig->enqueueScript('/js/geopicker.js');
        $twig->enqueueScript('/js/lieux/edit.js');

        try {
            $lieu = Lieu::getInstance($id);
            $twig->assign('lieu', $lieu);
            $twig->assign('lieu_types', LieuType::findAll());
        } catch (\Exception $e) {
            Route::setHttpCode(404);
            $twig->assign('unknown_lieu', true);
            return $twig->render('lieux/edit.twig');
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

            $errors = self::validateLieuEditForm($data);
            if (count($errors) === 0) {
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
/*
                        $addr = $lieu->getAddress() . ' ' . $lieu->getCity()->getCp() . ' ' . $lieu->getCity()->getName();
                        if ($coords = GoogleMaps::getGeocode($addr)) {
                            $lieu->setLat($coords['lat']);
                            $lieu->setLng($coords['lng']);
                            $lieu->save();
                        }
*/
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

        $twig->enqueueScriptVars(
            [
                'id' => $lieu->getId(),
                'id_country' => $lieu->getIdCountry(),
                'id_region' => $lieu->getIdRegion(),
                'id_departement' => $lieu->getIdDepartement(),
                'id_city' => $lieu->getIdCity(),
            ]
        );

        return $twig->render('lieux/edit.twig');
    }

    /**
     * @return string
     */
    public static function delete(): string
    {
        Tools::auth(Membre::TYPE_ADMIN);

        $id = (int) Route::params('id');

        Trail::getInstance()
            ->addStep("Lieux", "/lieux")
            ->addStep("Supprimer");

        $twig = new AdHocTwig();

        try {
            $lieu = Lieu::getInstance($id);
            $twig->assign('lieu', $lieu);
        } catch (\Exception $e) {
            Route::setHttpCode(404);
            $twig->assign('unknown_lieu', true);
            return $twig->render('lieux/delete.twig');
        }

        if (Tools::isSubmit('form-lieu-delete')) {
            if ($lieu->delete()) {
                Log::action(Log::ACTION_LIEU_DELETE, $lieu->getId());
                Tools::redirect('/lieux?delete=1');
            }
        }

        return $twig->render('lieux/delete.twig');
    }

    /**
     * @return array<mixed>
     */
    public static function fetch(): array
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

        switch ($mode) {
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

            default:
                return [];
        }
    }

    /**
     * Validation du formulaire de création lieu
     *
     * @param array<string,mixed> $data tableau des données
     *
     * @return array<string,true>
     */
    private static function validateLieuCreateForm(array $data): array
    {
        $errors = [];

        if (empty($data['name'])) {
            $errors['name'] = true;
        }

        return $errors;
    }

    /**
     * Validation du formulaire de modification membre
     *
     * @param array<string,mixed> $data tableau des données
     *
     * @return array<string,true>
     */
    private static function validateLieuEditForm(array $data): array
    {
        $errors = [];

        if (empty($data['name'])) {
            $errors['name'] = true;
        }

        return $errors;
    }
}
