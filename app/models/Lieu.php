<?php declare(strict_types=1);

use Reference\City;
use Reference\Departement;
use Reference\LieuType;
use Reference\WorldCountry;
use Reference\WorldRegion;

/**
 * Classe Lieu
 *
 * Gestion des Lieux de diffusions
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Lieu extends ObjectModel
{
    /**
     * Instance de l'objet
     *
     * @var object
     */
    protected static $_instance = null;

    /**
     * Nom de la clé primaire
     *
     * @var string
     */
    protected static $_pk = 'id_lieu';

    /**
     * Nom de la table
     *
     * @var string
     */
    protected static $_table = 'adhoc_lieu';

    /**
     * @var int
     */
    protected $_id_lieu = 0;

    /**
     * @var int
     */
    protected $_id_type = 0;

    /**
     * @var string
     */
    protected $_name = '';

    /**
     * @var string
     */
    protected $_address = '';

    /**
     * @var int
     */
    protected $_id_city = '';

    /**
     * @var string
     */
    protected $_id_departement = '';

    /**
     * @var string
     */
    protected $_id_region = '';

    /**
     * @var string
     */
    protected $_id_country = '';

    /**
     * @var string
     */
    protected $_text = '';

    /**
     * @var string
     */
    protected $_site = '';

    /**
     * @var int
     */
    protected $_id_contact = 0;

    /**
     * @var string
     */
    protected $_created_at = null;

    /**
     * @var string
     */
    protected $_modified_at = null;

    /**
     * @var float|null
     */
    protected $_lat = null;

    /**
     * @var float|null
     */
    protected $_lng = null;

    /**
     * @var bool
     */
    protected $_online = false;

    /**
     * @var string
     */
    protected $_photo_url = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static $_all_fields = [
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
    static function getBaseUrl(): string
    {
        return MEDIA_URL . '/lieu';
    }

    /**
     * @return string
     */
    static function getBasePath(): string
    {
        return MEDIA_PATH . '/lieu';
    }

    /**
     * Retourne l'id du lieu
     *
     * @return int
     */
    function getIdLieu(): int
    {
        return $this->_id_lieu;
    }

    /**
     * Retourne l'id type du lieu
     *
     * @return int
     */
    function getIdType(): int
    {
        return $this->_id_type;
    }

    /**
     * Retourne le libellé du type de lieu
     *
     * @return string
     */
    function getType(): string
    {
        return self::getTypeName($this->_id_type);
    }

    /**
     * Retourne le nom d'un lieu
     *
     * @return string
     */
    function getName(): string
    {
        return $this->_name;
    }

    /**
     * Retourne l'adresse
     *
     * @return string
     */
    function getAddress(): string
    {
        return $this->_address;
    }

    /**
     * Retourne l'id de la ville (country FR only)
     * ça correspond au code insee
     *
     * @return int
     */
    function getIdCity(): int
    {
        return $this->_id_city;
    }

    /**
     * Retourne la ville
     *
     * @return object
     */
    function getCity(): object
    {
        return City::getInstance($this->getIdCity());
    }

    /**
     * Retourne l'id du département (country FR only)
     *
     * @return string
     */
    function getIdDepartement(): string
    {
        return $this->_id_departement;
    }

    /**
     * Retourne l'objet département
     *
     * @return object
     */
    function getDepartement(): object
    {
        return Departement::getInstance($this->getIdDepartement());
    }

    /**
     * Retourne l'id de la région (avant unification de 201X)
     *
     * @return string
     */
    function getIdRegion(): string
    {
        return $this->_id_region;
    }

    /**
     * Retourne l'objet région
     *
     * @return object
     */
    function getRegion(): object
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
    function getIdCountry(): string
    {
        return $this->_id_country;
    }

    /**
     * Retourne l'objet country
     *
     * @return object
     */
    function getCountry(): object
    {
        return WorldCountry::getInstance($this->getIdCountry());
    }

    /**
     * Retourne le texte de présentation
     *
     * @return string
     */
    function getText(): string
    {
        return $this->_text;
    }

    /**
     * Retourne le site
     *
     * @return string
     */
    function getSite(): string
    {
        return $this->_site;
    }

    /**
     * Retourne le contact créateur
     *
     * @return int
     */
    function getIdContact(): int
    {
        return $this->_id_contact;
    }

    /**
     * Retourne la latitude
     *
     * @return float xx.xxxxxx | null
     */
    function getLat(): ?float
    {
        return $this->_lat;
    }

    /**
     * Retourne la longitude
     *
     * @return float xx.xxxxxx | null
     */
    function getLng(): ?float
    {
        return $this->_lng;
    }

    /**
     * Retourne les coordonnées utilisable
     * par Google Maps. ex: X.XXXXXX,Y.YYYYYY
     *
     * @return string
     */
    function getGeocode(): string
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
     * @return string|null
     */
    function getCreatedAt(): ?string
    {
        if (!is_null($this->_created_at) && Date::isDateTimeOk($this->_created_at)) {
            return $this->_created_at;
        }
        return null;
    }

    /**
     * Retourne la date de création sous forme d'un timestamp
     *
     * @return int
     */
    function getCreatedAtTs(): ?int
    {
        if (!is_null($this->_created_at) && Date::isDateTimeOk($this->_created_at)) {
            return strtotime($this->_created_at);
        }
        return null;
    }

    /**
     * Retourne la date de modification
     *
     * @return string
     */
    function getModifiedAt(): ?string
    {
        if (!is_null($this->_modified_at) && Date::isDateTimeOk($this->_modified_at)) {
            return (string) $this->_modified_at;
        }
        return null;
    }

    /**
     * Retourne la date de modification sous forme d'un timestamp
     *
     * @return int
     */
    function getModifiedAtTs(): ?int
    {
        if (!is_null($this->_modified_at) && Date::isDateTimeOk($this->_modified_at)) {
            return strtotime($this->_modified_at);
        }
        return null;
    }

    /**
     * Retourne le switch affiche
     *
     * @return bool
     */
    function getOnline(): bool
    {
        return $this->_online;
    }

    /**
     * Retourne l'url de la fiche d'un lieu
     *
     * @return string
     */
    function getUrl(): string
    {
        return HOME_URL . '/lieux/' . $this->getIdLieu();
    }

    /**
     * Retourne la distance (à la position actuelle si renseignée)
     *
     * @return float
     */
    function getDistance(): float
    {
        return $this->_distance;
    }

    /**
     * Retourne l'url de la photo du lieu
     *
     * @return string|null
     */
    function getPhotoUrl(): ?string
    {
        return $this->_photo_url;
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
    function setIdType(int $id_type): object
    {
        if ($this->_id_type !== $id_type) {
            $this->_id_type = $id_type;
            $this->_modified_fields['id_type'] = true;
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
    function setName(string $name): object
    {
        if ($this->_name !== $name) {
            $this->_name = $name;
            $this->_modified_fields['name'] = true;
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
    function setAddress(string $address): object
    {
        if ($this->_address !== $address) {
            $this->_address = $address;
            $this->_modified_fields['address'] = true;
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
    function setIdCity(int $id_city): object
    {
        if ($this->_id_city !== $id_city) {
            $this->_id_city = $id_city;
            $this->_modified_fields['id_city'] = true;
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
    function setIdDepartement(string $id_departement): object
    {
        if (is_numeric($id_departement)) {
            $id_departement = str_pad($id_departement, 2, '0', STR_PAD_LEFT);
        } else {
            $id_departement = 'ext';
        }

        if ($this->_id_departement !== $id_departement) {
            $this->_id_departement = $id_departement;
            $this->_modified_fields['id_departement'] = true;
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
    function setIdRegion(string $id_region): object
    {
        if ($this->_id_region !== $id_region) {
            $this->_id_region = $id_region;
            $this->_modified_fields['id_region'] = true;
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
    function setIdCountry(string $id_country): object
    {
        if ($this->_id_country !== $id_country) {
            $this->_id_country = $id_country;
            $this->_modified_fields['id_country'] = true;
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
    function setText(string $text): object
    {
        if ($this->_text !== $text) {
            $this->_text = $text;
            $this->_modified_fields['text'] = true;
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
    function setSite(string $site): object
    {
        if ($this->_site !== $site) {
            $this->_site = $site;
            $this->_modified_fields['site'] = true;
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
    function setIdContact(int $id_contact): object
    {
        if ($this->_id_contact !== $id_contact) {
            $this->_id_contact = $id_contact;
            $this->_modified_fields['id_contact'] = true;
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
    function setLat(float $lat): object
    {
        if ($this->_lat !== $lat) {
            $this->_lat = $lat;
            $this->_modified_fields['lat'] = true;
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
    function setLng(float $lng): object
    {
        if ($this->_lng !== $lng) {
            $this->_lng = $lng;
            $this->_modified_fields['lng'] = true;
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
    function setCreatedAt(string $created_at): object
    {
        if ($this->_created_at !== $created_at) {
            $this->_created_at = $created_at;
            $this->_modified_fields['created_at'] = true;
        }

        return $this;
    }

    /**
     * Set la date de création à now
     *
     * @return object
     */
    function setCreatedNow(): object
    {
        $now = date('Y-m-d H:i:s');

        if ($this->_created_at !== $now) {
            $this->_created_at = $now;
            $this->_modified_fields['created_at'] = true;
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
    function setModifiedAt(string $modified_at): object
    {
        if ($this->_modified_at !== $modified_at) {
            $this->_modified_at = $modified_at;
            $this->_modified_fields['modified_at'] = true;
        }

        return $this;
    }

    /**
     * Set la date de modification à now
     *
     * @return object
     */
    function setModifiedNow(): object
    {
        $now = date('Y-m-d H:i:s');

        if ($this->_modified_at != $now) {
            $this->_modified_at = $now;
            $this->_modified_fields['modified_at'] = true;
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
    function setOnline(bool $online): object
    {
        if ($this->_online !== $online) {
            $this->_online = $online;
            $this->_modified_fields['online'] = true;
        }

        return $this;
    }

    /* fin setters */

    /**
     * Suppression d'un lieu
     *
     * @return bool
     * @throws Exception
     */
    function delete(): bool
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
    static function find(array $params): array
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

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$_all_fields))))) {
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
    static function getLieuxByDep(string $id_departement = null): array
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

        function sortLieuByCityName($a, $b) {
            if ($a->getCity()->getName() === $b->getCity()->getName()) {
                return 0;
            }
            return ($a->getCity()->getName() < $b->getCity()->getName()) ? -1 : 1;
        }

        // tri par nom de ville
        foreach (array_keys($tab) as $dep) {
            usort($tab[$dep], 'sortLieuByCityName');
        }

        if (!is_null($id_departement) && array_key_exists($id_departement, $tab)) {
            return $tab[$id_departement];
        }
        return $tab;
    }

    /**
     * Retourne les infos sur un lieu
     *
     * @return bool
     * @throws Exception
     */
    protected function _loadFromDb(): bool
    {
        if (!parent::_loadFromDb()) {
            throw new Exception('lieu introuvable');
        }

        if (file_exists(self::getBasePath() . '/' . (string) $this->getIdLieu() . '.jpg')) {
            $this->_photo_url = self::getBaseUrl() . '/' . (string) $this->getIdLieu() . '.jpg';
        }

        return true;
    }

    /**
     * @return bool
     */
    function hasPhotos(): bool
    {
        return (count($this->getPhotos()) > 0);
    }

    /**
     * Retourne les photos associées à ce lieu
     *
     * @return array
     */
    function getPhotos(): array
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
    function hasVideos(): bool
    {
        return (count($this->getVideos()) > 0);
    }

    /**
     * Retourne les vidéos associées à ce lieu
     *
     * @return array
     */
    function getVideos(): array
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
    function hasAudios(): bool
    {
        return (count($this->getAudios()) > 0);
    }

    /**
     * Retourne les audios associés à ce lieu
     *
     * @return array
     */
    function getAudios(): array
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
    function hasEvents(): bool
    {
        return (count($this->getEvents()) > 0);
    }

    /**
     * Retourne les événements rattachés au lieu
     *
     * @return array
     */
    function getEvents(): array
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
    static function getTypes(): array
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
    static function getTypeName(int $id_lieu_type)
    {
        return LieuType::getInstance($id_lieu_type)->getName();
    }

    /**
     * Procédure stockée MySQL pour le calcul de distances
     *
     * @todo debuguer car ca passe pas
     */
    static function mysql_init_geo()
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
    static function fetchLieuxByRadius(array $params): array
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
    static function fetchLieuxByBoundary(array $params): array
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
    static function fetchLieuxByAdmin(array $params): array
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
