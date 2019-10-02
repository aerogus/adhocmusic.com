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
     * @var object
     */
    protected static $_instance = null;

    /**
     * @var int
     */
    protected $_id_contact = 0;

    /**
     * @var int
     */
    protected $_id_groupe = 0;

    /**
     * @var int
     */
    protected $_id_lieu = 0;

    /**
     * @var int
     */
    protected $_id_event = 0;

    /**
     * @var int
     */
    protected $_id_structure = 0;

    /**
     * @var string
     */
    protected $_name = '';

    /**
     * @var string
     */
    protected $_created_on = null;

    /**
     * @var string
     */
    protected $_modified_on = null;

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
     * @return int
     */
    function getIdGroupe(): int
    {
        return $this->_id_groupe;
    }

    /**
     * @return int
     */
    function getIdLieu(): int
    {
        return $this->_id_lieu;
    }

    /**
     * @return int
     */
    function getIdEvent(): int
    {
        return $this->_id_event;
    }

    /**
     * @return int
     */
    function getIdStructure(): int
    {
        return $this->_id_structure;
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
    function getCreatedOn()
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
        if (!is_null($this->modified_on) && Date::isDateTimeOk($this->_modified_on)) {
            return strtotime($this->_modified_on);
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

    /**
     * @param int $val val
     *
     * @return object
     */
    function setIdGroupe(int $val): object
    {
        if ($this->_id_groupe !== $val) {
            $this->_id_groupe = $val;
            $this->_modified_fields['id_groupe'] = true;
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
    function setIdEvent(int $val): object
    {
        if ($this->_id_event !== $val) {
            $this->_id_event = $val;
            $this->_modified_fields['id_event'] = true;
        }

        return $this;
    }

    /**
     * @param int $val val
     *
     * @return object
     */
    function setIdStructure(int $val): object
    {
        if ($this->_id_structure !== $val) {
            $this->_id_structure = $val;
            $this->_modified_fields['id_structure'] = true;
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
     * @param string $val $val
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

    /* fin setters communs */

    /**
     * Recherche des média en fonction de critères donnés
     *
     * @param array ['groupe']    => "5"
     *              ['structure'] => "1,3"
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
                $audios = Audio::getAudios($params);
                $split['audio'] = $audios;
                $tab = array_merge($tab, $audios);
            }
            if ($type === 'photo') {
                $photos = Photo::getPhotos($params);
                $split['photo'] = $photos;
                $tab = array_merge($tab, $photos);
            }
            if ($type === 'video') {
                $videos = Video::getVideos($params);
                $split['video'] = $videos;
                $tab = array_merge($tab, $videos);
            }
        }

        if ($params['split']) {
            return $split;
        }

        $date = [];
        foreach ($tab as $key => $row) {
            $date[$key] = $row['created_on'];
        }
        array_multisort($date, SORT_DESC, $tab);

        $tab = array_slice($tab, 0, $params['limit']);

        return $tab;
    }
}
