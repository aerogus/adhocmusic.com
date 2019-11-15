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
     * @var int|null
     */
    protected $_id_structure = null;

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
     * @return int|null
     */
    function getIdGroupe(): ?int
    {
        return $this->_id_groupe;
    }

    /**
     * @return int|null
     */
    function getIdLieu(): ?int
    {
        return $this->_id_lieu;
    }

    /**
     * @return int|null
     */
    function getIdEvent(): ?int
    {
        return $this->_id_event;
    }

    /**
     * @return int|null
     */
    function getIdStructure(): ?int
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
     * @param int|null $id_structure id_structure
     *
     * @return object
     */
    function setIdStructure(?int $id_structure): object
    {
        if ($this->_id_structure !== $id_structure) {
            $this->_id_structure = $id_structure;
            $this->_modified_fields['id_structure'] = true;
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
     * @param string|null $created_on created_on
     *
     * @return object
     */
    function setCreatedOn(?string $created_on): object
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
     * @param string|null $modified_on modified_on
     *
     * @return object
     */
    function setModifiedOn(?string $modified_on): object
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
            $date[$key] = $row['created_on'];
        }
        array_multisort($date, SORT_DESC, $tab);

        $tab = array_slice($tab, 0, $params['limit']);

        return $tab;
    }
}
