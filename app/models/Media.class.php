<?php

/**
 * Classe Media
 * parente de Audio, Video et Photo
 *
 * @package adhoc
 * @author Guillaume Seznec <guillaume.seznec@gmail.com>
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
    protected $_created_on = '';

    /**
     * @var string
     */
    protected $_modified_on = '';

    /**
     * @var bool
     */
    protected $_online = false;

    /* début getters communs */

    /**
     * @return int
     */
    function getIdContact()
    {
        return (int) $this->_id_contact;
    }

    /**
     * @return int
     */
    function getIdGroupe()
    {
        return (int) $this->_id_groupe;
    }

    /**
     * @return int
     */
    function getIdLieu()
    {
        return (int) $this->_id_lieu;
    }

    /**
     * @return int
     */
    function getIdEvent()
    {
        return (int) $this->_id_event;
    }

    /**
     * @return int
     */
    function getIdStructure()
    {
        return (int) $this->_id_structure;
    }

    /**
     * @return string
     */
    function getName()
    {
        return (string) $this->_name;
    }

    /**
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
     * @return bool
     */
    function getOnline()
    {
        return (bool) $this->_online;
    }

    /* fin getters communs */

    /* début setters communs */

    /**
     * @param int
     */
    function setIdContact($val)
    {
        if ($this->_id_contact != $val)
        {
            $this->_id_contact = (int) $val;
            $this->_modified_fields['id_contact'] = true;
        }
    }

    /**
     * @param int
     */
    function setIdGroupe($val)
    {
        if ($this->_id_groupe != $val)
        {
            $this->_id_groupe = (int) $val;
            $this->_modified_fields['id_groupe'] = true;
        }
    }

    /**
     * @param int
     */
    function setIdLieu($val)
    {
        if ($this->_id_lieu != $val)
        {
            $this->_id_lieu = (int) $val;
            $this->_modified_fields['id_lieu'] = true;
        }
    }

    /**
     * @param int
     */
    function setIdEvent($val)
    {
        if ($this->_id_event != $val)
        {
            $this->_id_event = (int) $val;
            $this->_modified_fields['id_event'] = true;
        }
    }

    /**
     * @param int
     */
    function setIdStructure($val)
    {
        if ($this->_id_structure != $val)
        {
            $this->_id_structure = (int) $val;
            $this->_modified_fields['id_structure'] = true;
        }
    }

    /**
     * @param string
     */
    function setName($val)
    {
        if ($this->_name != $val)
        {
            $this->_name = (string) $val;
            $this->_modified_fields['name'] = true;
        }
    }

    /**
     * @param string
     */
    function setCreatedOn($val)
    {
        if ($this->_created_on != $val)
        {
            $this->_created_on = (string) $val;
            $this->_modified_fields['created_on'] = true;
        }
    }

    /**
     *
     */
    function setCreatedNow()
    {
        $now = date('Y-m-d H:i:s');
        if ($this->_created_on != $now)
        {
            $this->_created_on = (string) $now;
            $this->_modified_fields['created_on'] = true;
        }
    }

    /**
     * @param string
     */
    function setModifiedOn($val)
    {
        if ($this->_modified_on != $val)
        {
            $this->_modified_on = (string) $val;
            $this->_modified_fields['modified_on'] = true;
        }
    }

    /**
     *
     */
    function setModifiedNow()
    {
        $now = date('Y-m-d H:i:s');
        if ($this->_modified_on != $now)
        {
            $this->_modified_on = (string) $now;
            $this->_modified_fields['modified_on'] = true;
        }
    }

    /**
     * @param bool
     */
    function setOnline($val)
    {
        if ($this->_online != $val)
        {
            $this->_online = (bool) $val;
            $this->_modified_fields['online'] = true;
        }
    }

    /* fin setters communs */

    /**
     * recherche des média en fonction de critères donnés
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
     * @return array
     */
    static function getMedia($params = array())
    {
        $tab_type = array();
        if(array_key_exists('type', $params)) {
            $tab_type = explode(",", $params['type']);
        }

        if(!array_key_exists('split', $params)) {
            $params['split'] = false;
        }

        $tab = array();
        $split = array();

        foreach($tab_type as $type)
        {
            if($type == 'audio')
            {
                $audios = Audio::getAudios($params);
                $split['audio'] = $audios;
                $tab = array_merge($tab, $audios);
            }
            if($type == 'photo')
            {
                $photos = Photo::getPhotos($params);
                $split['photo'] = $photos;
                $tab = array_merge($tab, $photos);
            }
            if($type == 'video')
            {
                $videos = Video::getVideos($params);
                $split['video'] = $videos;
                $tab = array_merge($tab, $videos);
            }
        }

        if($params['split']) {
            return $split;
        }

        $date = array();
        foreach ($tab as $key => $row) {
            $date[$key] = $row['created_on'];
        }
        array_multisort($date, SORT_DESC, $tab);

        $tab = array_slice($tab, 0, $params['limit']);

        return $tab;
    }
}
