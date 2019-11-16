<?php declare(strict_types=1);

use \Reference\Style;

/**
 * Classe Event
 *
 * Gestion des événements et des liaisons directes (avec groupe, structure et lieu)
 * gestion de l'intégrité référentielle
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Event extends ObjectModel
{
    /**
     * Instance de l'objet
     *
     * @var object
     */
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static $_pk = 'id_event';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_event';

    /**
     * @var int
     */
    protected $_id_event = 0;

    /**
     * @var string
     */
    protected $_name = '';

    /**
     * @var string
     */
    protected $_date = null;

    /**
     * @var string
     */
    protected $_text = '';

    /**
     * @var string
     */
    protected $_price = '';

    /**
     * @var bool
     */
    protected $_online = false;

    /**
     * @var int
     */
    protected $_id_lieu = 0;

    /**
     * @var int
     */
    protected $_id_contact = 0;

    /**
     * @var string
     */
    protected $_facebook_event_id = '';

    /**
     * @var string
     */
    protected $_created_on = null;

    /**
     * @var string
     */
    protected $_modified_on = null;

    /**
     * @var array
     */
    protected $_styles = [];

    /**
     * @var array
     */
    protected $_groupes = [];

    /**
     * @var array
     */
    protected $_structures = [];

    /**
     * Liste des attributs de l'objet
     *
     * @var array
     */
    protected static $_all_fields = [
        'id_event'      => 'int', // pk
        'created_on'    => 'date',
        'modified_on'   => 'date',
        'name'          => 'string',
        'date'          => 'date',
        'text'          => 'string',
        'price'         => 'string',
        'online'        => 'bool',
        'id_lieu'       => 'int',
        'id_contact'    => 'int',
        'facebook_event_id' => 'string',
    ];

    /* début getters */

    /**
     * @return string
     */
    static function getBaseUrl(): string
    {
        return MEDIA_URL . '/event';
    }

    /**
     * @return string
     */
    static function getBasePath(): string
    {
        return MEDIA_PATH . '/event';
    }

    /**
     * @return int
     */
    function getIdEvent(): int
    {
        return $this->_id_event;
    }

    /**
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
     * @return int|null
     */
    function getCreatedOnTs(): ?int
    {
        if (!is_null($this->_created_on) && Date::isDateTimeOk($this->_created_on)) {
            return strtotime($this->_created_on);
        }
        return null;
    }

    /**
     * @return string|null
     */
    function getModifiedOn(): ?string
    {
        if (!is_null($this->_modified_on) && Date::isDateTimeOk($this->_modified_on)) {
            return $this->_modified_on;
        }
        return null;
    }

    /**
     * @return int|null
     */
    function getModifiedOnTs(): ?int
    {
        if (!is_null($this->_modified_on) && Date::isDateTimeOk($this->_modified_on)) {
            return strtotime($this->_modified_on);
        }
        return null;
    }

    /**
     * @return string
     */
    function getName(): string
    {
        return $this->_name;
    }

    /**
     * @return string yyyy-mm-dd hh:ii:ss
     */
    function getDate(): string
    {
        return $this->_date;
    }

    /**
     * @return int
     */
    function getDay(): int
    {
        return (int) date('d', strtotime($this->_date));
    }

    /**
     * @return int
     */
    function getMonth(): int
    {
        return (int) date('m', strtotime($this->_date));
    }

    /**
     * @return int
     */
    function getYear(): int
    {
        return (int) date('Y', strtotime($this->_date));
    }

    /**
     * @return int
     */
    function getHour(): int
    {
        return (int) date('H', strtotime($this->_date));
    }

    /**
     * @return int
     */
    function getMinute(): int
    {
        return (int) date('i', strtotime($this->_date));
    }

    /**
     * @return string
     */
    function getText(): string
    {
        return $this->_text;
    }

    /**
     * @return string
     */
    function getPrice(): string
    {
        return $this->_price;
    }

    /**
     * @return bool
     */
    function getOnline(): bool
    {
        return $this->_online;
    }

    /**
     * @return int
     */
    function getIdContact(): int
    {
        return $this->_id_contact;
    }

    /**
     * @return string
     */
    function getContactUrl(): string
    {
        return HOME_URL . '/membres/' . (string) $this->_id_contact;
    }

    /**
     * @return string
     */
    function getContactPseudo(): string
    {
        return Membre::getPseudoById($this->_id_contact);
    }

    /**
     * @return string
     */
    function getFacebookEventId(): string
    {
        return $this->_facebook_event_id;
    }

    /**
     * @return string
     */
    function getFacebookEventUrl(): string
    {
        return "https://www.facebook.com/events/{$this->_facebook_event_id}";
    }

    /**
     * @return int
     */
    function getIdLieu(): int
    {
        return $this->_id_lieu;
    }

    /**
     * @return object|null
     */
    function getLieu(): ?object
    {
        if (!is_null($this->getIdLieu())) {
            return Lieu::getInstance($this->getIdLieu());
        }
        return null;
    }

    /**
     * @return string|null
     */
    function getFullFlyerUrl(): ?string
    {
        if (file_exists(self::getBasePath()  . '/' . (string) $this->_id_event . '.jpg')) {
            return self::getBaseUrl() . '/' . (string) $this->_id_event . '.jpg';
        }
        return null;
    }

    /**
     * @return string|null
     */
    function getFlyer100Url(): ?string
    {
        return self::getFlyerUrl((int) $this->getId(), 100, 100);
    }

    /**
     * @return string|null
     */
    function getFlyer320Url(): ?string
    {
        return self::getFlyerUrl((int) $this->getId(), 320, 0);
    }

    /**
     * Retourne l'url de la fiche événement
     *
     * @return string
     */
    function getUrl(): string
    {
        return HOME_URL . '/events/' . $this->getIdEvent();
    }

    /**
     * @return array
     */
    function getGroupes(): array
    {
        return Groupe::find(
            [
                'id_event' => $this->getIdEvent(),
                'order_by' => 'name',
                'sort' => 'ASC',
            ]
        );
    }

    /* fin getters */

    /* début setters */

    /**
     * @param string $created_on created_on
     * 
     * @return object
     */
    function setCreatedOn(string $created_on): object
    {
        if ($this->_created_on !== $created_on) {
            $this->_created_on = $created_on;
            $this->_modified_fields['created_on'] = true;
        }

        return $this;
    }

    /**
     * @return object
     */
    function setCreatedNow(): object
    {
        $now = date('Y-m-d H:i:s');

        if ($this->_created_on !== $now) {
            $this->_created_on = $now;
            $this->_modified_fields['created_on'] = true;
        }

        return $this;
    }

    /**
     * @param string $modified_on modified_on
     *
     * @return object
     */
    function setModifiedOn(string $modified_on): object
    {
        if ($this->_modified_on !== $modified_on) {
            $this->_modified_on = $modified_on;
            $this->_modified_fields['modified_on'] = true;
        }

        return $this;
    }

    /**
     * @return object
     */
    function setModifiedNow(): object
    {
        $now = date('Y-m-d H:i:s');

        if ($this->_modified_on !== $now) {
            $this->_modified_on = $now;
            $this->_modified_fields['modified_on'] = true;
        }

        return $this;
    }

    /**
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
     * @param string $facebook_event_id facebook_event_id
     *
     * @return object
     */
    function setFacebookEventId(string $facebook_event_id): object
    {
        // pour les boulets qui copient/collent toute l'url
        if (preg_match('#^https?://w{0,3}\.facebook.com/events/([0-9]{1,24})/{0,1}$#', $facebook_event_id, $matches)) {
            $facebook_event_id = $matches[1];
        }
        $facebook_event_id = str_replace('/', '', trim($facebook_event_id));

        if ($this->_facebook_event_id !== $facebook_event_id) {
            $this->_facebook_event_id = $facebook_event_id;
            $this->_modified_fields['facebook_event_id'] = true;
        }

        return $this;
    }

    /**
     * @param string $date date
     *
     * @return object
     */
    function setDate(string $date): object
    {
        if ($this->_date !== $date) {
            $this->_date = $date;
            $this->_modified_fields['date'] = true;
        }

        return $this;
    }

    /**
     * @param string $text text
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
     * @param string $price price
     *
     * @return object
     */
    function setPrice(string $price): object
    {
        if ($this->_price !== $price) {
            $this->_price = $price;
            $this->_modified_fields['price'] = true;
        }

        return $this;
    }

    /**
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

    /**
     * @param int $id_lieu id_lieu
     *
     * @return object
     */
    function setIdLieu(int $id_lieu): object
    {
        if ($this->_id_lieu !== $id_lieu) {
            $this->_id_lieu = $id_lieu;
            $this->_modified_fields['id_lieu'] = true;
        }

        return $this;
    }

    /**
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

    /* fin setters */

    /**
     * Retourne une collection d'objets "Event" répondant au(x) critère(s) donné(s)
     *
     * @param array $params [
     *                      'id_contact' => int,
     *                      'id_groupe' => int,
     *                      'id_lieu' => int,
     *                      'id_structure' => int,
     *                      'datdeb' => string,
     *                      'datfin' => string,
     *                      'online' => bool,
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

        if (isset($params['id_contact'])) {
            $sql .= "AND `id_contact` = " . (int) $params['id_contact'] . " ";
        }

        if (isset($params['id_groupe'])) {
            $subSql = "SELECT `id_event` FROM `adhoc_participe_a` WHERE `id_groupe` = " . (int) $params['id_groupe'] . " ";
            if ($ids_event = $db->queryWithFetchFirstFields($subSql)) {
                $sql .= "AND `id_event` IN (" . implode(',', (array) $ids_event) . ") ";
            } else {
                return $objs;
            }
        }

        if (isset($params['id_structure'])) {
            $subSql = "SELECT `id_event` FROM `adhoc_organise_par` WHERE `id_structure` = " . (int) $params['id_structure'] . " ";
            if ($ids_event = $db->queryWithFetchFirstFields($subSql)) {
                $sql .= "AND `id_event` IN (" . implode(',', (array) $ids_event) . ") ";
            } else {
                return $objs;
            }
        }

        if (isset($params['id_lieu'])) {
            $sql .= "AND `id_lieu` = " . (int) $params['id_lieu'] . " ";
        }

        if (isset($params['datdeb'])) {
            $sql .= "AND `date` >= '" . $db->escape($params['datdeb']) . "' ";
        }

        if (isset($params['datfin'])) {
            $sql .= "AND `date` <= '" . $db->escape($params['datfin']) . "' ";
        }

        if (isset($params['online'])) {
            $sql .= "AND `online` = ";
            $sql .= $params['online'] ? "TRUE" : "FALSE";
            $sql .= " ";
        }

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$_all_fields))))) {
            $sql .= "ORDER BY `" . $params['order_by'] . "` ";
        } else {
            $sql .= "ORDER BY `" . static::$_pk . "` ";
        }

        if ((isset($params['sort']) && (in_array($params['sort'], ['ASC', 'DESC'])))) {
            $sql .= $params['sort'] . " ";
        } else {
            $sql .= "ASC ";
        }

        if (isset($params['start']) && isset($params['limit'])) {
            $sql .= "LIMIT " . (int) $params['start'] . ", " . (int) $params['limit'];
        }

        $ids = $db->queryWithFetchFirstFields($sql);
        foreach ($ids as $id) {
            $objs[] = static::getInstance((int) $id);
        }

        return $objs;
    }

    /**
     * @return bool
     * @throws Exception
     */
    protected function _loadFromDb(): bool
    {
        if (!parent::_loadFromDb()) {
            throw new Exception('id_event_introuvable');
        }

        if (file_exists(self::getBasePath() . '/' . $this->getId() . '.jpg')) {
            $this->_photo = self::getBaseUrl() . '/' . $this->getId() . '.jpg';
        }

        if (file_exists(self::getBasePath() . '/' . $this->getId() . '-mini.jpg')) {
            $this->_mini_photo = self::getBaseUrl() . '/' . $this->getId() . '-mini.jpg';
        }

        return true;
    }

    /**
     *
     */
    function deleteFlyer()
    {
        $p = self::getBasePath() . '/' . $this->getId() . '.jpg';
        if (file_exists($p)) {
            unlink($p);
        }

        // delete des caches images
        self::invalidateFlyerInCache($this->getId(), '100', '100');
        self::invalidateFlyerInCache($this->getId(), '400', '400');
    }

    /**
     * Suppression d'un événement
     */
    function delete()
    {
        /* délie les tables référentes */
        $this->unlinkStyles();
        $this->unlinkStructures();
        $this->unlinkGroupes();
        $this->deleteFlyer();

        parent::delete();

        return true;
    }

    /**
     * Ajoute un style pour un événement
     *
     * @param int $id_style id_style
     *
     * @return bool
     */
    function linkStyle(int $id_style): bool
    {
        $db = DataBase::getInstance();

        $sql = "INSERT INTO `" . self::$_db_table_event_style . "` "
             . "(`id_event`, `id_style`) "
             . "VALUES (" . $this->_id_event . ", " . $id_style . ")";

        try {
            $db->query($sql);
            return (bool) $db->affectedRows();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Efface un style pour un événement
     *
     * @param int $id_style id_style
     *
     * @return bool
     */
    function unlinkStyle(int $id_style): bool
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . self::$_db_table_event_style . "` "
             . "WHERE `id_event` = " . (int) $this->_id_event . " "
             . "AND `id_style` = " . (int) $id_style;

        $db->query($sql);

        return (bool) $db->affectedRows();
    }

    /**
     * Retourne le tableau des styles pour un événement
     *
     * @return array
     */
    function getStyles(): array
    {
        return Style::find(
            [
                'id_event' => $this->getIdEvent(),
                'sort' => 'name',
            ]
        );
    }

    /**
     * Efface tous les styles d'un événement
     *
     * @return bool
     */
    function unlinkStyles(): bool
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . self::$_db_table_event_style . "` "
             . "WHERE `id_event` = " . (int) $this->getIdEvent();

        $db->query($sql);

        return (bool) $db->affectedRows();
    }

    /**
     * Ajoute un groupe à un événement
     *
     * @param int $id_groupe id_groupe
     *
     * @return bool
     */
    function linkGroupe(int $id_groupe): bool
    {
        $db = DataBase::getInstance();

        $sql = "INSERT INTO `" . self::$_db_table_participe_a . "` "
             . "(`id_event`, `id_groupe`) "
             . "VALUES (" . (int) $this->getIdEvent() . ", " . (int) $id_groupe . ")";

        try {
            $db->query($sql);
            return (bool) $db->affectedRows();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Efface un groupe d'un événement
     *
     * @param int $id_groupe id_groupe
     *
     * @return bool
     */
    function unlinkGroupe(int $id_groupe): bool
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . self::$_db_table_participe_a . "` "
             . "WHERE `id_event` = " . (int) $this->getIdEvent() . " "
             . "AND `id_groupe` = " . (int) $id_groupe;

        $db->query($sql);

        return (bool) $db->affectedRows();
    }

    /**
     * Délie tous les groupes d'un événement
     *
     * @return bool
     */
    function unlinkGroupes(): bool
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . self::$_db_table_participe_a . "` "
             . "WHERE `id_event` = " . (int) $this->getIdEvent();

        $db->query($sql);

        return (bool) $db->affectedRows();
    }

    /**
     * Ajoute une structure à un événement
     *
     * @param int $id_structure id_structure
     *
     * @return bool
     */
    function linkStructure(int $id_structure): bool
    {
        $db = DataBase::getInstance();

        $sql = "INSERT INTO `" . self::$_db_table_organise_par . "` "
             . " (`id_event`, `id_structure`) "
             . "VALUES (" . (int) $this->getIdEvent() . ", " . (int) $id_structure . ")";

        try {
            $db->query($sql);
            return (bool) $db->affectedRows();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Efface une structure d'un événement
     *
     * @param int $id_structure id_structure
     *
     * @return bool
     */
    function unlinkStructure(int $id_structure): bool
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . self::$_db_table_organise_par . "` "
             . "WHERE `id_event` = " . (int) $this->_id_event . " "
             . "AND `id_structure` = " . (int) $id_structure;

        $db->query($sql);

        return (bool) $db->affectedRows();
    }

    /**
     * Retourne le tableau des structures pour un événement
     *
     * @return array
     */
    function getStructures(): array
    {
        return Structure::find(
            [
                'id_event' => $this->getIdEvent(),
                'order_by' => 'name',
            ]
        );
    }

    /**
     * Efface toutes les structures d'un événement
     *
     * @return bool
     */
    function unlinkStructures(): bool
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . self::$_db_table_organise_par . "` "
             . "WHERE `id_event` = " . (int) $this->getIdEvent();

        $db->query($sql);

        return (bool) $db->affectedRows();
    }

    /**
     * Retourne un tableau avec le nombre d'événements par jour
     * utile pour le calendrier
     *
     * @param int $year  année
     * @param int $month mois
     *
     * @return array
     */
    static function getEventsForAMonth(int $year, int $month)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT DATE(`date`) AS `date`, COUNT(`id_event`) AS `nb_events` "
             . "FROM `adhoc_event` "
             . "WHERE YEAR(`date`) = " . (int) $year . " "
             . "AND MONTH(`date`) = " .(int) $month . " "
             . "GROUP BY DATE(`date`)";

        $res = $db->queryWithFetch($sql);

        $tab = [];
        foreach ($res as $_res) {
            $tab[$_res['date']] = $_res['nb_events'];
        }
        unset($res);

        return $tab;
    }

    /**
     * Retourne les photos associées à cet événement
     *
     * @return array
     */
    function getPhotos(): array
    {
        return Photo::find(
            [
                'id_event'  => $this->getIdEvent(),
                'online' => true,
            ]
        );
    }

    /**
     * Retourne les vidéos associées à cet événement
     *
     * @return array
     */
    function getVideos(): array
    {
        return Video::find(
            [
                'id_event' => $this->getIdEvent(),
                'online' => true,
            ]
        );
    }

    /**
     * Retourne les audios associés à cet événement
     *
     * @return array
     */
    function getAudios(): array
    {
        return Audio::find(
            [
                'id_event' => $this->getIdEvent(),
                'online' => true,
            ]
        );
    }

    /**
     * Retourne les concerts ad'hoc par saison (juillet Y -> aout Y+1)
     *
     * @return array
     */
    static function getAdHocEventsBySeason(): array
    {
        $events = self::find(
            [
                'id_structure' => 1, // AD'HOC
                'order_by' => 'date',
                'sort' => 'ASC',
                'start' => 0,
                'limit' => 1000,
            ]
        );

        $tab = [];
        foreach ($events as $event) {
            if ($event->getMonth() > 7) {
                $season = (string) $event->getYear() . ' / ' . (string) ($event->getYear() + 1);
            } else {
                $season = (string) ($event->getYear() - 1) . ' / ' . (string) $event->getYear();
            }
            if (!array_key_exists($season, $tab)) {
                $tab[$season] = [];
            }
            $tab[$season][] = $event;
        }

        return $tab;
    }

    /**
     *
     */
    static function invalidateFlyerInCache($id, $width = 80, $height = 80, $bgcolor = '000000', $border = 0, $zoom = 0)
    {
        $uid = 'event/' . $id . '/' . $width . '/' . $height . '/' . $bgcolor . '/' . $border . '/' . $zoom . '.jpg';
        $cache = Image::getCachePath($uid);

        if (file_exists($cache)) {
            unlink($cache);
            return true;
        }

        return false;
    }

    /**
     * Retourne l'url de la photo
     * gestion de la mise en cache
     *
     * @return string
     */
    static function getFlyerUrl(int $id_event, int $width = 80, int $height = 80, string $bgcolor = '000000', bool $border = false, bool $zoom = false)
    {
        $uid = 'event/' . $id_event . '/' . $width . '/' . $height . '/' . $bgcolor . '/' . (int) $border . '/' . (int) $zoom . '.jpg';
        $cache = Image::getCachePath($uid);

        if (!file_exists($cache)) {
            $source = self::getBasePath() . '/' . $id_event . '.jpg';
            if (file_exists($source)) {
                $img = (new Image($source))
                    ->setType(IMAGETYPE_JPEG)
                    ->setMaxWidth($width)
                    ->setMaxHeight($height)
                    ->setBorder($border)
                    ->setKeepRatio(true)
                    ->setZoom($zoom)
                    ->setHexColor($bgcolor);
                Image::writeCache($uid, $img->get());
            } else {
                // ce n'est pas une erreur, tous les events n'ont pas de flyers
                return null;
            }
        }

        return Image::getCacheUrl($uid);
    }

    /**
     * Récupère les events ayant au moins une vidéo
     *
     * @return array
     */
    static function getEventsWithVideo(): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT DISTINCT `e`.`id_event` AS `id`, `e`.`name`, `e`.`date`, "
             . "`l`.`name` AS `lieu_name`, `l`.`city` AS `lieu_city` "
             . "FROM `adhoc_event` `e`, `adhoc_lieu` `l`, `adhoc_video` `v` "
             . "WHERE `e`.`id_event` = `v`.`id_event` "
             . "AND `e`.`id_lieu` = `l`.`id_lieu` "
             . "AND `e`.`online` AND `v`.`online` "
             . "ORDER BY `e`.`date` DESC";

        return $db->queryWithFetch($sql);
    }
}
