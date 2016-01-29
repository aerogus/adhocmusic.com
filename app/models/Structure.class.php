<?php

/**
 * @package adhoc
 */

/**
 * Classe Structure
 *
 * Gestion des Structures / associations
 *
 * @package adhoc
 * @author Guillaume Seznec <guillaume.seznec@gmail.com>
 */
class Structure extends ObjectModel
{
    /**
     * @var object
     */
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static $_pk = 'id_structure';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_structure';

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
    protected $_address = '';

    /**
     * @var string
     */
    protected $_cp = null;

    /**
     * @var string
     */
    protected $_city = null;

    /**
     * @var string
     */
    protected $_id_country = '';

    /**
     * @var string
     */
    protected $_fax = '';

    /**
     * @var string
     */
    protected $_id_departement = '';

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
     * Liste des attributs de l'objet
     * on précise si en base c'est de type :
     * - numérique/integer/float/bool (= int)
     * - datetime/text (= str)
     * ceci est utile pour la formation de la requête
     * @var array
     */
    protected static $_all_fields = array(
        'name'           => 'str',
        'address'        => 'str',
        'cp'             => 'str',
        'city'           => 'str',
        'tel'            => 'str',
        'fax'            => 'str',
        'id_departement' => 'str',
        'text'           => 'str',
        'site'           => 'str',
        'email'          => 'str',
        'id_country'     => 'str',
    );

    /**
     * Tableau des attributs modifiés depuis la dernière sauvegarde.
     *
     * Pour chaque attribut modifié, on a un élément de la forme 'attribut => TRUE'.
     * @var array
     */
    protected $_modified_fields = array();

    /* début getters */

    /**
     * @return string
     */
    protected static function _getBaseUrl()
    {
        return MEDIA_URL . '/structure';
    }

    /**
     * @return string
     */
    protected static function _getBasePath()
    {
        return MEDIA_PATH . '/structure';
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
    function getAddress()
    {
        return (string) $this->_address;
    }

    /**
     * @return string
     */
    function getCp()
    {
        return (string) $this->_cp;
    }

    /**
     * @return string
     */
    function getCity()
    {
        return (string) $this->_city;
    }

    /**
     * @return string
     */
    function getTel()
    {
        return (string) $this->_tel;
    }

    /**
     * @return string
     */
    function getFax()
    {
        return (string) $this->_fax;
    }

    /**
     * @return string
     */
    function getIdDepartement()
    {
        return (string) $this->_id_departement;
    }

    /**
     * @return string
     */
    function getText()
    {
        return (string) $this->_text;
    }

    /**
     * @return string
     */
    function getSite()
    {
        return (string) $this->_site;
    }

    /**
     * @return string
     */
    function getEmail()
    {
        return (string) $this->_email;
    }

    /**
     * @return string
     */
    function getIdCountry()
    {
        return (string) $this->_id_country;
    }

    /**
     * @return string
     */
    function getPicto()
    {
        return self::getPictoById((int) $this->getId());
    }

    /**
     * @var int
     * @return string
     */
    static function getPictoById($id)
    {
        return self::_getBaseUrl() . '/' . (int) $id . '.png';
    }

    /* fin getters */

    /* début setters */

    /**
     * @param string
     */
    function setName($val)
    {
        if ($this->_name !== $val)
        {
            $this->_name = (string) $val;
            $this->_modified_fields['name'] = true;
        }
    }

    /**
     * @param string
     */
    function setAddress($val)
    {
        if ($this->_address !== $val)
        {
            $this->_address = (string) $val;
            $this->_modified_fields['address'] = true;
        }
    }

    /**
     * @param string
     */
    function setCp($val)
    {
        if ($this->_cp !== $val)
        {
            $this->_cp = (string) $val;
            $this->_modified_fields['cp'] = true;
        }
    }

    /**
     * @param string
     */
    function setCity($val)
    {
        if ($this->_city !== $val)
        {
            $this->_city = (string) $val;
            $this->_modified_fields['city'] = true;
        }
    }

    /**
     * @param string
     */
    function setTel($val)
    {
        if ($this->_tel !== $val)
        {
            $this->_tel = (string) $val;
            $this->_modified_fields['tel'] = true;
        }
    }

    /**
     * @param string
     */
    function setFax($val)
    {
        if ($this->_fax !== $val)
        {
            $this->_fax = (string) $val;
            $this->_modified_fields['fax'] = true;
        }
    }

    /**
     * @param string
     */
    function setIdDepartement($val)
    {
        if ($this->_id_departement !== $val)
        {
            $this->_id_departement = (string) $val;
            $this->_modified_fields['id_departement'] = true;
        }
    }

    /**
     * @param string
     */
    function setText($val)
    {
        if ($this->_text !== $val)
        {
            $this->_text = (string) $val;
            $this->_modified_fields['text'] = true;
        }
    }

    /**
     * @param string
     */
    function setSite($val)
    {
        if ($this->_site !== $val)
        {
            $this->_site = (string) $val;
            $this->_modified_fields['site'] = true;
        }
    }

    /**
     * @param string
     */
    function setEmail($val)
    {
        if ($this->_email !== $val)
        {
            $this->_email = (string) $val;
            $this->_modified_fields['email'] = true;
        }
    }

    /**
     * @param string
     */
    function setIdCountry($val)
    {
        if ($this->_id_country !== $val)
        {
            $this->_id_country = (string) $val;
            $this->_modified_fields['id_country'] = true;
        }
    }

    /* fin setters */

    /**
     * Suppression d'une structure
     *
     * @return bool
     */
    function delete()
    {
        // check de la table evenement
        if($this->hasEvents()) {
            throw new Exception('delete impossible, la structure est liée à des événements');
        }

        // check de la table audio
        if($this->hasAudios()) {
            throw new Exception('delete impossible, la structure est liée à des audios');
        }

        // check de la table photo
        if($this->hasPhotos()) {
            throw new Exception('delete impossible, la structure est liée à des photos');
        }

        // check de la table video
        if($this->hasVideos()) {
            throw new Exception('delete impossible, la structure est liée à des vidéos');
        }

        // tout est ok on delete
        $sql = "DELETE FROM `" . self::$_db_table_structure . "` "
             . "WHERE `id_structure` = " . (int) $this->_id_structure;

        $db = DataBase::getInstance();
        $res  = $db->query($sql);
        if($db->affectedRows()) {
            $file = self::_getBasePath() . '/' . $this->_id_structure . '.png';
            if(file_exists($file)) {
                unlink($file);
            }
            return true;
        }
        return false;
    }

    /**
     * retourne le tableau de toutes les structures dans un tableau associatif
     *
     * @return array
     */
    static function getStructures()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_structure` AS `id`, `name`, `address`, `cp`, "
             . "`city`, `tel`, `fax`, `id_departement`, "
             . "`text`, `site`, `email`, `id_country` "
             . "FROM `" . self::$_db_table_structure . "` "
             . "ORDER BY `id_country` ASC, `id_departement` ASC, `city` ASC";

        $tab = array();
        if($res = $db->queryWithFetch($sql)) {
            foreach($res as $struct) {
                $tab[$struct['id']] = $struct;
                $tab[$struct['id']]['picto'] = self::getPictoById($struct['id']);
            }
        }
        return $tab;
    }

    /**
     * retourne les infos sur une structure
     *
     * @return array
     */
    function _loadFromDb()
    {
        $db = DataBase::getInstance();

        $sql  = "SELECT `name`, "
              . "`address`, `cp`, `city`, `tel`, `fax`, `id_departement`, "
              . "`text`, `site`, `email`, `id_country` "
              . "FROM `" . self::$_db_table_structure . "` "
              . "WHERE `id_structure` = " . (int) $this->_id_structure;

        if($res = $db->queryWithFetchFirstRow($sql)) {
            $this->_dbToObject($res);
            if(file_exists(self::_getBasePath() . '/' . $this->_id_structure . '.png')) {
                $this->_photo = self::_getBaseUrl() . '/' . $this->_id_structure . '.png';
            }
            return true;
        }
        return false; // todo exception
    }

    /**
     * @return bool
     */
    function hasPhotos()
    {
        return (bool) $this->getPhotos();
    }

    /**
     * retourne les photos associées à cette structure
     *
     * @return array
     */
    function getPhotos()
    {
        return Photo::getPhotos(array(
            'structure' => $this->_id_structure,
        ));
    }

    /**
     * @return bool
     */
    function hasVideos()
    {
        return (bool) $this->getVideos();
    }

    /**
     * retourne les vidéos associées à cette structure
     *
     * @return array
     */
    function getVideos()
    {
        return Video::getVideos(array(
            'structure' => $this->_id_structure,
        ));
    }

    /**
     * @return bool
     */
    function hasAudios()
    {
        return (bool) $this->getAudios();
    }

    /**
     * retourne les audios associés à cette structure
     *
     * @return array
     */
    function getAudios()
    {
        return Audio::getAudios(array(
            'structure' => $this->_id_structure,
        ));
    }

    /**
     * @return bool
     */
    function hasEvenements()
    {
        return (bool) $this->getEvenements();
    }

    /**
     * retourne les événements rattachés à cette structure
     *
     * @return array
     */
    function getEvenements()
    {
        return Event::getEvents(array(
            'structure' => $this->_id_structure,
        ));
    }
}
