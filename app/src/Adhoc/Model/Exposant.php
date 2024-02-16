<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Utils\Date;
use Adhoc\Utils\ObjectModel;

/**
 * Gestion des exposants
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class Exposant extends ObjectModel
{
    /**
     * @var string|array<string>
     */
    protected static string|array $pk = 'id_exposant';

    /**
     * @var string
     */
    protected static string $table = 'adhoc_exposant';

    /**
     * @var int
     */
    protected int $id_exposant = 0;

    /**
     * @var string
     */
    protected string $name = '';

    /**
     * @var string
     */
    protected string $email = '';

    /**
     * @var string
     */
    protected string $phone = '';

    /**
     * @var string
     */
    protected string $site = '';

    /**
     * @var string
     */
    protected string $type = '';

    /**
     * @var string
     */
    protected string $city = '';

    /**
     * @var string
     */
    protected string $description = '';

    /**
     * @var string
     */
    protected string $state = '';

    /**
     * @var ?string
     */
    protected ?string $created_at = null;

    /**
     * @var ?string
     */
    protected ?string $modified_at = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
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
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getSite(): string
    {
        return $this->site;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @return ?string
     */
    public function getCreatedAt(): ?string
    {
        if (Date::isDateTimeOk($this->created_at)) {
            return $this->created_at;
        }
        return null;
    }

    /**
     * @return ?int
     */
    public function getCreatedAtTs(): ?int
    {
        if (Date::isDateTimeOk($this->created_at)) {
            return strtotime($this->created_at);
        }
        return null;
    }

    /**
     * @return ?string
     */
    public function getModifiedAt(): ?string
    {
        if (Date::isDateTimeOk($this->modified_at)) {
            return $this->modified_at;
        }
        return null;
    }

    /**
     * @return ?int
     */
    public function getModifiedAtTs(): ?int
    {
        if (Date::isDateTimeOk($this->modified_at)) {
            return strtotime($this->modified_at);
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
        if ($this->name !== $name) {
            $this->name = $name;
            $this->modified_fields['name'] = true;
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
        if ($this->email !== $email) {
            $this->email = $email;
            $this->modified_fields['email'] = true;
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
        if ($this->phone !== $phone) {
            $this->phone = $phone;
            $this->modified_fields['phone'] = true;
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
        if ($this->site !== $site) {
            $this->site = $site;
            $this->modified_fields['site'] = true;
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
        if ($this->type !== $type) {
            $this->type = $type;
            $this->modified_fields['type'] = true;
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
        if ($this->city !== $city) {
            $this->city = $city;
            $this->modified_fields['city'] = true;
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
        if ($this->state !== $state) {
            $this->state = $state;
            $this->modified_fields['state'] = true;
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
        if ($this->created_at !== $created_at) {
            $this->created_at = $created_at;
            $this->modified_fields['created_at'] = true;
        }

        return $this;
    }

    /**
     * @return object
     */
    public function setCreatedNow(): object
    {
        $now = date('Y-m-d H:i:s');

        if ($this->created_at !== $now) {
            $this->created_at = $now;
            $this->modified_fields['created_at'] = true;
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
        if ($this->modified_at !== $modified_at) {
            $this->modified_at = $modified_at;
            $this->modified_fields['modified_at'] = true;
        }

        return $this;
    }

    /**
     * @return object
     */
    public function setModifiedNow(): object
    {
        $now = date('Y-m-d H:i:s');

        if ($this->modified_at !== $now) {
            $this->modified_at = $now;
            $this->modified_fields['modified_at'] = true;
        }

        return $this;
    }

    /* fin setters */
}
