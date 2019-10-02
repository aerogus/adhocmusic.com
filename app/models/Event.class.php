<?php declare(strict_types=1);

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
     * @var int
     */
    protected $_facebook_event_attending = 0;

    /**
     * @var string
     */
    protected $_created_on = null;

    /**
     * @var string
     */
    protected $_modified_on = null;

    /**
     * @var int
     */
    protected $_nb_photos = 0;

    /**
     * @var int
     */
    protected $_nb_audios = 0;

    /**
     * @var int
     */
    protected $_nb_videos = 0;

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
     * on précise si en base c'est de type :
     * - numérique/integer/float/bool (= int)
     * - datetime/text (= str)
     * ceci est utile pour la formation de la requête
     *
     * @var array
     */
    protected static $_all_fields = [
        'created_on'    => 'date',
        'modified_on'   => 'date',
        'name'          => 'str',
        'date'          => 'date',
        'text'          => 'str',
        'price'         => 'str',
        'online'        => 'bool',
        'id_lieu'       => 'num',
        'id_contact'    => 'num',
        'facebook_event_id' => 'str',
        'facebook_event_attending' => 'num',
        'nb_photos'     => 'num',
        'nb_audios'     => 'num',
        'nb_videos'     => 'num',
    ];

    /**
     * Tableau des attributs modifiés depuis la dernière sauvegarde.
     *
     * Pour chaque attribut modifié, on a un élément de la forme 'attribut => true'.
     *
     * @var array
     */
    protected $_modified_fields = [];

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
        return 'https://www.facebook.com/events/' . (string) $this->_facebook_event_id . '/';
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
    function getFlyer400Url(): ?string
    {
        return self::getFlyerUrl($this->getId(), 400, 400);
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
     * @param string $val val
     * 
     * @return object
     */
    function setCreatedOn(string $val): object
    {
        if ($this->_created_on !== $val) {
            $this->_created_on = $val;
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
     * @param string $val val
     *
     * @return object
     */
    function setModifiedOn(string $val): object
    {
        if ($this->_modified_on !== $val) {
            $this->_modified_on = $val;
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
     * @param string $val val
     *
     * @return object
     */
    function setName(string $val): object
    {
        if ($this->_name !== $val) {
            $this->_name = $val;
            $this->_modified_fields['name'] = true;
        }

        return $this;
    }

    /**
     * @param string $val val
     *
     * @return object
     */
    function setFacebookEventId(string $val): object
    {
        // pour les boulets qui copient/collent toute l'url
        if (preg_match('#^https?://w{0,3}\.facebook.com/events/([0-9]{1,24})/{0,1}$#', $val, $matches)) {
            $val = $matches[1];
        }
        $val = str_replace('/', '', trim($val));

        if ($this->_facebook_event_id !== $val) {
            $this->_facebook_event_id = (string) $val;
            $this->_modified_fields['facebook_event_id'] = true;
        }

        return $this;
    }

    /**
     * @param int $val val
     *
     * @return object
     */
    function setFacebookEventAttending(int $val): object
    {
        if ($this->_facebook_event_attending !== $val) {
            $this->_facebook_event_attending = $val;
            $this->_modified_fields['facebook_event_attending'] = true;
        }

        return $this;
    }

    /**
     * @param string $val val
     *
     * @return object
     */
    function setDate(string $val): object
    {
        if ($this->_date !== $val) {
            $this->_date = $val;
            $this->_modified_fields['date'] = true;
        }

        return $this;
    }

    /**
     * @param string $val val
     * 
     * @return object
     */
    function setText(string $val): object
    {
        if ($this->_text !== $val) {
            $this->_text = $val;
            $this->_modified_fields['text'] = true;
        }

        return $this;
    }

    /**
     * @param string $val val
     *
     * @return object
     */
    function setPrice(string $val): object
    {
        if ($this->_price !== $val) {
            $this->_price = $val;
            $this->_modified_fields['price'] = true;
        }

        return $this;
    }

    /**
     * @param bool $val val
     *
     * @return object
     */
    function setOnline(bool $val): object
    {
        if ($this->_online !== $val) {
            $this->_online = $val;
            $this->_modified_fields['online'] = true;
        }

        return $this;
    }

    /**
     * @param int $val val
     *
     * @return object
     */
    function setIdLieu(int $val): object
    {
        if ($this->_id_lieu !== $val) {
            $this->_id_lieu = $val;
            $this->_modified_fields['id_lieu'] = true;
        }

        return $this;
    }

    /**
     * @param int $val val
     *
     * @return object
     */
    function setIdContact(int $val): object
    {
        if ($this->_id_contact !== $val) {
            $this->_id_contact = $val;
            $this->_modified_fields['id_contact'] = true;
        }

        return $this;
    }

    /* fin setters */

    /**
     * Retourne le nombre de d'événements référencés
     *
     * @return int
     */
    static function getEventsCount()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(*) "
             . "FROM `".Event::getDbTable()."`";

        return (int) $db->queryWithFetchFirstField($sql);
    }

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
             . "`e`.`text`, `e`.`date`, `e`.`price`, `e`.`facebook_event_id`, `e`.`facebook_event_attending`, `e`.`online`, "
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
            $evts[$idx]['flyer_400_url'] = self::getFlyerUrl((int) $_res['id'], 400, 400);
            $evts[$idx]['structure_picto'] = Structure::getPictoById($_res['structure_id']);
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
        $db = DataBase::getInstance();

        $sql = "SELECT `id_event` AS `id`, `name`, `text`, `id_contact`, `online`, "
             . "`price`, `date`, TIMESTAMP(`date`) AS `timestamp`, `facebook_event_id`, `facebook_event_attending`, `id_lieu` "
             . "FROM `" . Event::getDbTable() . "` "
             . "WHERE `id_event` = " . (int) $this->_id_event;

        if (($res = $db->queryWithFetchFirstRow($sql))) {
            $this->_dbToObject($res);

            if (file_exists(self::getBasePath() . '/' . $this->getId() . '.jpg')) {
                $this->_photo = self::getBaseUrl() . '/' . $this->getId() . '.jpg';
            }

            if (file_exists(self::getBasePath() . '/' . $this->getId() . '-mini.jpg')) {
                $this->_mini_photo = self::getBaseUrl() . '/' . $this->getId() . '-mini.jpg';
            }

            $this->_groupes    = $this->getGroupes();
            $this->_structures = $this->getStructures();

            return true;
        }

        throw new Exception('id_event_introuvable');
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
     * @param int $ordre    ordre
     *
     * @return int
     * @throws Exception
     */
    function linkStyle(int $id_style, int $ordre = 1)
    {
        // les paramètres sont-ils corrects ?
        if (!$this->_id_event || !$id_style) {
            throw new Exception('paramètres incorrects');
        }

        if (!is_numeric($ordre)) {
            throw new Exception('ordre non numérique');
        }

        // événement valide ?
        if (!self::isEventOk($this->_id_event)) {
            throw new Exception('id_event introuvable');
        }

        // style valide ?
        if (!Style::isStyleOk($id_style)) {
            throw new Exception('id_style introuvable');
        }

        // le style n'est-t-il pas déjà présent pour cet évenement ?
        $listeStyles = $this->getStyles();
        foreach ($listeStyles as $style) {
            if ($id_style === $style['id_style']) {
                throw new Exception('Style déjà présent pour cet événement');
            }
        }

        // tout est ok on ajoute la liaison événement/style
        // (retourne actuellement une erreur en cas de duplicate key !)

        $db = DataBase::getInstance();

        $sql = "INSERT INTO `" . self::$_db_table_event_style . "` "
             . "(`id_event`, `id_style`, `ordre`) "
             . "VALUES (" . $this->_id_event . ", " . $id_style . ", " . $ordre . ")";

        $db->query($sql);

        return $db->affectedRows();
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
        // les paramètres sont-ils corrects ?
        if (!$this->_id_event || !$id_style) {
            throw new Exception('paramètres incorrects');
        }

        // événement valide ?
        if (!self::isEvenementOk($this->_id_event)) {
            throw new Exception('id_event introuvable');
        }

        // style valide ?
        if (!Style::isStyleOk($id_style)) {
            throw new Exception('id_style introuvable');
        }

        // style bien trouvé pour cet événement ?
        $listeStyles = $this->getStyles();
        $style_not_found = true;
        foreach ($listeStyles as $style) {
            if ($id_style === $style['id_style']) {
                $style_not_found = false;
            }
        }
        if ($style_not_found) {
            throw new Exception('Style introuvable pour cet événement');
        }

        // tout est ok on supprime la liaison événement/style
        // retourne 0 si la liaison n'existait pas, 1 sinon

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
     * @return array $tab_style[] = $id_style
     */
    function getStyles()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_style` "
             . "FROM `" . self::$_db_table_event_style . "` "
             . "WHERE `id_event` = " . (int) $this->getId() . " "
             . "ORDER BY `ordre` ASC";

        return $db->queryWithFetch($sql);
    }

    /**
     * Retourne un style
     *
     * @param int $idx idx
     */
    function getStyle(int $idx)
    {
        if (array_key_exists($idx, $this->_styles)) {
            return $this->_styles[$idx];
        }
        return false;
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

        $db->query($sql);

        return $db->affectedRows();
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
    function getGroupes()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `g`.`name`, `g`.`id_groupe` AS `id`, "
             . "`g`.`style`, `g`.`alias`, "
             . "CONCAT('https://www.adhocmusic.com/', `g`.`alias`) AS `url` "
             . "FROM `".self::$_db_table_participe_a."` `p`, `".Groupe::getDbTable()."` `g` "
             . "WHERE `g`.`id_groupe` = `p`.`id_groupe` "
             . "AND `p`.`id_event` = " . (int) $this->_id_event . " "
             . "ORDER BY `g`.`id_groupe` ASC";

        $res = $db->queryWithFetch($sql);

        $cpt = 0;
        foreach ($res as $grp) {
            $res[$cpt]['mini_photo'] = '/img/note_adhoc_64.png';
            if (file_exists(MEDIA_PATH . '/groupe/m' . $grp['id'] . '.jpg')) {
                $res[$cpt]['mini_photo'] = MEDIA_URL . '/groupe/m' . $grp['id'] . '.jpg';
            }
            $cpt++;
        }

        return $res;
    }

    /**
     * Retourne un tableau d'info d'un groupe à partir de l'index commençant à 0
     *
     * @param int $idx idx
     *
     * @return array
     */
    function getGroupe(int $idx)
    {
        if (array_key_exists($idx, $this->_groupes)) {
            return $this->_groupes[$idx];
        }
        return false;
    }

    /**
     * Retourne un groupe id à partir de l'index commençant à 0
     *
     * @param int $idx idx
     *
     * @return int
     */
    function getGroupeId(int $idx)
    {
        if (array_key_exists($idx, $this->_groupes)) {
            return $this->_groupes[$idx]['id'];
        }
        return false;
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
        // les paramètres sont-ils corrects ?
        if (!$this->_id_event || !$id_structure) {
            throw new Exception('paramètres incorrects');
        }

        // la structure n'est-t-elle pas déjà présente pour l'événement ?
        $listeStructures = $this->getStructures();
        foreach ($listeStructures as $struct) {
            if ($id_structure === $struct['id']) {
                throw new Exception('Structure déjà présente pour cet événement');
            }
        }

        // tout est ok on ajoute la liaison événement/structure
        // (retourne actuellement une erreur en cas de duplicate key !)

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
        // les paramètres sont-ils corrects ?
        if (!$this->_id_event || !$id_structure) {
            throw new Exception('paramètres incorrects');
        }

        // la structure est-elle bien présente pour cet événement ?
        $listeStructures = $this->getStructures();
        $struct_not_found = true;
        foreach ($listeStructures as $struct) {
            if ($id_structure === $struct['id_structure']) {
                $struct_not_found = false;
            }
        }
        if ($struct_not_found) {
            throw new Exception('Structure introuvable pour cet événement');
        }

        // tout est ok on supprime la liaison événement/structure
        // retourne 0 si la liaison n'existait pas, 1 sinon

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
     * @return array $tab_struct[] = $id_struct
     */
    function getStructures()
    {

        // retourne le tableau id => nom

        $db = DataBase::getInstance();

        $sql = "SELECT `o`.`id_structure` AS `id`, `s`.`name` "
             . "FROM `" . self::$_db_table_organise_par . "` `o`, `" . Structure::getDbTable() . "` `s` "
             . "WHERE `s`.`id_structure` = `o`.`id_structure` "
             . "AND `o`.`id_event` = " . (int) $this->getId();

        return $db->queryWithFetch($sql);
    }

    /**
     * Retourne une structure
     *
     * @param int $idx idx
     *
     * @return int
     */
    function getStructure(int $idx)
    {
        if (array_key_exists($idx, $this->_structures)) {
            return $this->_structures[$idx];
        }
        return false;
    }

    /**
     * Retourne un structure id à partir de l'index commençant à 0
     *
     * @param int $idx idx
     *
     * @return int
     */
    function getStructureId(int $idx)
    {
        if (array_key_exists($idx, $this->_structures)) {
            return $this->_structures[$idx]['id'];
        }
        return false;
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
     * @param int $year année
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
    function getPhotos()
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
    function getVideos()
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
    function getAudios()
    {
        return Audio::getAudios(
            [
                'event'  => $this->getId(),
                'online' => true,
            ]
        );
    }

    /**
     * Retourne si un événement est valide
     *
     * @param int $id_event id_event
     *
     * @return bool
     */
    static function isEventOk(int $id_event)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_event` "
             . "FROM `" . Event::getDbTable() . "` "
             . "WHERE `id_event` = " . (int) $id_event;

        $res = $db->query($sql);

        return (bool) $db->numRows($res);
    }

    /**
     * Compte le nombre d'événements saisis par le user loggué
     *
     * @return int
     */
    static function getMyEventsCount(): int
    {
        if (empty($_SESSION['membre'])) {
            throw new Exception('non identifié');
        }

        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(*) "
             . "FROM `" . Event::getDbTable() . "` "
             . "WHERE `id_contact` = " . (int) $_SESSION['membre']->getId();

        return (int) $db->queryWithFetchFirstField($sql);
    }

    /**
     *
     */
    static function syncNbMedia()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `e`.`id_event`, COUNT(DISTINCT `a`.`id_audio`) AS `nb_audios`, "
             . "COUNT(DISTINCT `p`.`id_photo`) AS `nb_photos`, "
             . "COUNT(DISTINCT `v`.`id_video`) AS `nb_videos` "
             . "FROM (`adhoc_event` `e`) "
             . "LEFT JOIN `adhoc_audio` `a` ON `a`.`id_event` = `e`.`id_event` "
             . "LEFT JOIN `adhoc_photo` `p` ON `p`.`id_event` = `e`.`id_event` "
             . "LEFT JOIN `adhoc_video` `v` ON `v`.`id_event` = `e`.`id_event` "
             . "GROUP BY `e`.`id_event`";

        echo $sql;

        $tmp = $db->queryWithFetch($sql);
        foreach ($tmp as $_tmp) {
            $evt = Event::getInstance($_tmp['id_event']);
            $evt->setNbPhotos($_tmp['nb_photos']);
            $evt->setNbVideos($_tmp['nb_videos']);
            $evt->setNbAudios($_tmp['nb_audios']);
            $evt->save();
            echo "*";
        }
        echo "FIN";
        die();
    }

    /**
     * Retourne les concerts ad'hoc par saison (juillet Y -> aout Y+1)
     *
     * @return array
     */
    static function getAdHocEventsBySeason()
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
    static function getFlyerUrl(int $id_event, int $width = 80, int $height = 80, string $bgcolor = '000000', $border = 0, $zoom = 0)
    {
        $uid = 'event/' . $id_event . '/' . $width . '/' . $height . '/' . $bgcolor . '/' . $border . '/' . $zoom . '.jpg';
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

    /**
     * Récupère les events ayant au moins une photo
     *
     * @return array
     */
    static function getEventsWithPhoto(): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT DISTINCT `e`.`id_event` AS `id`, `e`.`name`, `e`.`date`, "
             . "`l`.`name` AS `lieu_name`, `l`.`city` AS `lieu_city` "
             . "FROM `adhoc_event` `e`, `adhoc_lieu` `l`, `adhoc_photo` `p` "
             . "WHERE `e`.`id_event` = `p`.`id_event` "
             . "AND `e`.`id_lieu` = `l`.`id_lieu` "
             . "AND `e`.`online` AND `p`.`online` "
             . "ORDER BY `e`.`date` DESC";

        return $db->queryWithFetch($sql);
    }

    /**
     * Récupère les events ayant au moins un média (photo,audio,vidéo)
     *
     * @return array
     */
    static function getEventsWithMedia(): array
    {
        $db = DataBase::getInstance();

        $sql = "(SELECT DISTINCT `e`.`id_event` AS `id`, `e`.`name`, `e`.`date`, "
             . "`l`.`name` AS `lieu_name`, `l`.`city` AS `lieu_city` "
             . "FROM `adhoc_event` `e`, `adhoc_lieu` `l`, `adhoc_video` `v` "
             . "WHERE `e`.`id_event` = `v`.`id_event` "
             . "AND `e`.`id_lieu` = `l`.`id_lieu` "
             . "AND `e`.`online` AND `v`.`online`)"/*
             . " UNION "
             . "(SELECT DISTINCT `e`.`id_event` AS `id`, `e`.`name`, `e`.`date`, "
             . "`l`.`name` AS `lieu_name`, `l`.`city` AS `lieu_city` "
             . "FROM `adhoc_event` `e`, `adhoc_lieu` `l`, `adhoc_audio` `a` "
             . "WHERE `e`.`id_event` = `a`.`id_event` "
             . "AND `e`.`id_lieu` = `l`.`id_lieu` "
             . "AND `e`.`online` AND `a`.`online`)"
             . " UNION "
             . "(SELECT DISTINCT `e`.`id_event` AS `id`, `e`.`name`, `e`.`date`, "
             . "`l`.`name` AS `lieu_name`, `l`.`city` AS `lieu_city` "
             . "FROM `adhoc_event` `e`, `adhoc_lieu` `l`, `adhoc_photo` `p` "
             . "WHERE `e`.`id_event` = `p`.`id_event` "
             . "AND `e`.`id_lieu` = `l`.`id_lieu` "
             . "AND `e`.`online` AND `p`.`online`)"*/
             . " ORDER BY `date` DESC";

        return $db->queryWithFetch($sql);
    }
}
