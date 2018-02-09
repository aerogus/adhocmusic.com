<?php

/**
 * @package adhoc
 */

/**
 * Classe Lieu
 *
 * Gestion des Lieux de diffusions
 *
 * @package adhoc
 * @author Guillaume Seznec <guillaume.seznec@gmail.com>
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
    protected static $_types = array(
        self::TYPE_CONCERT   => "Salle de Concerts",
        self::TYPE_CAFE      => "Café-Concerts/Pub/Péniche",
        self::TYPE_MJC       => "MJC / MPT",
        self::TYPE_STUDIO    => "Studio de répétition/enregistrement",
        self::TYPE_MEDIA     => "Télé/Radio",
        self::TYPE_POLY      => "Salle Polyvalente/communale/des fêtes",
        self::TYPE_EXTERIEUR => "Extérieur",
        self::TYPE_AFFICHAGE => "Panneau d'affichage libre",
    );

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
    protected $_created_on = NULL;

    /**
     * @var string
     */
    protected $_modified_on = NULL;

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
    protected static $_all_fields = array(
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
    );

    /**
     *
     */
    protected $_modified_fields = [];

    /* début getters */

    /**
     * @return string
     */
    static function getBaseUrl()
    {
        return MEDIA_URL . '/lieu';
    }

    /**
     * @return string
     */
    static function getBasePath()
    {
        return MEDIA_PATH . '/lieu';
    }

    /**
     * retourne l'id type du lieu
     *
     * @return int
     */
    function getIdType()
    {
        return (int) $this->_id_type;
    }

    /**
     * retourne le libellé du type de lieu
     *
     * @return (string)
     */
    function getType()
    {
        return (string) self::getTypeName($this->_id_type);
    }

    /**
     * retourne le nom d'un lieu
     *
     * @return string
     */
    function getName()
    {
        return (string) $this->_name;
    }

    /**
     * retourne l'adresse
     *
     * @return string
     */
    function getAddress()
    {
        return (string) $this->_address;
    }

    /**
     * retourne le code postal
     *
     * @return string
     */
    function getCp()
    {
        return (string) $this->_cp;
    }

    /**
     * retourne le code postal à partir de l'id_city
     *
     * @return string
     */
    function getCpNew()
    {
        return (string) City::getCp($this->_id_city);
    }

    /**
     * retourne la ville
     *
     * @return string
     */
    function getCity()
    {
        return (string) $this->_city;
    }

    /**
     * retourne le nom de la ville à partir de l'id_city
     *
     * @return string
     */
    function getCityNew()
    {
        return (string) City::getName($this->_id_city);
    }

    /**
     * retourne le téléphone
     *
     * @return string
     */
    function getTel()
    {
        return (string) $this->_tel;
    }

    /**
     * retourne le fax
     *
     * @return string
     */
    function getFax()
    {
        return (string) $this->_fax;
    }

    /**
     * retourne l'id de la ville (country FR only)
     * ça correspond au code insee
     *
     * @return int
     */
    function getIdCity()
    {
        return (int) $this->_id_city;
    }

    /**
     * retourne l'id du département (country FR only)
     *
     * @return string
     */
    function getIdDepartement()
    {
        return (string) $this->_id_departement;
    }

    /**
     * retourne le nom du département
     *
     * @return string
     */
    function getDepartement()
    {
        return (string) Departement::getName($this->_id_departement);
    }

    /**
     * retourne l'id de la région
     *
     * @return string
     */
    function getIdRegion()
    {
        return (string) $this->_id_region;
    }

    /**
     * retourne le nom de la région
     *
     * @return string
     */
    function getRegion()
    {
        return (string) WorldRegion::getName($this->_id_country, $this->_id_region);
    }

    /**
     * retourne le code pays
     *
     * @return string
     */
    function getIdCountry()
    {
        return (string) $this->_id_country;
    }

    /**
     * retourne le nom du pays
     *
     * @return string
     */
    function getCountry()
    {
        return (string) WorldCountry::getName($this->_id_country);
    }

    /**
     * retourne l'url de l'image du drapeau pays
     *
     * @return string
     */
    function getCountryFlagUrl()
    {
        return HOME_URL . '/img/flags/' . strtolower($this->_id_country) . '.png';
    }

    /**
     * retourne le texte de présentation
     *
     * @return string
     */
    function getText()
    {
        return (string) $this->_text;
    }

    /**
     * retourne le site
     *
     * @return string
     */
    function getSite()
    {
        if(strpos($this->_site, '.') === false) {
            return false;
        }
        if(strpos($this->_site, 'http://') !== 0) {
            return 'http://' . $this->_site;
        }
        return $this->_site;
    }

    /**
     * retourne l'email
     *
     * @return string
     */
    function getEmail()
    {
        return (string) $this->_email;
    }

    /**
     * retourne le contact créateur
     *
     * @return string
     */
    function getIdContact()
    {
        return (int) $this->_id_contact;
    }

    /**
     * retourne la latitude
     *
     * @return float xx.xxxxxx
     */
    function getLat()
    {
        return (float) $this->_lat;
    }

    /**
     * retourne la longitude
     *
     * @return float xx.xxxxxx
     */
    function getLng()
    {
        return (float) $this->_lng;
    }

    /**
     * retourne les coordonnées utilisable
     * par google maps
     *
     * @return string
     */
    function getGeocode()
    {
        if($this->getLat() && $this->getLng()) {
            return number_format($this->getLat(), 6, '.', '')
                 . ','
                 . number_format($this->getLng(), 6, '.', '');
        }
        return '';
    }

    /**
     * retourne la date de création
     *
     * @return string
     */
    function getCreatedOn()
    {
        if(Date::isDateTimeOk($this->_created_on)) {
            return (string) $this->_created_on;
        }
        return false;
    }

    /**
     * retourne la date de création sous forme d'un timestamp
     *
     * @return int
     */
    function getCreatedOnTs()
    {
        if(Date::isDateTimeOk($this->_created_on)) {
            return (int) strtotime($this->_created_on);
        }
        return false;
    }

    /**
     * retourne la date de modification
     *
     * @return string
     */
    function getModifiedOn()
    {
        if(Date::isDateTimeOk($this->_modified_on)) {
            return (string) $this->_modified_on;
        }
        return false;
    }

    /**
     * retourne la date de modification sous forme d'un timestamp
     *
     * @return int
     */
    function getModifiedOnTs()
    {
        if(Date::isDateTimeOk($this->_modified_on)) {
            return (int) strtotime($this->_modified_on);
        }
        return false;
    }

    /**
     * retourne le switch affiche
     *
     * @return bool
     */
    function getOnline()
    {
        return (bool) $this->_online;
    }

    /**
     * Retourne l'url de la fiche d'un lieu
     *
     * @return string
     */
    function getUrl()
    {
        return self::getUrlById($this->getId());
    }

    /**
     * Retourne l'url d'une fiche lieu à partir de son id
     *
     * @param int $id
     * @return string
     */
    static function getUrlById($id)
    {
        return HOME_URL . '/lieux/' . (int) $id;
    }

    /**
     * retourne l'image de la carte
     *
     * @return string
     */
    function getMapUrl($size = '320x320', $zoom = 15, $maptype = 'roadmap')
    {
        return GoogleMaps::getStaticMap(array(
            'loc'     => $this->getGeocode(),
            'size'    => $size,
            'zoom'    => $zoom,
            'maptype' => $maptype,
        ));
    }

    /**
     * @return float
     */
    function getDistance()
    {
        return (float) $this->_distance;
    }

    /* fin getters */

    /* début setters */

    /**
     * set le type du lieu
     *
     * @param int $id_type
     */
    function setIdType($val)
    {
        if ($this->_id_type !== $val) {
            $this->_id_type = (int) $val;
            $this->_modified_fields['id_type'] = true;
        }
    }

    /**
     * set le nom
     *
     * @param string $nom
     */
    function setName($val)
    {
        if ($this->_name !== $val) {
            $this->_name = (string) $val;
            $this->_modified_fields['name'] = true;
        }
    }

    /**
     * set l'adresse
     *
     * @param string $cp
     */
    function setAddress($val)
    {
        if ($this->_address !== $val) {
            $this->_address = $val;
            $this->_modified_fields['address'] = true;
        }
    }

    /**
     * set le code postal
     *
     * @param string $cp
     */
    function setCp($val)
    {
        if ($this->_cp !== $val) {
            $this->_cp = (string) $val;
            $this->_modified_fields['cp'] = true;
        }
    }

    /**
     * set la ville
     *
     * @param string $ville
     */
    function setCity($val)
    {
        if ($this->_city !== $val) {
            $this->_city = (string) $val;
            $this->_modified_fields['city'] = true;
        }
    }

    /**
     * set le téléphone
     *
     * @return string $tel
     */
    function setTel($val)
    {
        if ($this->_tel !== $val) {
            $this->_tel = $val;
            $this->_modified_fields['tel'] = true;
        }
    }

    /**
     * set le fax
     *
     * @return string $fax
     */
    function setFax($val)
    {
        if ($this->_fax !== $val) {
            $this->_fax = (string) $val;
            $this->_modified_fields['fax'] = true;
        }
    }

    /**
     * set l'id de la ville
     *
     * @param int $id_city
     */
    function setIdCity($val)
    {
        if ($this->_id_city !== $val) {
            $this->_id_city = (int) $val;
            $this->_modified_fields['id_city'] = true;
        }
    }

    /**
     * set le département
     *
     * @param string $id_departement
     */
    function setIdDepartement($val)
    {
        if(is_numeric($val)) {
            $val = str_pad((int) $val, 2, "0", STR_PAD_LEFT);
        } else {
            $val = 'ext';
        }

        if ($this->_id_departement !== $val) {
            $this->_id_departement = $val;
            $this->_modified_fields['id_departement'] = true;
        }
    }

    /**
     * set la région
     *
     * @param string $id_region
     */
    function setIdRegion($val)
    {
        if ($this->_id_region !== $val) {
            $this->_id_region = (string) $val;
            $this->_modified_fields['id_region'] = true;
        }
    }

    /**
     * set le code pays
     *
     * @param string $pays
     */
    function setIdCountry($val)
    {
        if ($this->_id_country !== $val) {
            $this->_id_country = (string) $val;
            $this->_modified_fields['id_country'] = true;
        }
    }

    /**
     * set le texte de présentation
     *
     * @param string $texte
     */
    function setText($val)
    {
        if ($this->_text !== $val) {
            $this->_text = $val;
            $this->_modified_fields['text'] = true;
        }
    }

    /**
     * set le site
     *
     * @param string $site
     */
    function setSite($val)
    {
        if(strpos($val, 'http://') !== 0) {
            $val = 'http://' . $val;
        }
        if ($this->_site !== $val) {
            $this->_site = $val;
            $this->_modified_fields['site'] = true;
        }
    }

    /**
     * set l'email
     *
     * @param string $email
     */
    function setEmail($val)
    {
        if ($this->_email !== $val) {
            $this->_email = $val;
            $this->_modified_fields['email'] = true;
        }
    }

    /**
     * set le contact créateur
     *
     * @param int
     */
    function setIdContact($val)
    {
        if ($this->_id_contact !== $val) {
            $this->_id_contact = $val;
            $this->_modified_fields['id_contact'] = true;
        }
    }

    /**
     * set la latitude
     *
     * @param float $lat
     */
    function setLat($val)
    {
        if ($this->_lat !== $val) {
            $this->_lat = (float) $val;
            $this->_modified_fields['lat'] = true;
        }
    }

    /**
     * set la longitude
     *
     * @param float $lng
     */
    function setLng($val)
    {
        if ($this->_lng !== $val) {
            $this->_lng = (float) $val;
            $this->_modified_fields['lng'] = true;
        }
    }

    /**
     * set la date de création
     *
     * @param string
     */
    function setCreatedOn($val)
    {
        if ($this->_created_on !== $val) {
            $this->_created_on = (string) $val;
            $this->_modified_fields['created_on'] = true;
        }
    }

    /**
     * set la date de création à now
     *
     * @param string
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
     * set la date de modification
     *
     * @param string
     */
    function setModifiedOn($val)
    {
        if ($this->_modified_on !== $val) {
            $this->_modified_on = (string) $val;
            $this->_modified_fields['modified_on'] = true;
        }
    }

    /**
     * set la date de modification à now
     *
     * @param string
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
     * set le switch affiche
     *
     * @return bool $affiche
     */
    function setOnline($val)
    {
        if ($this->_online !== $val) {
            $this->_online = (bool) $val;
            $this->_modified_fields['online'] = true;
        }
    }

    /* fin setters */

    /**
     * retourne le nombre de lieux référencés
     *
     * @return int
     */
    static function getLieuxCount()
    {
        $db = DataBase::getInstance();

        if(isset($_SESSION['global_counters']['nb_lieux'])) {
            return $_SESSION['global_counters']['nb_lieux'];
        }

        $sql = "SELECT COUNT(*) "
             . "FROM `" . self::$_db_table_lieu . "`";

        $nb_lieux = $db->queryWithFetchFirstField($sql);

        $_SESSION['global_counters']['nb_lieux'] = $nb_lieux;

        return $_SESSION['global_counters']['nb_lieux'];
    }

    /**
     * Suppression d'un lieu
     *
     * @param int $id_lieu
     * @return bool
     */
    function delete()
    {
        if($this->hasEvents()) {
            throw new Exception('suppression impossible : lieu avec événements');
        }

        if($this->hasAudios()) {
            throw new Exception('suppression impossible : lieu avec audios');
        }

        if($this->hasPhotos()) {
            throw new Exception('suppression impossible : lieu avec photos');
        }

        if($this->hasVideos()) {
            throw new Exception('suppression impossible : lieu avec videos');
        }

        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . self::$_table . "` "
             . "WHERE `" . self::$_pk . "` = " . (int) $this->getId();

        $db->query($sql);

        if($db->affectedRows()) {
            $file = self::getBasePath() . '/' . (int) $this->getId() . '.jpg';
            if(file_exists($file)) {
                unlink($file);
            }
            return true;
        }

        return false;
    }

    /**
     * retourne le tableau de tous les lieux dans un tableau associatif
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

        if(array_key_exists('dep', $params))     { $sql .= "AND `l`.`id_departement` = '" . $db->escape($params['dep']) . "' "; }
        if(array_key_exists('cp', $params))      { $sql .= "AND `l`.`cp` = '" . $db->escape($params['cp']) . "' "; }
        if(array_key_exists('city', $params))    { $sql .= "AND `l`.`city` LIKE '%" . $db->escape($params['city']) . "%' "; }
        if(array_key_exists('name', $params))    { $sql .= "AND `l`.`name` LIKE '%" . $db->escape($params['name']) . "%' "; }
        if(array_key_exists('type', $params))    { $sql .= "AND `l`.`id_type` = " . (int) $params['type'] . " "; }
        if(array_key_exists('country', $params)) { $sql .= "AND `l`.`id_country` = '" . $db->escape($params['country']) . "' "; }

        $sql .= "GROUP BY `l`.`id_lieu` ";
        $sql .= "ORDER by `l`.`id_country` ASC, `l`.`id_region` ASC, `l`.`id_departement` ASC, `v`.`name` ASC";

        return $db->queryWithFetch($sql);
    }

    /**
     *
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
        foreach(Departement::getHashTable() as $id_dep => $nom_dep) {
            $tab[$id_dep] = [];
        }
        foreach($res as $lieu) {
            $tab[$lieu['id_departement']][$lieu['id']] = $lieu;
        }

        if(!is_null($dep) && array_key_exists($dep, $tab)) {
            return $tab[$dep];
        }

        return $tab;
    }

    /**
     * retourne les infos sur une structure
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
             . "`created_on`, `modified_on`, "
             . "FORMAT(get_distance_metres('" . number_format((float)$_SESSION['lat'], 8, '.', '') . "', '" . number_format((float)$_SESSION['lng'], 8, '.', '') . "', `l`.`lat`, `l`.`lng`) / 1000, 2) AS `distance` "
             . "FROM `" . self::$_db_table_lieu . "` `l` "
             . "WHERE `id_lieu` = " . (int) $this->_id_lieu;

        if(($res = $db->queryWithFetchFirstRow($sql)) == false) {
            throw new Exception('id_lieu introuvable');
        }

        $this->_dbToObject($res);

        $this->_distance = $res['distance'];

        if(file_exists(self::getBasePath() . '/' . $this->_id_lieu . '.jpg')) {
            $this->_photo = self::getBaseUrl() . '/' . $this->_id_lieu . '.jpg';
        } else {
            $this->_photo = null;
        }

        return true;
    }

    /**
     * retourne la photo principale du lieu
     *
     * @return string
     */
    function getPhoto()
    {
        if(file_exists(self::getBasePath() . '/' . $this->getId() . '.jpg')) {
            return self::getBaseUrl() . '/' . $this->getId() . '.jpg';
        }
        return false;
    }

    /**
     * @return bool
     */
    function hasPhotos()
    {
        return (bool) count($this->getPhotos());
    }

    /**
     * retourne les photos associées à ce lieu
     *
     * @return array
     */
    function getPhotos()
    {
        return Photo::getPhotos(array(
            'lieu' => $this->_id_lieu,
        ));
    }

    /**
     * @return bool
     */
    function hasVideos()
    {
        return (bool) count($this->getVideos());
    }

    /**
     * retourne les vidéos associées à ce lieu
     *
     * @return array
     */
    function getVideos()
    {
        return Video::getVideos(array(
            'lieu' => $this->_id_lieu,
        ));
    }

    /**
     * @return bool
     */
    function hasAudios()
    {
        return (bool) count($this->getAudios());
    }

    /**
     * retourne les audios associés à ce lieu
     *
     * @return array
     */
    function getAudios()
    {
        return Audio::getAudios(array(
            'lieu' => $this->_id_lieu,
        ));
    }

    /**
     * @return bool
     */
    function hasEvents()
    {
        return (bool) count($this->getEvents());
    }

    /**
     * retourne les événements rattachés au lieu
     *
     * @return array
     */
    function getEvents()
    {
        return Event::getEvents(array(
            'lieu' => $this->_id_lieu,
            'sort' => 'date',
            'sens' => 'DESC',
        ));
    }

    /**
     * @return int
     */
    static function getMyLieuxCount()
    {
        if(empty($_SESSION['membre'])) {
            throw new Exception('non identifié');
        }

        if(isset($_SESSION['my_counters']['nb_lieux'])) {
            return $_SESSION['my_counters']['nb_lieux'];
        }

        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(*) "
             . "FROM `" . self::$_db_table_lieu . "` "
             . "WHERE `id_contact` = " . (int) $_SESSION['membre']->getId();

        $nb_lieux = $db->queryWithFetchFirstField($sql);

        $_SESSION['my_counters']['nb_lieux'] = $nb_lieux;

        return $_SESSION['my_counters']['nb_lieux'];
    }

    /**
     * retourne les types de lieux
     *
     * @return array
     */
    static function getTypes()
    {
        return self::$_types;
    }

    /**
     * retourne le libellé d'un type de lieu
     *
     * @param int
     * @return string
     */
    static function getTypeName($cle)
    {
        if(array_key_exists($cle, self::$_types)) {
            return self::$_types[$cle];
        }
        return false;
    }

    /**
     * procédure stockée MySQL pour le calcul de distances
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
     * récupère les lieux autour d'un point et d'un rayon
     * @param array float ['lat']
     *              float ['lng']
     *              int ['distance'] (en mètres)
     *              int ['limit']
     *              string ['sort']
     * @return array les infos du lieux et sa distance en km par rapport au point
     */
    static function fetchLieuxByRadius($params)
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
        if($sort == 'rand') {
            $sql .= "ORDER BY RAND() ";
        } else {
            $sql .= "ORDER BY `distance` ASC ";
        }
        $sql .= "LIMIT 0, " . $limit;

        return $db->queryWithFetch($sql);
    }

    /**
     * récupère les lieux dans une zone rectangulaire (point NW et point SE)
     * @param array float ['lat']
     *              float ['lng']
     *              float ['lat_min']
     *              float ['lat_max']
     *              float ['lng_min']
     *              float ['lng_max']
     *              int ['limit']
     */
    static function fetchLieuxByBoundary($params)
    {
        $lat     = (float) $params['lat'];
        $lng     = (float) $params['lng'];
        $lat_min = (float) $params['lat_min'];
        $lat_max = (float) $params['lat_max'];
        $lng_min = (float) $params['lng_min'];
        $lng_max = (float) $params['lng_max'];
        $limit   = (int) $params['limit'];

        if(($lat_min < -90) || ($lat_max > 90) || ($lng_min < -180) || ($lng_max > 180)) {
            return []; // hors limite
        }
        if(($lat_min >= $lat_max) || ($lng_min >= $lng_max)) {
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
     * récupère les lieux à partir de leur zone géographique administrative
     * @param array float ['lat']
     *              float ['lng']
     *              string ['id_country']
     *              string ['id_region']
     *              string ['id_departement']
     *              int ['limit']
     * @return array
     */
    static function fetchLieuxByAdmin($params)
    {
        $lat            = (float) $params['lat'];
        $lng            = (float) $params['lng'];
        $id_country     = (string) $params['id_country'];
        $id_region      = (string) $params['id_region'];
        $id_departement = (string) $params['id_departement'];
        $limit          = (int) $params['limit'];

        $db = DataBase::getInstance();

        $sql = "SELECT `l`.`id_lieu`, `l`.`name`, `l`.`address`, `v`.`cp`, `l`.`cp` AS `old_cp`, `v`.`name` AS `city`, `l`.`city` AS `old_city`, `l`.`lat`, `l`.`lng`, "
             . "FORMAT(get_distance_metres('" . number_format($lat, 8, '.', '') . "', '" . number_format($lng, 8, '.', '') . "', `l`.`lat`, `l`.`lng`) / 1000, 2) AS `distance` "
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
