<?php declare(strict_types=1);

/**
 * Classe Media
 * parente de Audio, Video et Photo
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Media extends ObjectModel
{
    /**
     * Instance de l'objet
     *
     * @var object
     */
    protected static $_instance = null;

    /**
     * @var int
     */
    protected $_id_contact = 0;

    /**
     * @var int|null
     */
    protected $_id_groupe = null;

    /**
     * @var int|null
     */
    protected $_id_lieu = null;

    /**
     * @var int|null
     */
    protected $_id_event = null;

    /**
     * @var string
     */
    protected $_name = '';

    /**
     * @var string
     */
    protected $_created_at = null;

    /**
     * @var string
     */
    protected $_modified_at = null;

    /**
     * @var bool
     */
    protected $_online = false;

    /* début getters communs */

    /**
     * @return int
     */
    function getIdContact(): int
    {
        return $this->_id_contact;
    }

    /**
     * @return int|null
     */
    function getIdGroupe(): ?int
    {
        return $this->_id_groupe;
    }

    /**
     * @return object|null
     */
    function getGroupe(): ?object
    {
        if (is_null($this->getIdGroupe())) {
            return null;
        }

        try {
            return Groupe::getInstance($this->getIdGroupe());
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * @return int|null
     */
    function getIdLieu(): ?int
    {
        return $this->_id_lieu;
    }

    /**
     * @return object|null
     */
    function getLieu(): ?object
    {
        if (!is_null($this->getIdLieu())) {
            try {
                return Lieu::getInstance($this->getIdLieu());
            } catch (Exception $e) {
                return null;
            }
        }
        return null;
    }

    /**
     * @return int|null
     */
    function getIdEvent(): ?int
    {
        return $this->_id_event;
    }

    /**
     * @return object|null
     */
    function getEvent(): ?object
    {
        if (!is_null($this->getIdEvent())) {
            try {
                return Event::getInstance($this->getIdEvent());
            } catch (Exception $e) {
                return null;
            }
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
     * @return string|null
     */
    function getCreatedAt()
    {
        if (!is_null($this->_created_at) && Date::isDateTimeOk($this->_created_at)) {
            return $this->_created_at;
        }
        return null;
    }

    /**
     * @return int|null
     */
    function getCreatedAtTs(): ?int
    {
        if (!is_null($this->_created_at) && Date::isDateTimeOk($this->_created_at)) {
            return strtotime($this->_created_at);
        }
        return null;
    }

    /**
     * @return string|null
     */
    function getModifiedAt(): ?string
    {
        if (!is_null($this->_modified_at) && Date::isDateTimeOk($this->_modified_at)) {
            return $this->_modified_at;
        }
        return null;
    }

    /**
     * @return int|null
     */
    function getModifiedAtTs(): ?int
    {
        if (!is_null($this->_modified_at) && Date::isDateTimeOk($this->_modified_at)) {
            return strtotime($this->_modified_at);
        }
        return null;
    }

    /**
     * @return bool
     */
    function getOnline(): bool
    {
        return $this->_online;
    }

    /* fin getters communs */

    /* début setters communs */

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

    /**
     * @param int|null $id_groupe id_groupe
     *
     * @return object
     */
    function setIdGroupe(?int $id_groupe): object
    {
        if ($this->_id_groupe !== $id_groupe) {
            $this->_id_groupe = $id_groupe;
            $this->_modified_fields['id_groupe'] = true;
        }

        return $this;
    }

    /**
     * @param int|null $id_lieu id_lieu
     *
     * @return object
     */
    function setIdLieu(?int $id_lieu): object
    {
        if ($this->_id_lieu !== $id_lieu) {
            $this->_id_lieu = $id_lieu;
            $this->_modified_fields['id_lieu'] = true;
        }

        return $this;
    }

    /**
     * @param int|null $id_event id_event
     *
     * @return object
     */
    function setIdEvent(?int $id_event): object
    {
        if ($this->_id_event !== $id_event) {
            $this->_id_event = $id_event;
            $this->_modified_fields['id_event'] = true;
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
     * @param string|null $created_at created_at
     *
     * @return object
     */
    function setCreatedAt(?string $created_at): object
    {
        if ($this->_created_at !== $created_at) {
            $this->_created_at = $created_at;
            $this->_modified_fields['created_at'] = true;
        }

        return $this;
    }

    /**
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
     * @param string|null $modified_at modified_at
     *
     * @return object
     */
    function setModifiedAt(?string $modified_at): object
    {
        if ($this->_modified_at !== $modified_at) {
            $this->_modified_at = $modified_at;
            $this->_modified_fields['modified_at'] = true;
        }

        return $this;
    }

    /**
     * @return object
     */
    function setModifiedNow(): object
    {
        $now = date('Y-m-d H:i:s');

        if ($this->_modified_at !== $now) {
            $this->_modified_at = $now;
            $this->_modified_fields['modified_at'] = true;
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

    /* fin setters communs */

    /**
     * Retourne une collection d'objets "Media" (Audio|Photo|Video) répondant au(x) critère(s) donné(s)
     *
     * @param array $params [
     *                      'id__in' => array de int,
     *                      'id__not_in' => array de int,
     *                      'id_contact' => int,
     *                      'has_groupe' => bool,
     *                      'id_groupe' => int,
     *                      'id_event' => int,
     *                      'id_lieu' => int,
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

        if (isset($params['id__in'])) {
            $sql .= "AND `" . static::getDbPk() . "` IN (" . implode(',', $params['id__in']) . ") ";
        }

        if (isset($params['id__not_in'])) {
            $sql .= "AND `" . static::getDbPk() . "` NOT IN (" . implode(',', $params['id__not_in']) . ") ";
        }

        if (isset($params['id_contact'])) {
            $sql .= "AND `id_contact` = " . (int) $params['id_contact'] . " ";
        }

        if (!empty($params['has_groupe'])) {
            if (get_called_class() === 'Video') {
                $subSql = "SELECT `id_video` FROM `adhoc_video_groupe`";
                if ($ids_video = $db->queryWithFetchFirstFields($subSql)) {
                    $sql .= "AND `id_video` IN (" . implode(',', (array) $ids_video) . ") ";
                } else {
                    return $objs;
                }
            } else {
                $sql .= "AND `id_groupe` IS NOT NULL ";
            }
        }

        if (isset($params['id_groupe'])) {
            if (get_called_class() === 'Video') {
                $subSql = "SELECT `id_video` FROM `adhoc_video_groupe` WHERE `id_groupe` = " . (int) $params['id_groupe'] . " ";
                if ($ids_video = $db->queryWithFetchFirstFields($subSql)) {
                    $sql .= "AND `id_video` IN (" . implode(',', (array) $ids_video) . ") ";
                } else {
                    return $objs;
                }
            } else {
                $sql .= "AND `id_groupe` = " . (int) $params['id_groupe'] . " ";
            }
        }

        if (isset($params['id_event'])) {
            $sql .= "AND `id_event` = " . (int) $params['id_event'] . " ";
        }

        if (isset($params['id_lieu'])) {
            $sql .= "AND `id_lieu` = " . (int) $params['id_lieu'] . " ";
        }

        if (isset($params['online'])) {
            $sql .= "AND `online` = ";
            $sql .= $params['online'] ? "TRUE" : "FALSE";
            $sql .= " ";
        }

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$_all_fields))))) {
            $sql .= "ORDER BY `" . $params['order_by'] . "` ";
        } elseif ((isset($params['order_by']) && $params['order_by'] === 'random')) {
            $sql .= "ORDER BY RAND() ";
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
     * Recherche des média en fonction de critères donnés
     *
     * @param array ['groupe']    => "5"
     *              ['lieu']      => "1"
     *              ['event']     => "1"
     *              ['type']      => "photo,audio,video"
     *              ['sort']      => "date|random"
     *              ['sens']      => "ASC"
     *              ['debut']     => 0
     *              ['limit']     => 10
     *              ['split']     => false
     *
     * @return array
     */
    static function getMedia(array $params = [])
    {
        $tab_type = [];
        if (array_key_exists('type', $params)) {
            $tab_type = explode(",", $params['type']);
        }

        if (!array_key_exists('split', $params)) {
            $params['split'] = false;
        }

        $tab = [];
        $split = [];

        foreach ($tab_type as $type) {
            if ($type === 'audio') {
                $audios = Audio::find($params);
                $split['audio'] = $audios;
                $tab = array_merge($tab, $audios);
            }
            if ($type === 'photo') {
                $photos = Photo::find($params);
                $split['photo'] = $photos;
                $tab = array_merge($tab, $photos);
            }
            if ($type === 'video') {
                $videos = Video::find($params);
                $split['video'] = $videos;
                $tab = array_merge($tab, $videos);
            }
        }

        if ($params['split']) {
            return $split;
        }

        $date = [];
        foreach ($tab as $key => $row) {
            $date[$key] = $row['created_at'];
        }
        array_multisort($date, SORT_DESC, $tab);

        $tab = array_slice($tab, 0, $params['limit']);

        return $tab;
    }
}
