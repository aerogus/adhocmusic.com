<?php

declare(strict_types=1);

namespace Adhoc\Model;

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
     * @var object
     */
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static string $_pk = 'id_exposant';

    /**
     * @var string
     */
    protected static string $_table = 'adhoc_exposant';

    /**
     * @var int
     */
    protected int $_id_exposant = 0;

    /**
     * @var string
     */
    protected string $_name = '';

    /**
     * @var string
     */
    protected string $_email = '';

    /**
     * @var string
     */
    protected string $_phone = '';

    /**
     * @var string
     */
    protected string $_site = '';

    /**
     * @var string
     */
    protected string $_type = '';

    /**
     * @var string
     */
    protected string $_city = '';

    /**
     * @var string
     */
    protected string $_description = '';

    /**
     * @var string
     */
    protected string $_state = '';

    /**
     * @var ?string
     */
    protected ?string $_created_at = null;

    /**
     * @var ?string
     */
    protected ?string $_modified_at = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
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
        'created_at'  => 'date',
        'modified_at' => 'date',
    ];

    /* début getters */

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->_name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->_email;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->_phone;
    }

    /**
     * @return string
     */
    public function getSite(): string
    {
        return $this->_site;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->_type;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->_city;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->_description;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->_state;
    }

    /**
     * @return ?string
     */
    public function getCreatedAt(): ?string
    {
        if (Date::isDateTimeOk($this->_created_at)) {
            return $this->_created_at;
        }
        return null;
    }

    /**
     * @return ?int
     */
    public function getCreatedAtTs(): ?int
    {
        if (Date::isDateTimeOk($this->_created_at)) {
            return strtotime($this->_created_at);
        }
        return null;
    }

    /**
     * @return ?string
     */
    public function getModifiedAt(): ?string
    {
        if (Date::isDateTimeOk($this->_modified_at)) {
            return $this->_modified_at;
        }
        return null;
    }

    /**
     * @return ?int
     */
    public function getModifiedAtTs(): ?int
    {
        if (Date::isDateTimeOk($this->_modified_at)) {
            return strtotime($this->_modified_at);
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
    public function setName(string $name): object
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
    public function setEmail(string $email): object
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
    public function setPhone(string $phone): object
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
    public function setSite(string $site): object
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
    public function setType(string $type): object
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
    public function setCity(string $city): object
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
    public function setState(string $state): object
    {
        if ($this->_state !== $state) {
            $this->_state = $state;
            $this->_modified_fields['state'] = true;
        }

        return $this;
    }

    /**
     * @param string $created_at created_at
     *
     * @return object
     */
    public function setCreatedAt(string $created_at): object
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
    public function setCreatedNow(): object
    {
        $now = date('Y-m-d H:i:s');

        if ($this->_created_at !== $now) {
            $this->_created_at = $now;
            $this->_modified_fields['created_at'] = true;
        }

        return $this;
    }

    /**
     * @param string $modified_at modified_at
     *
     * @return object
     */
    public function setModifiedAt(string $modified_at): object
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
    public function setModifiedNow(): object
    {
        $now = date('Y-m-d H:i:s');

        if ($this->_modified_at !== $now) {
            $this->_modified_at = $now;
            $this->_modified_fields['modified_at'] = true;
        }

        return $this;
    }

    /* fin setters */
}
