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
    function getFacebookEventAttending(): int
    {
        return $this->_facebook_event_attending;
    }

    /**
     * @return int
     */
    function getIdLieu(): int
    {
        return $this->_id_lieu;
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
        return self::getUrlById((int) $this->getId());
    }

    /**
     * @param int $id_event id_event
     *
     * @return string
     */
    static function getUrlById(int $id_event): string
    {
        return HOME_URL . '/events/' . (string) $id_event;
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
     * Retourne un tableau d'objEvt pour des critères donnés
     *
     * @param array $params ['datdeb']      => '2005-01-01'
     *                      ['datfin']      => '2005-03-03'
     *                      ['lieu']        => '1'
     *                      ['style']       => '1,3,5'
     *                      ['groupe']      => '5,6'
     *                      ['structure']   => '1'
     *                      ['id']          => '5'
     *                      ['departement'] => '91'
     *                      ['sort']        => id_event|datdeb|random
     *                      ['sens']        => ASC|DESC
     *                      ['debut']       => 0
     *                      ['limit']       => 5000
     *                      ['online']      => true
     * datdeb et datfin obligatoires, le reste facultatif
     *
     * @return array
     */
    static function getEvents(array $params = [])
    {
        if (array_key_exists('datdeb', $params)) {
            if (!empty($params['datdeb'])) {
                if (!(Date::isDateOk($params['datdeb']) || Date::isDateTimeOk($params['datdeb']))) {
                    throw new Exception('datdeb incorrecte');
                }
            } else {
                unset($params['datdeb']);
            }
        }

        if (array_key_exists('datfin', $params)) {
            if (!empty($params['datfin'])) {
                if (!(Date::isDateOk($params['datfin']) || Date::isDateTimeOk($params['datfin']))) {
                    throw new Exception('datfin incorrecte');
                }
            } else {
                unset($params['datfin']);
            }
        }

        $debut = 0;
        if (isset($params['debut']) && ((int) $params['debut'] > 0)) {
            $debut = (int) $params['debut'];
        }

        $limit = 10;
        if (isset($params['limit']) && ((int) $params['limit'] > 0)) {
            $limit = (int) $params['limit'];
        }

        $sens = 'ASC';
        if (isset($params['sens']) && $params['sens'] === 'DESC') {
            $sens = 'DESC';
        }

        $sort = 'id_event';
        if (isset($params['sort'])
            && ($params['sort'] === 'date' || $params['sort'] === 'random')
        ) {
            $sort = $params['sort'];
        }

        $online = null;
        if (isset($params['online'])) {
            $online = (bool) $params['online'];
        }

        $lat = 0;
        $lng = 0;

        // traitement des params complexes
        foreach (['lieu', 'style', 'groupe', 'structure', 'id', 'departement', 'contact'] as $n) {
            ${'tab_' . $n} = [];
            if (array_key_exists($n, $params) && ($params[$n] !== 0) && ($params[$n] !== '0')) {
                if (is_int($params[$n])) {
                    ${'tab_' . $n}[0] = (int) $params[$n];
                } else {
                    ${'tab_' . $n} = explode(',', $params[$n]);
                }
                foreach (${'tab_' . $n} as $idx => $val) {
                    ${'tab_' . $n}[$idx] = (int) $val;
                }
            }
        }

        $db = DataBase::getInstance();

        $sql = "SELECT DISTINCT `e`.`id_event` AS `id`, `e`.`name`, "
             . "`e`.`text`, `e`.`date`, `e`.`price`, `e`.`facebook_event_id`, `e`.`online`, "
             . "`e`.`created_on`, `e`.`modified_on`, "
             . "`l`.`id_lieu` AS `lieu_id`, `l`.`name` AS `lieu_name`, "
             . "`l`.`city` AS `lieu_city`, `l`.`id_departement` AS `lieu_id_departement`, "
             . "FORMAT(get_distance_metres('" . number_format($lat, 8, '.', '') . "', '" . number_format($lng, 8, '.', '') . "', `l`.`lat`, `l`.`lng`) / 1000, 2) AS `lieu_distance`, "
             . "`l`.`address` AS `lieu_address`, `l`.`cp` AS `lieu_cp`, `l`.`id_country` AS `lieu_country`, "
             . "`s`.`id_structure` AS `structure_id`, `s`.`name` AS `structure_name`, "
             . "`m`.`id_contact` AS `membre_id`, `m`.`pseudo` AS `membre_pseudo` "
             . "FROM (`" . Event::getDbTable() . "` `e`) "
             . "LEFT JOIN `" . Lieu::getDbTable() . "` `l` ON (`e`.`id_lieu` = `l`.`id_lieu`) "
             . "LEFT JOIN `" . self::$_db_table_participe_a . "` `p` ON (`e`.`id_event` = `p`.`id_event`) "
             . "LEFT JOIN `" . self::$_db_table_organise_par . "` `o` ON (`e`.`id_event` = `o`.`id_event`) "
             . "LEFT JOIN `" . Structure::getDbTable() . "` `s` ON (`o`.`id_structure` = `s`.`id_structure`) "
             . "LEFT JOIN `" . self::$_db_table_event_style . "` `es` ON (`e`.`id_event` = `es`.`id_event`) "
             . "LEFT JOIN `" . Membre::getDbTable() . "` `m` ON (`e`.`id_contact` = `m`.`id_contact`) "
             . "WHERE 1 ";

        if (count($tab_lieu)) {
            $sql .= "AND (0 ";
            foreach ($tab_lieu as $id_lieu) {
                $sql .= "OR `l`.`id_lieu` = " . (int) $id_lieu." ";
            }
            $sql .= ") ";
        }

        if (count($tab_style)) {
            $sql .= "AND (0 ";
            foreach ($tab_style as $id_style) {
                $sql .= "OR `es`.`id_style` = " . (int) $id_style . " ";
            }
            $sql .= ") ";
        }

        if (count($tab_groupe)) {
            $sql .= "AND (0 ";
            foreach ($tab_groupe as $id_groupe) {
                $sql .= "OR `p`.`id_groupe` = " . (int) $id_groupe." ";
            }
            $sql .= ") ";
        }

        if (count($tab_structure)) {
            $sql .= "AND (0 ";
            foreach ($tab_structure as $id_structure) {
                $sql .= "OR `o`.`id_structure` = " . (int) $id_structure . " ";
            }
            $sql .= ") ";
        }

        if (count($tab_id) && ($tab_id[0] !== 0)) {
            $sql .= "AND `e`.`id_event` IN (" . implode(',', $tab_id) . ") ";
        }

        if (count($tab_contact) && ($tab_contact[0] !== 0)) {
            $sql .= "AND `e`.`id_contact` IN (" . implode(',', $tab_contact) . ") ";
        }

        if (count($tab_departement) && ($tab_departement[0] !== 0)) {
            $sql .= "AND (0 ";
            foreach ($tab_departement as $id_departement) {
                $sql .= "OR `l`.`id_departement` = '" . $db->escape($id_departement) . "' ";
            }
            $sql .= ") ";
        }

        if (array_key_exists('datdeb', $params)) {
            $sql .= "AND `e`.`date` >= '" . $db->escape($params['datdeb']) . "' ";
        }

        if (array_key_exists('datfin', $params)) {
            $sql .= "AND `e`.`date` <= '" . $db->escape($params['datfin']) . "' ";
        }

        if (!is_null($online)) {
            if ($online) {
                $sql .= "AND `e`.`online` = TRUE ";
            } else {
                $sql .= "AND `e`.`online` = FALSE ";
            }
        }

        $sql .= "ORDER BY ";
        if ($sort === "random") {
            $sql .= "RAND(" . time() . ") ";
        } else {
            $sql .= "`e`.`" . $sort . "` " . $sens . " ";
        }
        $sql .= "LIMIT " . $debut . ", " . $limit;

        $res = $db->queryWithFetch($sql);

        $evts = [];
        foreach ($res as $idx => $_res) {
            $evts[$idx] = $_res;
            $evts[$idx]['url'] = self::getUrlById((int) $_res['id']);
            $evts[$idx]['flyer_100_url'] = self::getFlyerUrl((int) $_res['id'], 100, 100);
            $evts[$idx]['flyer_320_url'] = self::getFlyerUrl((int) $_res['id'], 320, 0);
            $evts[$idx]['structure_picto'] = Structure::getPictoById((int) $_res['structure_id']);
        }

        unset($res);

        if ($limit === 1) {
            $evts = array_pop($evts);
        }

        return $evts;
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
     * @return int
     * @throws Exception
     */
    function linkStyle(int $id_style)
    {
        $db = DataBase::getInstance();

        $sql = "INSERT INTO `" . self::$_db_table_event_style . "` "
             . "(`id_event`, `id_style`) "
             . "VALUES (" . $this->_id_event . ", " . $id_style . ")";

        try {
            $db->query($sql);
            return $db->affectedRows();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Efface un style pour un événement
     *
     * @param int $id_style id_style
     *
     * @return int
     */
    function unlinkStyle(int $id_style)
    {
        $style = Style::getInstance($id_style);

        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . self::$_db_table_event_style . "` "
             . "WHERE `id_event` = " . (int) $this->_id_event . " "
             . "AND `id_style` = " . (int) $id_style;

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * Retourne le tableau des styles pour un événement
     *
     * @return array
     */
    function getStyles(): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_style` "
             . "FROM `" . self::$_db_table_event_style . "` "
             . "WHERE `id_event` = " . (int) $this->getId();

        return array_map(
            function ($id_style) {
                return (int) $id_style;
            },
            $db->queryWithFetchFirstFields($sql)
        );
    }

    /**
     * Efface tous les styles d'un événement
     */
    function unlinkStyles()
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . self::$_db_table_event_style . "` "
             . "WHERE `id_event` = " . (int) $this->_id_event;

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * Ajoute un groupe à un événement
     *
     * @param int $id_groupe id_groupe
     */
    function linkGroupe(int $id_groupe)
    {
        $db = DataBase::getInstance();

        $sql = "INSERT INTO `" . self::$_db_table_participe_a . "` "
             . "(`id_event`, `id_groupe`) "
             . "VALUES (" . (int) $this->_id_event . ", " . (int) $id_groupe . ")";

        try {
            $db->query($sql);
            return $db->affectedRows();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Efface un groupe d'un événement
     *
     * @param int $id_groupe id_groupe
     *
     * @return int
     */
    function unlinkGroupe(int $id_groupe)
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . self::$_db_table_participe_a . "` "
             . "WHERE `id_event` = " . (int) $this->_id_event . " "
             . "AND `id_groupe` = " . (int) $id_groupe;

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * Retourne le tableau des groupes pour un événement
     *
     * @return array
     */
    function getGroupes(): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_groupe` "
             . "FROM `".self::$_db_table_participe_a."` "
             . "WHERE `id_event` = " . (int) $this->_id_event;

        return array_map(
            function ($id_groupe) {
                return (int) $id_groupe;
            },
            $db->queryWithFetchFirstFields($sql)
        );
    }

    /**
     * Délie tous les groupes d'un événement
     *
     * @return int
     */
    function unlinkGroupes()
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . self::$_db_table_participe_a . "` "
             . "WHERE `id_event` = " . (int) $this->_id_event;

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * Ajoute une structure à un événement
     *
     * @param int $id_structure id_structure
     */
    function linkStructure(int $id_structure)
    {
        $db = DataBase::getInstance();

        $sql = "INSERT INTO `" . self::$_db_table_organise_par . "` "
             . " (`id_event`, `id_structure`) "
             . "VALUES (" . (int) $this->_id_event . ", " . (int) $id_structure . ")";

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * Efface une structure d'un événement
     *
     * @param int $id_structure id_structure
     */
    function unlinkStructure(int $id_structure)
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . self::$_db_table_organise_par . "` "
             . "WHERE `id_event` = " . (int) $this->_id_event . " "
             . "AND `id_structure` = " . (int) $id_structure;

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * Retourne le tableau des structures pour un événement
     *
     * @return array
     */
    function getStructures(): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_structure` "
             . "FROM `" . self::$_db_table_organise_par . "` "
             . "WHERE `id_event` = " . (int) $this->getId();

        return array_map(
            function ($id_structure) {
                return (int) $id_structure;
            },
            $db->queryWithFetchFirstFields($sql)
        );
    }

    /**
     * Efface toutes les structures d'un événement
     */
    function unlinkStructures()
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . self::$_db_table_organise_par . "` "
             . "WHERE `id_event` = " . (int) $this->getId();

        $db->query($sql);

        return $db->affectedRows();
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

        $sql = "SELECT DATE(`date`) AS `date`, COUNT(`id_event`) AS `nb_events`
                FROM `adhoc_event`
                WHERE YEAR(`date`) = " . (int) $year . "
                AND MONTH(`date`) = " .(int) $month . "
                GROUP BY DATE(`date`)";

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
        return Photo::getPhotos(
            [
                'event'  => $this->getId(),
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
        return Video::getVideos(
            [
                'event'  => $this->getId(),
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
        return Audio::getAudios(
            [
                'event'  => $this->getId(),
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
        $evts = self::getEvents(
            [
                'structure' => 1,
                'sort'      => 'date',
                'sens'      => 'ASC',
                'limit'     => 1000,
            ]
        );

        $tab = [];
        foreach ($evts as $evt) {
            $year = (int) mb_substr($evt['date'], 0, 4);
            $month = (int) mb_substr($evt['date'], 5, 2);
            if ($month > 7) {
                $season = (string) $year . ' / ' . (string) ($year + 1);
            } else {
                $season = (string) ($year - 1) . ' / ' . (string) $year;
            }
            if (!array_key_exists($season, $tab)) {
                $tab[$season] = [];
            }
            $tab[$season][] = $evt;
        }

        return $tab;
    }

    /**
     *
     */
    static function invalidateFlyerInCache($id, $width = 80, $height = 80, $bgcolor = '000000', $border = 0, $zoom = 0)
    {
        $uid = 'event/' . $id . '/' . $width . '/' . $height . '/' . $bgcolor . '/' . $border . '/' . $zoom . '.jpg';
        $cache = Image::getLocalCachePath($uid);

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
        $cache = Image::getLocalCachePath($uid);

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

        return Image::getHttpCachePath($uid);
    }

    /**
     * Récupère les events ayant au moins un audio
     *
     * @return array
     */
    static function getEventsWithAudio(): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT DISTINCT `e`.`id_event` AS `id`, `e`.`name`, `e`.`date`, "
             . "`l`.`name` AS `lieu_name`, `l`.`city` AS `lieu_city` "
             . "FROM `adhoc_event` `e`, `adhoc_lieu` `l`, `adhoc_audio` `a` "
             . "WHERE `e`.`id_event` = `a`.`id_event` "
             . "AND `e`.`id_lieu` = `l`.`id_lieu` "
             . "AND `e`.`online` AND `a`.`online` "
             . "ORDER BY `e`.`date` DESC";

        return $db->queryWithFetch($sql);
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
