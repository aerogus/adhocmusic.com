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
     * Instance de l'objet
     *
     * @var mixed
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
     *
     * @var array
     */
    protected static $_all_fields = [
        'id_exposant' => 'int', // pk
        'name'        => 'string',
        'email'       => 'string',
        'phone'       => 'string',
        'site'        => 'string',
        'type'        => 'string',
        'city'        => 'string',
        'description' => 'string',
        'state'       => 'string',
        'created_on'  => 'date',
        'modified_on' => 'date',
    ];

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
     * @param string $name nom
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
     * @param string $email email
     *
     * @return object
     */
    function setEmail(string $email): object
    {
        if ($this->_email !== $email) {
            $this->_email = $email;
            $this->_modified_fields['email'] = true;
        }

        return $this;
    }

    /**
     * @param string $phone téléphone
     *
     * @return object
     */
    function setPhone(string $phone): object
    {
        if ($this->_phone !== $phone) {
            $this->_phone = $phone;
            $this->_modified_fields['phone'] = true;
        }

        return $this;
    }

    /**
     * @param string $site site
     *
     * @return object
     */
    function setSite(string $site): object
    {
        if ($this->_site !== $site) {
            $this->_site = $site;
            $this->_modified_fields['site'] = true;
        }

        return $this;
    }

    /**
     * @param string $type type
     *
     * @return object
     */
    function setType(string $type): object
    {
        if ($this->_type !== $type) {
            $this->_type = $type;
            $this->_modified_fields['type'] = true;
        }

        return $this;
    }

    /**
     * @param string $city city
     *
     * @return object
     */
    function setCity(string $city): object
    {
        if ($this->_city !== $city) {
            $this->_city = $city;
            $this->_modified_fields['city'] = true;
        }

        return $this;
    }

    /**
     * @param string $state état
     *
     * @return object
     */
    function setState(string $state): object
    {
        if ($this->_state !== $state) {
            $this->_state = $state;
            $this->_modified_fields['state'] = true;
        }

        return $this;
    }

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

    /* fin setters */

    /**
     * Retourne une collection d'objets "Exposant" répondant au(x) critère(s)
     *
     * @param array $params param
     *
     * @return array
     */
    static function find(array $params): array
    {
        // @TODO à implémenter
        return [];
    }
}
