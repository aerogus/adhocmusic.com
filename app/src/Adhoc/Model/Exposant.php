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
     * @var ?int
     */
    protected ?int $id_exposant = null;

    /**
     * @var ?string
     */
    protected ?string $name = null;

    /**
     * @var ?string
     */
    protected ?string $email = null;

    /**
     * @var ?string
     */
    protected ?string $phone = null;

    /**
     * @var ?string
     */
    protected ?string $site = null;

    /**
     * @var ?string
     */
    protected ?string $type = null;

    /**
     * @var ?string
     */
    protected ?string $city = null;

    /**
     * @var ?string
     */
    protected ?string $description = null;

    /**
     * @var ?string
     */
    protected ?string $state = null;

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
        'name' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'site' => 'string',
        'type' => 'string',
        'city' => 'string',
        'description' => 'string',
        'state' => 'string',
        'created_at' => 'date',
        'modified_at' => 'date',
    ];

    /* début getters */

    /**
     * @return ?string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return ?string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return ?string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @return ?string
     */
    public function getSite(): ?string
    {
        return $this->site;
    }

    /**
     * @return ?string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return ?string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @return ?string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return ?string
     */
    public function getState(): ?string
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
     * @return static
     */
    public function setName(string $name): static
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
     * @return static
     */
    public function setEmail(string $email): static
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
     * @return static
     */
    public function setPhone(string $phone): static
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
     * @return static
     */
    public function setSite(string $site): static
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
     * @return static
     */
    public function setType(string $type): static
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
     * @return static
     */
    public function setCity(string $city): static
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
     * @return static
     */
    public function setState(string $state): static
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
     * @return static
     */
    public function setCreatedAt(string $created_at): static
    {
        if ($this->created_at !== $created_at) {
            $this->created_at = $created_at;
            $this->modified_fields['created_at'] = true;
        }

        return $this;
    }

    /**
     * @return static
     */
    public function setCreatedNow(): static
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
     * @return static
     */
    public function setModifiedAt(string $modified_at): static
    {
        if ($this->modified_at !== $modified_at) {
            $this->modified_at = $modified_at;
            $this->modified_fields['modified_at'] = true;
        }

        return $this;
    }

    /**
     * @return static
     */
    public function setModifiedNow(): static
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
