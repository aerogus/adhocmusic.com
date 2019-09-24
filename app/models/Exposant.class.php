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
    function getName(): string
    {
        return $this->_name;
    }

    /**
     * @return string
     */
    function getEmail(): string
    {
        return $this->_email;
    }

    /**
     * @return string
     */
    function getPhone(): string
    {
        return $this->_phone;
    }

    /**
     * @return string
     */
    function getSite(): string
    {
        return $this->_site;
    }

    /**
     * @return string
     */
    function getType(): string
    {
        return $this->_type;
    }

    /**
     * @return string
     */
    function getCity(): string
    {
        return $this->_city;
    }

    /**
     * @return string
     */
    function getDescription(): string
    {
        return $this->_description;
    }

    /**
     * @return string
     */
    function getState(): string
    {
        return $this->_state;
    }

    /**
     * @return string|null
     */
    function getCreatedOn(): ?string
    {
        if (Date::isDateTimeOk($this->_created_on)) {
            return $this->_created_on;
        }
        return null;
    }

    /**
     * @return int|null
     */
    function getCreatedOnTs(): ?int
    {
        if (Date::isDateTimeOk($this->_created_on)) {
            return strtotime($this->_created_on);
        }
        return null;
    }

    /**
     * @return string|null
     */
    function getModifiedOn(): ?string
    {
        if (Date::isDateTimeOk($this->_modified_on)) {
            return $this->_modified_on;
        }
        return null;
    }

    /**
     * @return int|null
     */
    function getModifiedOnTs(): ?int
    {
        if (Date::isDateTimeOk($this->_modified_on)) {
            return strtotime($this->_modified_on);
        }
        return null;
    }

    /* fin getters */

    /* début setters */

    /**
     * @param string $val nom
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
     * @param string $val email
     *
     * @return object
     */
    function setEmail(string $val): object
    {
        if ($this->_email !== $val) {
            $this->_email = $val;
            $this->_modified_fields['email'] = true;
        }

        return $this;
    }

    /**
     * @param string $val téléphone
     *
     * @return object
     */
    function setPhone(string $val): object
    {
        if ($this->_phone !== $val) {
            $this->_phone = $val;
            $this->_modified_fields['phone'] = true;
        }

        return $this;
    }

    /**
     * @param string $val val
     *
     * @return object
     */
    function setSite(string $val): object
    {
        if ($this->_site !== $val) {
            $this->_site = $val;
            $this->_modified_fields['site'] = true;
        }

        return $this;
    }

    /**
     * @param string $val val
     *
     * @return object
     */
    function setType(string $val): object
    {
        if ($this->_type !== $val) {
            $this->_type = $val;
            $this->_modified_fields['type'] = true;
        }

        return $this;
    }

    /**
     * @param string $val val
     *
     * @return object
     */
    function setCity(string $val): object
    {
        if ($this->_city !== $val) {
            $this->_city = $val;
            $this->_modified_fields['city'] = true;
        }

        return $this;
    }

    /**
     * @param string $val
     *
     * @return object
     */
    function setState(string $val): object
    {
        if ($this->_state !== $val) {
            $this->_state = $val;
            $this->_modified_fields['state'] = true;
        }

        return $this;
    }

    /**
     * @param string $val
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
     * @param string
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

    /* fin setters */

    /**
     * Retourne le nombre de d'exposants référencés
     *
     * @return int
     */
    static function getExposantsCount()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(*) FROM `" . Exposant::getDbTable() . "`";

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
             . "FROM `" . Exposant::getDbTable() . "` "
             . "WHERE 1 ";

        $res = $db->queryWithFetch($sql);

        return $res;
    }

    /**
     * Suppression d'un exposant
     */
    function delete()
    {
        parent::delete();
    }
}
