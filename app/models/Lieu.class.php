<?php declare(strict_types=1);

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
    const TYPE_CONCERT   = 1;
    const TYPE_CAFE      = 2;
    const TYPE_MJC       = 3;
    const TYPE_STUDIO    = 4;
    const TYPE_MEDIA     = 5;
    const TYPE_POLY      = 6;
    const TYPE_EXTERIEUR = 7;
    const TYPE_AFFICHAGE = 8;

    /**
     * Tableau des types de lieux
     *
     * @var array
     */
    protected static $_types = [
        self::TYPE_CONCERT   => "Salle de Concerts",
        self::TYPE_CAFE      => "Café-Concerts/Pub/Péniche",
        self::TYPE_MJC       => "MJC / MPT",
        self::TYPE_STUDIO    => "Studio de répétition/enregistrement",
        self::TYPE_MEDIA     => "Télé/Radio",
        self::TYPE_POLY      => "Salle Polyvalente/communale/des fêtes",
        self::TYPE_EXTERIEUR => "Extérieur",
        self::TYPE_AFFICHAGE => "Panneau d'affichage libre",
    ];

    /**
     *
     */
    protected static $_instance = null;

    /**
     *
     */
    protected static $_pk = 'id_lieu';

    /**
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
     * @var string
     */
    protected $_cp = '';

    /**
     * @var string
     */
    protected $_city = '';

    /**
     * @var string
     */
    protected $_tel = '';

    /**
     * @var string
     */
    protected $_fax = '';

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
     * @var string
     */
    protected $_email = '';

    /**
     * @var int
     */
    protected $_id_contact = 0;

    /**
     * @var string
     */
    protected $_created_on = null;

    /**
     * @var string
     */
    protected $_modified_on = null;

    /**
     * @var float
     */
    protected $_lat = 0;

    /**
     * @var float
     */
    protected $_lng = 0;

    /**
     * @var bool
     */
    protected $_online = false;

    /**
     *
     */
    protected static $_all_fields = [
        'id_type'        => 'num',
        'name'           => 'str',
        'address'        => 'str',
        'cp'             => 'str',
        'city'           => 'str',
        'tel'            => 'str',
        'fax'            => 'str',
        'id_city'        => 'num',
        'id_departement' => 'str',
        'id_region'      => 'str',
        'id_country'     => 'str',
        'text'           => 'str',
        'site'           => 'str',
        'email'          => 'str',
        'id_contact'     => 'num',
        'created_on'     => 'date',
        'modified_on'    => 'date',
        'lat'            => 'float',
        'lng'            => 'float',
        'online'         => 'bool',
    ];

    /**
     *
     */
    protected $_modified_fields = [];

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
     * Retourne le code postal
     *
     * @return string
     */
    function getCp(): string
    {
        return $this->_cp;
    }

    /**
     * Retourne le code postal à partir de l'id_city
     *
     * @return string
     */
    function getCpNew(): string
    {
        return City::getCp($this->_id_city);
    }

    /**
     * Retourne la ville
     *
     * @return string
     */
    function getCity(): string
    {
        return $this->_city;
    }

    /**
     * Retourne le nom de la ville à partir de l'id_city
     *
     * @return string
     */
    function getCityNew(): string
    {
        return City::getName($this->_id_city);
    }

    /**
     * Retourne le téléphone
     *
     * @return string
     */
    function getTel(): string
    {
        return $this->_tel;
    }

    /**
     * Retourne le fax
     *
     * @return string
     */
    function getFax(): string
    {
        return $this->_fax;
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
     * Retourne l'id du département (country FR only)
     *
     * @return string
     */
    function getIdDepartement(): string
    {
        return $this->_id_departement;
    }

    /**
     * Retourne le nom du département
     *
     * @return string
     */
    function getDepartement(): string
    {
        return Departement::getName($this->_id_departement);
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
     * Retourne le nom de la région (avant unification de 201X)
     *
     * @return string
     */
    function getRegion(): string
    {
        return WorldRegion::getName($this->_id_country, $this->_id_region);
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
     * Retourne le nom du pays
     *
     * @return string
     */
    function getCountry(): string
    {
        return WorldCountry::getName($this->_id_country);
    }

    /**
     * Retourne l'url de l'image du drapeau pays
     *
     * @return string
     */
    function getCountryFlagUrl(): string
    {
        return HOME_URL . '/img/flags/' . strtolower($this->_id_country) . '.png';
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
    function getSite()
    {
        if (strpos($this->_site, '.') === false) {
            return false;
        }
        if (strpos($this->_site, 'http://') !== 0) {
            return 'http://' . $this->_site;
        }
        return $this->_site;
    }

    /**
     * Retourne l'email
     *
     * @return string
     */
    function getEmail(): string
    {
        return $this->_email;
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
     * @return float xx.xxxxxx
     */
    function getLat(): float
    {
        return $this->_lat;
    }

    /**
     * Retourne la longitude
     *
     * @return float xx.xxxxxx
     */
    function getLng(): float
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
    function getCreatedOn(): ?string
    {
        if (!is_null($this->_created_on) && Date::isDateTimeOk($this->_created_on)) {
            return $this->_created_on;
        }
        return null;
    }

    /**
     * Retourne la date de création sous forme d'un timestamp
     *
     * @return int
     */
    function getCreatedOnTs(): ?int
    {
        if (!is_null($this->_created_on) && Date::isDateTimeOk($this->_created_on)) {
            return strtotime($this->_created_on);
        }
        return null;
    }

    /**
     * Retourne la date de modification
     *
     * @return string
     */
    function getModifiedOn(): ?string
    {
        if (!is_null($this->_modified_on) && Date::isDateTimeOk($this->_modified_on)) {
            return (string) $this->_modified_on;
        }
        return null;
    }

    /**
     * Retourne la date de modification sous forme d'un timestamp
     *
     * @return int
     */
    function getModifiedOnTs(): ?int
    {
        if (!is_null($this->_modified_on) && Date::isDateTimeOk($this->_modified_on)) {
            return strtotime($this->_modified_on);
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
        return self::getUrlById($this->getId());
    }

    /**
     * Retourne l'url d'une fiche lieu à partir de son id
     *
     * @param int $id id
     *
     * @return string
     */
    static function getUrlById(int $id): string
    {
        return HOME_URL . '/lieux/' . (int) $id;
    }

    /**
     * Retourne l'image de la carte
     *
     * @param string $size    taille
     * @param int    $zoom    zoom
     * @param string $maptype type de carte
     *
     * @return string
     */
    function getMapUrl(string $size = '320x320', int $zoom = 15, string $maptype = 'roadmap')
    {
        return GoogleMaps::getStaticMap(
            [
                'loc'     => $this->getGeocode(),
                'size'    => $size,
                'zoom'    => $zoom,
                'maptype' => $maptype,
            ]
        );
    }

    /**
     * Retourne la distance
     *
     * @return float
     */
    function getDistance(): float
    {
        return $this->_distance;
    }

    /* fin getters */

    /* début setters */

    /**
     * Set le type du lieu
     *
     * @param int $val val
     *
     * @return void
     */
    function setIdType(int $val)
    {
        if ($this->_id_type !== $val) {
            $this->_id_type = $val;
            $this->_modified_fields['id_type'] = true;
        }
    }

    /**
     * Set le nom
     *
     * @param string $val val
     *
     * @return void
     */
    function setName(string $val)
    {
        if ($this->_name !== $val) {
            $this->_name = $val;
            $this->_modified_fields['name'] = true;
        }
    }

    /**
     * Set l'adresse
     *
     * @param string $val val
     *
     * @return void
     */
    function setAddress(string $val)
    {
        if ($this->_address !== $val) {
            $this->_address = $val;
            $this->_modified_fields['address'] = true;
        }
    }

    /**
     * Set le code postal
     *
     * @param string $val val
     *
     * @return void
     */
    function setCp(string $val)
    {
        if ($this->_cp !== $val) {
            $this->_cp = $val;
            $this->_modified_fields['cp'] = true;
        }
    }

    /**
     * Set la ville
     *
     * @param string $val val
     *
     * @return void
     */
    function setCity(string $val)
    {
        if ($this->_city !== $val) {
            $this->_city = $val;
            $this->_modified_fields['city'] = true;
        }
    }

    /**
     * Set le téléphone
     *
     * @param string $val val
     *
     * @return void
     */
    function setTel(string $val)
    {
        if ($this->_tel !== $val) {
            $this->_tel = $val;
            $this->_modified_fields['tel'] = true;
        }
    }

    /**
     * Set le fax
     *
     * @param string $val val
     *
     * @return string
     */
    function setFax(string $val)
    {
        if ($this->_fax !== $val) {
            $this->_fax = $val;
            $this->_modified_fields['fax'] = true;
        }
    }

    /**
     * Set l'id de la ville
     *
     * @param int $val val
     *
     * @return void
     */
    function setIdCity(int $val)
    {
        if ($this->_id_city !== $val) {
            $this->_id_city = $val;
            $this->_modified_fields['id_city'] = true;
        }
    }

    /**
     * Set le département
     *
     * @param string $val val
     *
     * @return void
     */
    function setIdDepartement($val)
    {
        if (is_numeric($val)) {
            $val = str_pad((int) $val, 2, '0', STR_PAD_LEFT);
        } else {
            $val = 'ext';
        }

        if ($this->_id_departement !== $val) {
            $this->_id_departement = $val;
            $this->_modified_fields['id_departement'] = true;
        }
    }

    /**
     * Set la région
     *
     * @param string $val val
     *
     * @return void
     */
    function setIdRegion(string $val)
    {
        if ($this->_id_region !== $val) {
            $this->_id_region = $val;
            $this->_modified_fields['id_region'] = true;
        }
    }

    /**
     * Set le code pays
     *
     * @param string $val val
     *
     * @return void
     */
    function setIdCountry(string $val)
    {
        if ($this->_id_country !== $val) {
            $this->_id_country = $val;
            $this->_modified_fields['id_country'] = true;
        }
    }

    /**
     * Set le texte de présentation
     *
     * @param string $val val
     *
     * @return void
     */
    function setText(string $val)
    {
        if ($this->_text !== $val) {
            $this->_text = $val;
            $this->_modified_fields['text'] = true;
        }
    }

    /**
     * Set le site
     *
     * @param string $val val
     *
     * @return void
     */
    function setSite(string $val)
    {
        if (strpos($val, 'http://') !== 0) {
            $val = 'http://' . $val;
        }
        if ($this->_site !== $val) {
            $this->_site = $val;
            $this->_modified_fields['site'] = true;
        }
    }

    /**
     * Set l'email
     *
     * @param string $val val
     *
     * @return void
     */
    function setEmail(string $val)
    {
        if ($this->_email !== $val) {
            $this->_email = $val;
            $this->_modified_fields['email'] = true;
        }
    }

    /**
     * Set le contact créateur
     *
     * @param int $val val
     *
     * @return void
     */
    function setIdContact(int $val)
    {
        if ($this->_id_contact !== $val) {
            $this->_id_contact = $val;
            $this->_modified_fields['id_contact'] = true;
        }
    }

    /**
     * Set la latitude
     *
     * @param float $val val
     * 
     * @return void
     */
    function setLat(float $val)
    {
        if ($this->_lat !== $val) {
            $this->_lat = $val;
            $this->_modified_fields['lat'] = true;
        }
    }

    /**
     * Set la longitude
     *
     * @param float $val val
     *
     * @return void
     */
    function setLng(float $val)
    {
        if ($this->_lng !== $val) {
            $this->_lng = $val;
            $this->_modified_fields['lng'] = true;
        }
    }

    /**
     * Set la date de création
     *
     * @param string $val val
     *
     * @return void
     */
    function setCreatedOn(string $val)
    {
        if ($this->_created_on !== $val) {
            $this->_created_on = $val;
            $this->_modified_fields['created_on'] = true;
        }
    }

    /**
     * Set la date de création à now
     *
     * @return void
     */
    function setCreatedNow()
    {
        $now = date('Y-m-d H:i:s');
        if ($this->_created_on !== $now) {
            $this->_created_on = (string) $now;
            $this->_modified_fields['created_on'] = true;
        }
    }

    /**
     * Set la date de modification
     *
     * @param string $val val
     *
     * @return void
     */
    function setModifiedOn(string $val)
    {
        if ($this->_modified_on !== $val) {
            $this->_modified_on = $val;
            $this->_modified_fields['modified_on'] = true;
        }
    }

    /**
     * Set la date de modification à now
     *
     * @return void
     */
    function setModifiedNow()
    {
        $now = date('Y-m-d H:i:s');
        if ($this->_modified_on != $now) {
            $this->_modified_on = (string) $now;
            $this->_modified_fields['modified_on'] = true;
        }
    }

    /**
     * Set le switch affiche
     *
     * @param bool $val val
     *
     * @return void
     */
    function setOnline(bool $val)
    {
        if ($this->_online !== $val) {
            $this->_online = $val;
            $this->_modified_fields['online'] = true;
        }
    }

    /* fin setters */

    /**
     * Retourne le nombre de lieux référencés
     *
     * @return int
     */
    static function getLieuxCount(): int
    {
        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(*) "
             . "FROM `" . self::$_db_table_lieu . "`";

        return $db->queryWithFetchFirstField($sql);
    }

    /**
     * Suppression d'un lieu
     *
     * @return bool
     * @throws Exception
     */
    function delete(): bool
    {
        if ($this->hasEvents()) {
            throw new Exception('suppression impossible : lieu avec événements');
        }

        if ($this->hasAudios()) {
            throw new Exception('suppression impossible : lieu avec audios');
        }

        if ($this->hasPhotos()) {
            throw new Exception('suppression impossible : lieu avec photos');
        }

        if ($this->hasVideos()) {
            throw new Exception('suppression impossible : lieu avec videos');
        }

        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . self::$_table . "` "
             . "WHERE `" . self::$_pk . "` = " . (int) $this->getId();

        $db->query($sql);

        if ($db->affectedRows()) {
            $file = self::getBasePath() . '/' . (int) $this->getId() . '.jpg';
            if (file_exists($file)) {
                unlink($file);
            }
            return true;
        }

        return false;
    }

    /**
     * Retourne le tableau de tous les lieux dans un tableau associatif
     * @todo faire comme Photos::getPhotos() <---
     * filtrage par département possible
     *
     * @param array['dep']
     *             ['city']
     *             ['cp']
     *             ['name']
     *             ['type']
     *             ['country']
     * @return array
     */
    static function getLieux($params = [])
    {
        $db = DataBase::getInstance();

        array_key_exists('lat', $_SESSION) ? $lat = $_SESSION['lat'] : $lat = 0;
        array_key_exists('lng', $_SESSION) ? $lng = $_SESSION['lng'] : $lng = 0;

        $sql = "SELECT "
             . "COUNT(DISTINCT `e`.`id_event`) AS `nb_events`, "
             . "`l`.`id_lieu` AS `id`, `l`.`id_type`, `l`.`name`, `l`.`address`, `l`.`cp`, `v`.`cp` AS `cp2`, "
             . "`l`.`city`, `l`.`tel`, `l`.`fax`, `l`.`id_departement`, `d`.`name` AS `departement`, `l`.`text`, "
             . "`l`.`site`, `l`.`email`, `l`.`id_city`, `v`.`name` AS `city2`, `l`.`id_region`, `r`.`name` AS `region`, `l`.`id_country`, `c`.`name_fr` AS `country`, `l`.`created_on`, `l`.`modified_on`, "
             . "FORMAT(get_distance_metres('" . number_format($lat, 8, '.', '') . "', '" . number_format($lng, 8, '.', '') . "', `l`.`lat`, `l`.`lng`) / 1000, 2) AS `distance` "
             . "FROM (`" . self::$_db_table_lieu . "` `l`, `" . self::$_db_table_world_country . "` `c`, `" . self::$_db_table_world_region . "` `r`) "
             . "LEFT JOIN `" . self::$_db_table_fr_departement . "` `d` ON (`l`.`id_departement` = `d`.`id_departement`) "
             . "LEFT JOIN `" . self::$_db_table_fr_city . "` `v` ON (`l`.`id_city` = `v`.`id_city`) "
             . "LEFT JOIN `" . self::$_db_table_event . "` `e` ON (`l`.`id_lieu` = `e`.`id_lieu`) "
             . "WHERE 1 "
             . "AND `l`.`id_country` = `c`.`id_country` "
             . "AND `l`.`id_region` = `r`.`id_region` "
             . "AND `l`.`id_country` = `r`.`id_country` ";

        if (array_key_exists('dep', $params)) {
            $sql .= "AND `l`.`id_departement` = '" . $db->escape($params['dep']) . "' ";
        }
        if (array_key_exists('cp', $params)) {
            $sql .= "AND `l`.`cp` = '" . $db->escape($params['cp']) . "' ";
        }
        if (array_key_exists('city', $params)) {
            $sql .= "AND `l`.`city` LIKE '%" . $db->escape($params['city']) . "%' ";
        }
        if (array_key_exists('name', $params)) {
            $sql .= "AND `l`.`name` LIKE '%" . $db->escape($params['name']) . "%' ";
        }
        if (array_key_exists('type', $params)) {
            $sql .= "AND `l`.`id_type` = " . (int) $params['type'] . " ";
        }
        if (array_key_exists('country', $params)) {
            $sql .= "AND `l`.`id_country` = '" . $db->escape($params['country']) . "' ";
        }

        $sql .= "GROUP BY `l`.`id_lieu` ";
        $sql .= "ORDER by `l`.`id_country` ASC, `l`.`id_region` ASC, `l`.`id_departement` ASC, `v`.`name` ASC";

        return $db->queryWithFetch($sql);
    }

    /**
     * Retourne les lieux d'un département
     */
    static function getLieuxByDep($dep = null)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_lieu` AS `id`, `name`, `id_departement`, "
             . "`address`, `cp`, `city`, `id_city` "
             . "FROM `" . self::$_db_table_lieu . "` "
             . "ORDER BY `id_departement` ASC, `city` ASC, `cp` ASC";

        $res  = $db->queryWithFetch($sql);

        $tab  = [];
        foreach (Departement::getHashTable() as $id_dep => $nom_dep) {
            $tab[$id_dep] = [];
        }
        foreach ($res as $lieu) {
            $tab[$lieu['id_departement']][$lieu['id']] = $lieu;
        }

        if (!is_null($dep) && array_key_exists($dep, $tab)) {
            return $tab[$dep];
        }

        return $tab;
    }

    /**
     * Retourne les infos sur un lieu
     *
     * @return bool
     */
    protected function _loadFromDb()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_lieu` AS `id`, `id_type`, `name`, `address`, "
             . " `cp`, `city`, `tel`, `fax`, `text`, `site`, `email`, "
             . " `id_city`, `id_departement`, `id_region`, `id_country`, `lat`, `lng`, "
             . " `id_contact`, `online`, "
             . "`created_on`, `modified_on` "
             . "FROM `" . self::$_db_table_lieu . "` `l` "
             . "WHERE `id_lieu` = " . (int) $this->_id_lieu;

        if (($res = $db->queryWithFetchFirstRow($sql)) == false) {
            throw new Exception('id_lieu introuvable');
        }

        $this->_dbToObject($res);

        if (file_exists(self::getBasePath() . '/' . $this->_id_lieu . '.jpg')) {
            $this->_photo = self::getBaseUrl() . '/' . $this->_id_lieu . '.jpg';
        } else {
            $this->_photo = null;
        }

        return true;
    }

    /**
     * Retourne la photo principale du lieu
     *
     * @return string|null
     */
    function getPhoto(): ?string
    {
        if (file_exists(self::getBasePath() . '/' . $this->getId() . '.jpg')) {
            return self::getBaseUrl() . '/' . $this->getId() . '.jpg';
        }
        return null;
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
        return Photo::getPhotos(
            [
                'lieu' => $this->_id_lieu,
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
    function getVideos()
    {
        return Video::getVideos(
            [
                'lieu' => $this->_id_lieu,
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
    function getAudios()
    {
        return Audio::getAudios(
            [
                'lieu' => $this->_id_lieu,
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
    function getEvents()
    {
        return Event::getEvents(
            [
                'lieu' => $this->_id_lieu,
                'sort' => 'date',
                'sens' => 'DESC',
            ]
        );
    }

    /**
     * @return int
     */
    static function getMyLieuxCount(): int
    {
        if (empty($_SESSION['membre'])) {
            throw new Exception('non identifié');
        }

        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(*) "
             . "FROM `" . self::$_db_table_lieu . "` "
             . "WHERE `id_contact` = " . (int) $_SESSION['membre']->getId();

        return $db->queryWithFetchFirstField($sql);
    }

    /**
     * Retourne les types de lieux
     *
     * @return array
     */
    static function getTypes(): array
    {
        return self::$_types;
    }

    /**
     * Retourne le libellé d'un type de lieu
     *
     * @param int $cle cle
     *
     * @return string
     */
    static function getTypeName(int $cle)
    {
        if (array_key_exists($cle, self::$_types)) {
            return self::$_types[$cle];
        }
        return false;
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

        $sql = "SELECT `l`.`id_lieu`, `l`.`name`, `l`.`address`, `v`.`cp`, `l`.`cp` AS `old_cp`, `v`.`name` AS `city`, `l`.`city` AS `old_city`, `l`.`lat`, `l`.`lng`, "
             . "FORMAT(get_distance_metres('" . number_format($lat, 8, '.', '') . "', '" . number_format($lng, 8, '.', '') . "', `l`.`lat`, `l`.`lng`) / 1000, 2) AS `distance` "
             . "FROM (`adhoc_lieu` `l`) "
             . "LEFT JOIN `geo_fr_city` `v` ON (`l`.`id_city` = `v`.`id_city`) "
             . "HAVING `distance` < " . number_format(($distance / 1000), 8, '.', '') . " ";
        if ($sort == 'rand') {
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

        $sql = "SELECT `l`.`id_lieu`, `l`.`name`, `l`.`address`, `v`.`cp`, `l`.`cp` AS `old_cp`, `v`.`name` AS `city`, `l`.`city` AS `old_city`, `l`.`lat`, `l`.`lng`, "
             . "FORMAT(get_distance_metres('" . number_format($lat, 8, '.', '') . "', '" . number_format($lng, 8, '.', '') . "', `l`.`lat`, `l`.`lng`) / 1000, 2) AS `distance` "
             . "FROM (`adhoc_lieu` `l`) "
             . "LEFT JOIN `geo_fr_city` `v` ON (`l`.`id_city` = `v`.`id_city`) "
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

        $sql = "SELECT `l`.`id_lieu`, `l`.`name`, `l`.`address`, `v`.`cp`, `l`.`cp` AS `old_cp`, `v`.`name` AS `city`, `l`.`city` AS `old_city`, `l`.`lat`, `l`.`lng` "
             . "FROM (`adhoc_lieu` `l`) "
             . "LEFT JOIN `geo_fr_city` `v` ON (`l`.`id_city` = `v`.`id_city`) "
             . "WHERE 1 "
             . "AND `l`.`id_country` = '" . $db->escape($id_country) . "' "
             . "AND `l`.`id_region` = '" . $db->escape($id_region) . "' "
             . "AND `l`.`id_departement` = '" . $db->escape($id_departement) . "' "
             . "ORDER BY `l`.`id_country` ASC, `l`.`id_region` ASC, `l`.`id_departement` ASC "
             . "LIMIT 0, " . $limit;

        return $db->queryWithFetch($sql);
    }
}
