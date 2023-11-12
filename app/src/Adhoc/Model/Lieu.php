<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Model\Reference\City;
use Adhoc\Model\Reference\Departement;
use Adhoc\Model\Reference\LieuType;
use Adhoc\Model\Reference\WorldCountry;
use Adhoc\Model\Reference\WorldRegion;
use Adhoc\Utils\Date;
use Adhoc\Utils\DataBase;
use Adhoc\Utils\ObjectModel;

/**
 * Classe Lieu
 *
 * Gestion des Lieux de diffusions
 *
 * @template TObjectModel as Lieu
 * @extends ObjectModel<TObjectModel>
 *
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Lieu extends ObjectModel
{
    /**
     * Instance de l'objet
     *
     * @var ?TObjectModel
     */
    protected static ?ObjectModel $instance = null;

    /**
     * Nom de la clé primaire
     *
     * @var string|array<string>
     */
    protected static string|array $pk = 'id_lieu';

    /**
     * Nom de la table
     *
     * @var string
     */
    protected static string $table = 'adhoc_lieu';

    /**
     * @var int
     */
    protected int $id_lieu = 0;

    /**
     * @var int
     */
    protected int $id_type = 0;

    /**
     * @var string
     */
    protected string $name = '';

    /**
     * @var string
     */
    protected string $address = '';

    /**
     * @var int
     */
    protected int $id_city = 0;

    /**
     * @var string
     */
    protected string $id_departement = '';

    /**
     * @var string
     */
    protected string $id_region = '';

    /**
     * @var string
     */
    protected string $id_country = '';

    /**
     * @var string
     */
    protected string $text = '';

    /**
     * @var string
     */
    protected string $site = '';

    /**
     * @var int
     */
    protected int $id_contact = 0;

    /**
     * @var ?string
     */
    protected ?string $created_at = null;

    /**
     * @var ?string
     */
    protected ?string $modified_at = null;

    /**
     * @var ?float
     */
    protected ?float $lat = null;

    /**
     * @var ?float
     */
    protected ?float $lng = null;

    /**
     * @var bool
     */
    protected bool $online = false;

    /**
     * @var ?string
     */
    protected ?string $photo_url = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_lieu'        => 'int', // pk
        'id_type'        => 'int',
        'name'           => 'string',
        'address'        => 'string',
        'id_city'        => 'int',
        'id_departement' => 'string',
        'id_region'      => 'string',
        'id_country'     => 'string',
        'text'           => 'string',
        'site'           => 'string',
        'id_contact'     => 'int',
        'created_at'     => 'date',
        'modified_at'    => 'date',
        'lat'            => 'float',
        'lng'            => 'float',
        'online'         => 'bool',
    ];

    /* début getters */

    /**
     * @return string
     */
    public static function getBaseUrl(): string
    {
        return MEDIA_URL . '/lieu';
    }

    /**
     * @return string
     */
    public static function getBasePath(): string
    {
        return MEDIA_PATH . '/lieu';
    }

    /**
     * Retourne l'id du lieu
     *
     * @return int
     */
    public function getIdLieu(): int
    {
        return $this->id_lieu;
    }

    /**
     * Retourne l'id type du lieu
     *
     * @return int
     */
    public function getIdType(): int
    {
        return $this->id_type;
    }

    /**
     * Retourne le libellé du type de lieu
     *
     * @return string
     */
    public function getType(): string
    {
        return self::getTypeName($this->id_type);
    }

    /**
     * Retourne le nom d'un lieu
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Retourne l'adresse
     *
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * Retourne l'id de la ville (country FR only)
     * ça correspond au code insee
     *
     * @return int
     */
    public function getIdCity(): int
    {
        return $this->id_city;
    }

    /**
     * Retourne la ville
     *
     * @return object
     */
    public function getCity(): object
    {
        return City::getInstance($this->getIdCity());
    }

    /**
     * Retourne l'id du département (country FR only)
     *
     * @return string
     */
    public function getIdDepartement(): string
    {
        return $this->id_departement;
    }

    /**
     * Retourne l'objet département
     *
     * @return object
     */
    public function getDepartement(): object
    {
        return Departement::getInstance($this->getIdDepartement());
    }

    /**
     * Retourne l'id de la région (avant unification de 201X)
     *
     * @return string
     */
    public function getIdRegion(): string
    {
        return $this->id_region;
    }

    /**
     * Retourne l'objet région
     *
     * @return object
     */
    public function getRegion(): object
    {
        return WorldRegion::getInstance(
            [
                'id_country' => $this->getIdCountry(),
                'id_region' => $this->getIdRegion(),
            ]
        );
    }

    /**
     * Retourne le code pays
     *
     * @return string
     */
    public function getIdCountry(): string
    {
        return $this->id_country;
    }

    /**
     * Retourne l'objet country
     *
     * @return object
     */
    public function getCountry(): object
    {
        return WorldCountry::getInstance($this->getIdCountry());
    }

    /**
     * Retourne le texte de présentation
     *
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * Retourne le site
     *
     * @return string
     */
    public function getSite(): string
    {
        return $this->site;
    }

    /**
     * Retourne le contact créateur
     *
     * @return int
     */
    public function getIdContact(): int
    {
        return $this->id_contact;
    }

    /**
     * Retourne la latitude
     *
     * @return float xx.xxxxxx | null
     */
    public function getLat(): ?float
    {
        return $this->lat;
    }

    /**
     * Retourne la longitude
     *
     * @return float xx.xxxxxx | null
     */
    public function getLng(): ?float
    {
        return $this->lng;
    }

    /**
     * Retourne les coordonnées utilisable
     * par Google Maps. ex: X.XXXXXX,Y.YYYYYY
     *
     * @return string
     */
    public function getGeocode(): string
    {
        if ($this->getLat() && $this->getLng()) {
            return number_format($this->getLat(), 6, '.', '')
                 . ','
                 . number_format($this->getLng(), 6, '.', '');
        }
        return '';
    }

    /**
     * Retourne la date de création
     *
     * @return ?string
     */
    public function getCreatedAt(): ?string
    {
        if (!is_null($this->created_at) && Date::isDateTimeOk($this->created_at)) {
            return $this->created_at;
        }
        return null;
    }

    /**
     * Retourne la date de création sous forme d'un timestamp
     *
     * @return int
     */
    public function getCreatedAtTs(): ?int
    {
        if (!is_null($this->created_at) && Date::isDateTimeOk($this->created_at)) {
            return strtotime($this->created_at);
        }
        return null;
    }

    /**
     * Retourne la date de modification
     *
     * @return string
     */
    public function getModifiedAt(): ?string
    {
        if (!is_null($this->modified_at) && Date::isDateTimeOk($this->modified_at)) {
            return (string) $this->modified_at;
        }
        return null;
    }

    /**
     * Retourne la date de modification sous forme d'un timestamp
     *
     * @return int
     */
    public function getModifiedAtTs(): ?int
    {
        if (!is_null($this->modified_at) && Date::isDateTimeOk($this->modified_at)) {
            return strtotime($this->modified_at);
        }
        return null;
    }

    /**
     * Retourne le switch affiche
     *
     * @return bool
     */
    public function getOnline(): bool
    {
        return $this->online;
    }

    /**
     * Retourne l'url de la fiche d'un lieu
     *
     * @return string
     */
    public function getUrl(): string
    {
        return HOME_URL . '/lieux/' . $this->getIdLieu();
    }

    /**
     * Retourne la distance (à la position actuelle si renseignée)
     *
     * @return float
     */
    public function getDistance(): float
    {
        return $this->distance;
    }

    /**
     * Retourne l'url de la photo du lieu
     *
     * @return ?string
     */
    public function getPhotoUrl(): ?string
    {
        return $this->photo_url;
    }

    /* fin getters */

    /* début setters */

    /**
     * Set le type du lieu
     *
     * @param int $id_type id_type
     *
     * @return object
     */
    public function setIdType(int $id_type): object
    {
        if ($this->id_type !== $id_type) {
            $this->id_type = $id_type;
            $this->modified_fields['id_type'] = true;
        }

        return $this;
    }

    /**
     * Set le nom
     *
     * @param string $name name
     *
     * @return object
     */
    public function setName(string $name): object
    {
        if ($this->name !== $name) {
            $this->name = $name;
            $this->modified_fields['name'] = true;
        }

        return $this;
    }

    /**
     * Set l'adresse
     *
     * @param string $address adresse
     *
     * @return object
     */
    public function setAddress(string $address): object
    {
        if ($this->address !== $address) {
            $this->address = $address;
            $this->modified_fields['address'] = true;
        }

        return $this;
    }

    /**
     * Set l'id de la ville
     *
     * @param int $id_city id_city
     *
     * @return object
     */
    public function setIdCity(int $id_city): object
    {
        if ($this->id_city !== $id_city) {
            $this->id_city = $id_city;
            $this->modified_fields['id_city'] = true;
        }

        return $this;
    }

    /**
     * Set le département
     *
     * @param string $id_departement id_departement
     *
     * @return object
     */
    public function setIdDepartement(string $id_departement): object
    {
        if (is_numeric($id_departement)) {
            $id_departement = str_pad($id_departement, 2, '0', STR_PAD_LEFT);
        } else {
            $id_departement = 'ext';
        }

        if ($this->id_departement !== $id_departement) {
            $this->id_departement = $id_departement;
            $this->modified_fields['id_departement'] = true;
        }

        return $this;
    }

    /**
     * Set la région
     *
     * @param string $id_region id_region
     *
     * @return object
     */
    public function setIdRegion(string $id_region): object
    {
        if ($this->id_region !== $id_region) {
            $this->id_region = $id_region;
            $this->modified_fields['id_region'] = true;
        }

        return $this;
    }

    /**
     * Set le code pays
     *
     * @param string $id_country id_country
     *
     * @return object
     */
    public function setIdCountry(string $id_country): object
    {
        if ($this->id_country !== $id_country) {
            $this->id_country = $id_country;
            $this->modified_fields['id_country'] = true;
        }

        return $this;
    }

    /**
     * Set le texte de présentation
     *
     * @param string $text texte
     *
     * @return object
     */
    public function setText(string $text): object
    {
        if ($this->text !== $text) {
            $this->text = $text;
            $this->modified_fields['text'] = true;
        }

        return $this;
    }

    /**
     * Set le site
     *
     * @param string $site site
     *
     * @return object
     */
    public function setSite(string $site): object
    {
        if ($this->site !== $site) {
            $this->site = $site;
            $this->modified_fields['site'] = true;
        }

        return $this;
    }

    /**
     * Set le contact créateur
     *
     * @param int $id_contact id_contact
     *
     * @return object
     */
    public function setIdContact(int $id_contact): object
    {
        if ($this->id_contact !== $id_contact) {
            $this->id_contact = $id_contact;
            $this->modified_fields['id_contact'] = true;
        }

        return $this;
    }

    /**
     * Set la latitude
     *
     * @param float $lat latitude
     *
     * @return object
     */
    public function setLat(float $lat): object
    {
        if ($this->lat !== $lat) {
            $this->lat = $lat;
            $this->modified_fields['lat'] = true;
        }

        return $this;
    }

    /**
     * Set la longitude
     *
     * @param float $lng longitude
     *
     * @return object
     */
    public function setLng(float $lng): object
    {
        if ($this->lng !== $lng) {
            $this->lng = $lng;
            $this->modified_fields['lng'] = true;
        }

        return $this;
    }

    /**
     * Set la date de création
     *
     * @param string $created_at created_at
     *
     * @return object
     */
    public function setCreatedAt(string $created_at): object
    {
        if ($this->created_at !== $created_at) {
            $this->created_at = $created_at;
            $this->modified_fields['created_at'] = true;
        }

        return $this;
    }

    /**
     * Set la date de création à now
     *
     * @return object
     */
    public function setCreatedNow(): object
    {
        $now = date('Y-m-d H:i:s');

        if ($this->created_at !== $now) {
            $this->created_at = $now;
            $this->modified_fields['created_at'] = true;
        }

        return $this;
    }

    /**
     * Set la date de modification
     *
     * @param string $modified_at modified_at
     *
     * @return object
     */
    public function setModifiedAt(string $modified_at): object
    {
        if ($this->modified_at !== $modified_at) {
            $this->modified_at = $modified_at;
            $this->modified_fields['modified_at'] = true;
        }

        return $this;
    }

    /**
     * Set la date de modification à now
     *
     * @return object
     */
    public function setModifiedNow(): object
    {
        $now = date('Y-m-d H:i:s');

        if ($this->modified_at != $now) {
            $this->modified_at = $now;
            $this->modified_fields['modified_at'] = true;
        }

        return $this;
    }

    /**
     * Set le switch affiche
     *
     * @param bool $online online
     *
     * @return object
     */
    public function setOnline(bool $online): object
    {
        if ($this->online !== $online) {
            $this->online = $online;
            $this->modified_fields['online'] = true;
        }

        return $this;
    }

    /* fin setters */

    /**
     * Suppression d'un lieu
     *
     * @return bool
     * @throws \Exception
     */
    public function delete(): bool
    {
        if (parent::delete()) {
            $file = self::getBasePath() . '/' . (int) $this->getId() . '.jpg';
            if (file_exists($file)) {
                unlink($file);
            }
            return true;
        }
        return false;
    }

    /**
     * Retourne une collection d'objets "Lieu" répondant au(x) critère(s) donné(s)
     *
     * @param array $params [
     *                      'with_events' => bool,
     *                      'online' => bool,
     *                      'id_country' => string,
     *                      'id_region' => string,
     *                      'id_departement' => string,
     *                      'id_city' => int,
     *                      'order_by' => string,
     *                      'sort' => string,
     *                      'start' => int,
     *                      'limit' => int,
     *                      ]
     *
     * @return array
     */
    public static function find(array $params): array
    {
        $db = DataBase::getInstance();
        $objs = [];

        $sql = "SELECT `" . static::getDbPk() . "` FROM `" . static::getDbTable() . "` WHERE 1 ";

        if (isset($params['with_events'])) {
            $subSql = "SELECT DISTINCT `id_lieu` FROM `adhoc_event`";
            if ($ids_lieu = $db->queryWithFetchFirstFields($subSql)) {
                if ($params['with_events'] === true) {
                    $sql .= "AND `id_lieu` IN (" . implode(',', (array) $ids_lieu) . ") ";
                } else {
                    $sql .= "AND `id_lieu` NOT IN (" . implode(',', (array) $ids_lieu) . ") ";
                }
            } else {
                if ($params['with_events'] === true) {
                    return $objs; // aucun événement référencé, donc rien
                } else {
                    // aucun événements référencés, donc pas + de filtrage ici
                }
            }
        }

        if (isset($params['online'])) {
            $sql .= "AND `online` = ";
            $sql .= $params['online'] ? "TRUE" : "FALSE";
            $sql .= " ";
        }

        if (isset($params['id_country'])) {
            $sql .= "AND `id_country` = '" . $db->escape($params['id_country']) . "' ";
        }

        if (isset($params['id_region'])) {
            $sql .= "AND `id_region` = '" . $db->escape($params['id_region']) . "' ";
        }

        if (isset($params['id_departement'])) {
            $sql .= "AND `id_departement` = '" . $db->escape($params['id_departement']) . "' ";
        }

        if (isset($params['id_city'])) {
            $sql .= "AND `id_city` = '" . (int) $params['id_city'] . "' ";
        }

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$all_fields))))) {
            $sql .= "ORDER BY `" . $params['order_by'] . "` ";
        } else {
            $sql .= "ORDER BY `" . static::getDbPk() . "` ";
        }

        if ((isset($params['sort']) && (in_array($params['sort'], ['ASC', 'DESC'])))) {
            $sql .= $params['sort'] . " ";
        } else {
            $sql .= "ASC ";
        }

        if (!isset($params['start'])) {
            $params['start'] = 0;
        }

        if (isset($params['limit'])) {
            $sql .= "LIMIT " . (int) $params['start'] . ", " . (int) $params['limit'];
        }

        $ids = $db->queryWithFetchFirstFields($sql);
        foreach ($ids as $id) {
            $objs[] = static::getInstance((int) $id);
        }

        return $objs;
    }

    /**
     * Retourne les lieux d'un département
     *
     * @param string $id_departement département
     *
     * @return array
     */
    public static function getLieuxByDep(string $id_departement = null): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_lieu`, `id_departement` "
             . "FROM `" . Lieu::getDbTable() . "` "
             . "ORDER BY `id_departement` ASC";

        $rows = $db->queryWithFetch($sql);

        $tab = [];
        foreach (Departement::findAll() as $dep) {
            $tab[$dep->getIdDepartement()] = [];
        }

        foreach ($rows as $row) {
            $tab[(string) $row['id_departement']][] = Lieu::getInstance((int) $row['id_lieu']);
        }

        // tri par nom de ville
        foreach (array_keys($tab) as $dep) {
            usort($tab[$dep], ['Adhoc\Model\Lieu','sortLieuByCityName']);
        }

        if (!is_null($id_departement) && array_key_exists($id_departement, $tab)) {
            return $tab[$id_departement];
        }
        return $tab;
    }

    /**
     * callback pour le usort de getLieuxByDep
     *
     * @param Lieu $a
     * @param Lieu $b
     *
     * @return int
     */
    public static function sortLieuByCityName(Lieu $a, Lieu $b)
    {
        if ($a->getCity()->getName() === $b->getCity()->getName()) {
            return 0;
        }
        return ($a->getCity()->getName() < $b->getCity()->getName()) ? -1 : 1;
    }

    /**
     * Retourne les infos sur un lieu
     *
     * @return bool
     * @throws \Exception
     */
    protected function loadFromDb(): bool
    {
        if (!parent::loadFromDb()) {
            throw new \Exception('lieu introuvable');
        }

        if (file_exists(self::getBasePath() . '/' . (string) $this->getIdLieu() . '.jpg')) {
            $this->photo_url = self::getBaseUrl() . '/' . (string) $this->getIdLieu() . '.jpg';
        }

        return true;
    }

    /**
     * @return bool
     */
    public function hasPhotos(): bool
    {
        return (count($this->getPhotos()) > 0);
    }

    /**
     * Retourne les photos associées à ce lieu
     *
     * @return array
     */
    public function getPhotos(): array
    {
        return Photo::find(
            [
                'id_lieu' => $this->getIdLieu(),
            ]
        );
    }

    /**
     * @return bool
     */
    public function hasVideos(): bool
    {
        return (count($this->getVideos()) > 0);
    }

    /**
     * Retourne les vidéos associées à ce lieu
     *
     * @return array
     */
    public function getVideos(): array
    {
        return Video::find(
            [
                'id_lieu' => $this->getIdLieu(),
            ]
        );
    }

    /**
     * @return bool
     */
    public function hasAudios(): bool
    {
        return (count($this->getAudios()) > 0);
    }

    /**
     * Retourne les audios associés à ce lieu
     *
     * @return array
     */
    public function getAudios(): array
    {
        return Audio::find(
            [
                'id_lieu' => $this->getIdLieu(),
            ]
        );
    }

    /**
     * @return bool
     */
    public function hasEvents(): bool
    {
        return (count($this->getEvents()) > 0);
    }

    /**
     * Retourne les événements rattachés au lieu
     *
     * @return array
     */
    public function getEvents(): array
    {
        return Event::find(
            [
                'id_lieu' => $this->getIdLieu(),
                'order_by' => 'date',
                'sort' => 'DESC',
            ]
        );
    }

    /**
     * Retourne les types de lieux
     *
     * @return array
     */
    public static function getTypes(): array
    {
        return LieuType::findAll();
    }

    /**
     * Retourne le libellé d'un type de lieu
     *
     * @param int $id_lieu_type id_lieu_type
     *
     * @return string
     */
    public static function getTypeName(int $id_lieu_type)
    {
        return LieuType::getInstance($id_lieu_type)->getName();
    }

    /**
     * Procédure stockée MySQL pour le calcul de distances
     *
     * @todo debuguer car ca passe pas
     */
    public static function mysqlInitGeo()
    {
        $db = DataBase::getInstance();

        $sql = <<<EOT
DELIMITER |
DROP FUNCTION IF EXISTS get_distance_metres|
CREATE FUNCTION get_distance_metres (lat1 DOUBLE, lng1 DOUBLE, lat2 DOUBLE, lng2 DOUBLE) RETURNS DOUBLE
BEGIN
    DECLARE rlo1 DOUBLE;
    DECLARE rla1 DOUBLE;
    DECLARE rlo2 DOUBLE;
    DECLARE rla2 DOUBLE;
    DECLARE dlo DOUBLE;
    DECLARE dla DOUBLE;
    DECLARE a DOUBLE;

    SET rlo1 = RADIANS(lng1);
    SET rla1 = RADIANS(lat1);
    SET rlo2 = RADIANS(lng2);
    SET rla2 = RADIANS(lat2);
    SET dlo = (rlo2 - rlo1) / 2;
    SET dla = (rla2 - rla1) / 2;
    SET a = SIN(dla) * SIN(dla) + COS(rla1) * COS(rla2) * SIN(dlo) * SIN(dlo);
    RETURN (6378137 * 2 * ATAN2(SQRT(a), SQRT(1 - a)));
END|
DELIMITER ;
EOT;

        $sql = $db->query($sql);
    }

    /**
     * Récupère les lieux autour d'un point et d'un rayon
     *
     * @param array float ['lat']
     *              float ['lng']
     *              int ['distance'] (en mètres)
     *              int ['limit']
     *              string ['sort']
     *
     * @return array les infos du lieux et sa distance en km par rapport au point
     */
    public static function fetchLieuxByRadius(array $params): array
    {
        $lat      = (float) $params['lat'];
        $lng      = (float) $params['lng'];
        $distance = (int) $params['distance'];
        $limit    = (int) $params['limit'];
        $sort     = (string) $params['sort'];

        $db = DataBase::getInstance();

        $sql = "SELECT `l`.`id_lieu`, `l`.`name`, `l`.`address`, `v`.`cp`, `v`.`name` AS `city`, `l`.`lat`, `l`.`lng`, "
             . "FORMAT(get_distance_metres('" . number_format($lat, 8, '.', '') . "', '" . number_format($lng, 8, '.', '') . "', `l`.`lat`, `l`.`lng`) / 1000, 2) AS `distance` "
             . "FROM (`adhoc_lieu` `l`) "
             . "LEFT JOIN `" . City::getDbTable() . "` `v` ON (`l`.`id_city` = `v`.`id_city`) "
             . "HAVING `distance` < " . number_format(($distance / 1000), 8, '.', '') . " ";
        if ($sort === 'rand') {
            $sql .= "ORDER BY RAND() ";
        } else {
            $sql .= "ORDER BY `distance` ASC ";
        }
        $sql .= "LIMIT 0, " . $limit;

        return $db->queryWithFetch($sql);
    }

    /**
     * Récupère les lieux dans une zone rectangulaire (point NW et point SE)
     *
     * @param array float ['lat']
     *              float ['lng']
     *              float ['lat_min']
     *              float ['lat_max']
     *              float ['lng_min']
     *              float ['lng_max']
     *              int ['limit']
     */
    public static function fetchLieuxByBoundary(array $params): array
    {
        $lat     = (float) $params['lat'];
        $lng     = (float) $params['lng'];
        $lat_min = (float) $params['lat_min'];
        $lat_max = (float) $params['lat_max'];
        $lng_min = (float) $params['lng_min'];
        $lng_max = (float) $params['lng_max'];
        $limit   = (int) $params['limit'];

        if (($lat_min < -90) || ($lat_max > 90) || ($lng_min < -180) || ($lng_max > 180)) {
            return []; // hors limite
        }
        if (($lat_min >= $lat_max) || ($lng_min >= $lng_max)) {
            return []; // pas dans le bon sens
        }

        $db = DataBase::getInstance();

        $sql = "SELECT `l`.`id_lieu`, `l`.`name`, `l`.`address`, `v`.`cp`, `v`.`name` AS `city`, `l`.`lat`, `l`.`lng`, "
             . "FORMAT(get_distance_metres('" . number_format($lat, 8, '.', '') . "', '" . number_format($lng, 8, '.', '') . "', `l`.`lat`, `l`.`lng`) / 1000, 2) AS `distance` "
             . "FROM (`adhoc_lieu` `l`) "
             . "LEFT JOIN `" . City::getDbTable() . "` `v` ON (`l`.`id_city` = `v`.`id_city`) "
             . "WHERE 1 "
             . "AND `l`.`lat` > " . number_format($lat_min, 8, '.', '') . " "
             . "AND `l`.`lat` < " . number_format($lat_max, 8, '.', '') . " "
             . "AND `l`.`lng` > " . number_format($lng_min, 8, '.', '') . " "
             . "AND `l`.`lng` < " . number_format($lng_max, 8, '.', '') . " "
             . "ORDER BY RAND() "
             . "LIMIT 0, " . $limit;

        return $db->queryWithFetch($sql);
    }

    /**
     * Récupère les lieux à partir de leur zone géographique administrative
     *
     * @param array float ['lat']
     *              float ['lng']
     *              string ['id_country']
     *              string ['id_region']
     *              string ['id_departement']
     *              int ['limit']
     *
     * @return array
     */
    public static function fetchLieuxByAdmin(array $params): array
    {
        $lat            = (float) $params['lat'];
        $lng            = (float) $params['lng'];
        $id_country     = (string) $params['id_country'];
        $id_region      = (string) $params['id_region'];
        $id_departement = (string) $params['id_departement'];
        $limit          = (int) $params['limit'];

        $db = DataBase::getInstance();

        $sql = "SELECT `l`.`id_lieu`, `l`.`name`, `l`.`address`, `v`.`cp`, `v`.`name` AS `city`, `l`.`lat`, `l`.`lng` "
             . "FROM (`adhoc_lieu` `l`) "
             . "LEFT JOIN `" . City::getDbTable() . "` `v` ON (`l`.`id_city` = `v`.`id_city`) "
             . "WHERE 1 "
             . "AND `l`.`id_country` = '" . $db->escape($id_country) . "' "
             . "AND `l`.`id_region` = '" . $db->escape($id_region) . "' "
             . "AND `l`.`id_departement` = '" . $db->escape($id_departement) . "' "
             . "ORDER BY `l`.`id_country` ASC, `l`.`id_region` ASC, `l`.`id_departement` ASC "
             . "LIMIT 0, " . $limit;

        return $db->queryWithFetch($sql);
    }
}
