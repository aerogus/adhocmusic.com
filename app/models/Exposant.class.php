<?php declare(strict_types=1);

/**
 * Gestion des exposants
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Exposant extends ObjectModel
{
    /**
     * @var object
     */
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static $_pk = 'id_exposant';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_exposant';

    /**
     * @var int
     */
    protected $_id_exposant = 0;

    /**
     * @var string
     */
    protected $_name = '';

    /**
     * @var string
     */
    protected $_email = '';

    /**
     * @var string
     */
    protected $_phone = '';

    /**
     * @var string
     */
    protected $_site = '';

    /**
     * @var string
     */
    protected $_type = '';

    /**
     * @var string
     */
    protected $_city = '';

    /**
     * @var string
     */
    protected $_description = '';

    /**
     * @var string
     */
    protected $_state = '';

    /**
     * @var string
     */
    protected $_created_on = null;

    /**
     * @var string
     */
    protected $_modified_on = null;

    /**
     * Liste des attributs de l'objet
     * on précise si en base c'est de type :
     * - numérique/integer/float/bool (= int)
     * - datetime/text (= str)
     * ceci est utile pour la formation de la requête
     * @var array
     */
    protected static $_all_fields = [
        'name'        => 'str',
        'email'       => 'str',
        'phone'       => 'str',
        'site'        => 'str',
        'type'        => 'str',
        'city'        => 'str',
        'description' => 'str',
        'state'       => 'str',
        'created_on'  => 'date',
        'modified_on' => 'date',
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
    function getName()
    {
        return (string) $this->_name;
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
    function getPhone()
    {
        return (string) $this->_phone;
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
    function getType()
    {
        return (string) $this->_type;
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
    function getDescription()
    {
        return (string) $this->_description;
    }

    /**
     * @return string
     */
    function getState()
    {
        return (string) $this->_state;
    }

    /**
     * @return string
     */
    function getCreatedOn()
    {
        if (Date::isDateTimeOk($this->_created_on)) {
            return (string) $this->_created_on;
        }
        return false;
    }

    /**
     * @return int
     */
    function getCreatedOnTs()
    {
        if (Date::isDateTimeOk($this->_created_on)) {
            return (int) strtotime($this->_created_on);
        }
        return false;
    }

    /**
     * @return string
     */
    function getModifiedOn()
    {
        if (Date::isDateTimeOk($this->_modified_on)) {
            return (string) $this->_modified_on;
        }
        return false;
    }

    /**
     * @return int
     */
    function getModifiedOnTs()
    {
        if (Date::isDateTimeOk($this->_modified_on)) {
            return (int) strtotime($this->_modified_on);
        }
        return false;
    }

    /* fin getters */

    /* début setters */

    /**
     * @param string $val nom
     */
    function setName(string $val)
    {
        if ($this->_name !== $val) {
            $this->_name = $val;
            $this->_modified_fields['name'] = true;
        }
    }

    /**
     * @param string $val email
     */
    function setEmail(string $val)
    {
        if ($this->_email !== $val) {
            $this->_email = $val;
            $this->_modified_fields['email'] = true;
        }
    }

    /**
     * @param string
     */
    function setPhone(string $val)
    {
        if ($this->_phone !== $val) {
            $this->_phone = $val;
            $this->_modified_fields['phone'] = true;
        }
    }

    /**
     * @param string
     */
    function setSite(string $val)
    {
        if ($this->_site !== $val) {
            $this->_site = $val;
            $this->_modified_fields['site'] = true;
        }
    }

    /**
     * @param string $val
     */
    function setType(string $val)
    {
        if ($this->_type !== $val) {
            $this->_type = $val;
            $this->_modified_fields['type'] = true;
        }
    }

    /**
     * @param string $val
     */
    function setCity(string $val)
    {
        if ($this->_city !== $val) {
            $this->_city = $val;
            $this->_modified_fields['city'] = true;
        }
    }

    /**
     * @param string $val
     */
    function setState(string $val)
    {
        if ($this->_state !== $val) {
            $this->_state = $val;
            $this->_modified_fields['state'] = true;
        }
    }

    /**
     * @param string $val
     */
    function setCreatedOn(string $val)
    {
        if ($this->_created_on !== $val) {
            $this->_created_on = $val;
            $this->_modified_fields['created_on'] = true;
        }
    }

    /**
     *
     */
    function setCreatedNow()
    {
        $now = date('Y-m-d H:i:s');
        if ($this->_created_on !== $now) {
            $this->_created_on = $now;
            $this->_modified_fields['created_on'] = true;
        }
    }

    /**
     * @param string
     */
    function setModifiedOn(string $val)
    {
        if ($this->_modified_on !== $val) {
            $this->_modified_on = $val;
            $this->_modified_fields['modified_on'] = true;
        }
    }

    /**
     *
     */
    function setModifiedNow()
    {
        $now = date('Y-m-d H:i:s');
        if ($this->_modified_on !== $now) {
            $this->_modified_on = $now;
            $this->_modified_fields['modified_on'] = true;
        }
    }

    /* fin setters */

    /**
     * Retourne le nombre de d'exposants référencés
     *
     * @return int
     */
    static function getExposantsCount()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(*) "
             . "FROM `" . self::$_db_table_exposant . "`";

        return $db->queryWithFetchFirstField($sql);
    }

    /**
     * @return array
     */
    static function getExposants()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_exposant` AS `id`, `name`, `email`, `phone`, "
             . "`site`, `type`, `city`, `description`, `state`, `created_on`, `modified_on` "
             . "FROM `" . self::$_db_table_exposant . "` "
             . "WHERE 1 ";

        $res = $db->queryWithFetch($sql);

        return $res;
    }

    /**
     *
     */
    protected function _loadFromDb()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_exposant` AS `id`, `name`, `email`, `phone`, "
             . "`site`, `type`, `city`, `description`, `state`, `created_on`, `modified_on` "
             . "FROM `" . self::$_db_table_exposant . "` "
             . "WHERE `id_exposant` = " . (int) $this->_id_exposant;

        if (($res = $db->queryWithFetchFirstRow($sql))) {
            $this->_dbToObject($res);
            return true;
        }

        throw new Exception('id_exposant_introuvable');
    }

    /**
     * Suppression d'un exposant
     */
    function delete()
    {
        parent::delete();
    }
}
