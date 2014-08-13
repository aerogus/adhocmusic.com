<?php

/**
 * @package adhoc
 */

/**
 * Classe Structure
 *
 * Gestion des Structures
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
    protected static function _getWwwPath()
    {
        return STATIC_URL . '/media/structure';
    }

    /**
     * @return string
     */
    protected static function _getLocalPath()
    {
        return ADHOC_ROOT_PATH . '/media/structure';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return (string) $this->_name;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return (string) $this->_address;
    }

    /**
     * @return string
     */
    public function getCp()
    {
        return (string) $this->_cp;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return (string) $this->_city;
    }

    /**
     * @return string
     */
    public function getTel()
    {
        return (string) $this->_tel;
    }

    /**
     * @return string
     */
    public function getFax()
    {
        return (string) $this->_fax;
    }

    /**
     * @return string
     */
    public function getIdDepartement()
    {
        return (string) $this->_id_departement;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return (string) $this->_text;
    }

    /**
     * @return string
     */
    public function getSite()
    {
        return (string) $this->_site;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return (string) $this->_email;
    }

    /**
     * @return string
     */
    public function getIdCountry()
    {
        return (string) $this->_id_country;
    }

    /**
     * @return string
     */
    public function getPicto()
    {
        return self::getPictoById((int) $this->getId());
    }

    /**
     * @var int
     * @return string
     */
    public static function getPictoById($id)
    {
        return STATIC_URL . '/media/structure/' . (int) $id . '.png';
    }

    /* fin getters */

    /* début setters */

    /**
     * @param string
     */
    public function setName($val)
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
    public function setAddress($val)
    {
        if ($this->_address != $val)
        {
            $this->_address = (string) $val;
            $this->_modified_fields['address'] = true;
        }
    }

    /**
     * @param string
     */
    public function setCp($val)
    {
        if ($this->_cp != $val)
        {
            $this->_cp = (string) $val;
            $this->_modified_fields['cp'] = true;
        }
    }

    /**
     * @param string
     */
    public function setCity($val)
    {
        if ($this->_city != $val)
        {
            $this->_city = (string) $val;
            $this->_modified_fields['city'] = true;
        }
    }

    /**
     * @param string
     */
    public function setTel($val)
    {
        if ($this->_tel != $val)
        {
            $this->_tel = (string) $val;
            $this->_modified_fields['tel'] = true;
        }
    }

    /**
     * @param string
     */
    public function setFax($val)
    {
        if ($this->_fax != $val)
        {
            $this->_fax = (string) $val;
            $this->_modified_fields['fax'] = true;
        }
    }

    /**
     * @param string
     */
    public function setIdDepartement($val)
    {
        if ($this->_id_departement != $val)
        {
            $this->_id_departement = (string) $val;
            $this->_modified_fields['id_departement'] = true;
        }
    }

    /**
     * @param string
     */
    public function setText($val)
    {
        if ($this->_text != $val)
        {
            $this->_text = (string) $val;
            $this->_modified_fields['text'] = true;
        }
    }

    /**
     * @param string
     */
    public function setSite($val)
    {
        if ($this->_site != $val)
        {
            $this->_site = (string) $val;
            $this->_modified_fields['site'] = true;
        }
    }

    /**
     * @param string
     */
    public function setEmail($val)
    {
        if ($this->_email != $val)
        {
            $this->_email = (string) $val;
            $this->_modified_fields['email'] = true;
        }
    }

    /**
     * @param string
     */
    public function setIdCountry($val)
    {
        if ($this->_id_country != $val)
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
    public function delete()
    {
        // check de la table evenement
        if($this->hasEvents()) {
            throw new AdHocUserException('delete impossible, la structure est liée à des événements', EXCEPTION_USER_DEFAULT);
        }

        // check de la table audio
        if($this->hasAudios()) {
            throw new AdHocUserException('delete impossible, la structure est liée à des audios', EXCEPTION_USER_DEFAULT);
        }

        // check de la table photo
        if($this->hasPhotos()) {
            throw new AdHocUserException('delete impossible, la structure est liée à des photos', EXCEPTION_USER_DEFAULT);
        }

        // check de la table video
        if($this->hasVideos()) {
            throw new AdHocUserException('delete impossible, la structure est liée à des vidéos', EXCEPTION_USER_DEFAULT);
        }

        // tout est ok on delete
        $sql = "DELETE FROM `" . self::$_db_table_structure . "` "
             . "WHERE `id_structure` = " . (int) $this->_id_structure;

        $db = DataBase::getInstance();
        $res  = $db->query($sql);
        if($db->affectedRows()) {
            if(file_exists(self::_getLocalPath() . '/' . $this->_id_structure . '.png')) {
                unlink(self::_getLocalPath() . '/' . $this->_id_structure . '.png');
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
    public static function getStructures()
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
    public function _loadFromDb()
    {
        $db = DataBase::getInstance();

        $sql  = "SELECT `name`, "
              . "`address`, `cp`, `city`, `tel`, `fax`, `id_departement`, "
              . "`text`, `site`, `email`, `id_country` "
              . "FROM `" . self::$_db_table_structure . "` "
              . "WHERE `id_structure` = " . (int) $this->_id_structure;

        if($res = $db->queryWithFetchFirstRow($sql)) {
            $this->_dbToObject($res);
            if(file_exists(self::_getLocalPath() . '/' . $this->_id_structure . '.png')) {
                $this->_photo = self::_getWwwPath() . '/' . $this->_id_structure . '.png';
            }
            return true;
        }
        return false; // todo exception
    }

    /**
     * @return bool
     */
    public function hasPhotos()
    {
        return (bool) $this->getPhotos();
    }

    /**
     * retourne les photos associées à cette structure
     *
     * @return array
     */
    public function getPhotos()
    {
        return Photo::getPhotos(array(
            'structure' => $this->_id_structure,
        ));
    }

    /**
     * @return bool
     */
    public function hasVideos()
    {
        return (bool) $this->getVideos();
    }

    /**
     * retourne les vidéos associées à cette structure
     *
     * @return array
     */
    public function getVideos()
    {
        return Video::getVideos(array(
            'structure' => $this->_id_structure,
        ));
    }

    /**
     * @return bool
     */
    public function hasAudios()
    {
        return (bool) $this->getAudios();
    }

    /**
     * retourne les audios associés à cette structure
     *
     * @return array
     */
    public function getAudios()
    {
        return Audio::getAudios(array(
            'structure' => $this->_id_structure,
        ));
    }

    /**
     * @return bool
     */
    public function hasEvenements()
    {
        return (bool) $this->getEvenements();
    }

    /**
     * retourne les événements rattachés à cette structure
     *
     * @return array
     */
    public function getEvenements()
    {
        return Event::getEvents(array(
            'structure' => $this->_id_structure,
        ));
    }
}
