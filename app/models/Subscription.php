<?php

declare(strict_types=1);

namespace Adhoc\Model;

/**
 * Gestion des Cotisations
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Subscription extends ObjectModel
{
    /**
     * Instance de l'objet
     *
     * @var object
     */
    protected static $instance = null;

    /**
     * @var string
     */
    protected static string $pk = 'id_subscription';

    /**
     * @var string
     */
    protected static string $table = 'adhoc_subscription';

    /**
     * @var int
     */
    protected int $id_subscription = 0;

    /**
     * @var ?string
     */
    protected ?string $created_at = null;

    /**
     * @var ?string
     */
    protected ?string $subscribed_at = null;

    /**
     * @var ?bool
     */
    protected ?bool $adult = null;

    /**
     * @var ?float
     */
    protected ?float $amount = null;

    /**
     * @var ?string
     */
    protected ?string $first_name = null;

    /**
     * @var ?string
     */
    protected ?string $last_name = null;

    /**
     * @var ?string
     */
    protected ?string $email = null;

    /**
     * @var ?string
     */
    protected ?string $cp = null;

    /**
     * @var ?int
     */
    protected ?int $id_contact = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_subscription' => 'int', // pk
        'created_at'      => 'date',
        'subscribed_at'   => 'date',
        'amount'          => 'float',
        'adult'           => 'bool',
        'first_name'      => 'string',
        'last_name'       => 'string',
        'email'           => 'string',
        'cp'              => 'string',
        'id_contact'      => 'int',
    ];

    /* début getters */

    /**
     * Retourne la date de saise de la cotisation format YYYY-MM-DD HH:II:SS
     *
     * @return ?string
     */
    public function getCreatedAt(): ?string
    {
        if (!is_null($this->created_at) && Date::isDateTimeOk($this->created_at)) {
            return $this->created_at;
        }
        return null;
    }

    /**
     * Retourne la date de la cotisation format YYYY-MM-DD HH:II:SS
     *
     * @return ?string
     */
    public function getSubscribedAt(): ?string
    {
        if (!is_null($this->subscribed_at) && Date::isDateTimeOk($this->subscribed_at)) {
            return $this->subscribed_at;
        }
        return null;
    }

    /**
     * Est-ce un adulte au moment de l'inscription
     *
     * @return bool
     */
    public function getAdult(): ?bool
    {
        return $this->adult;
    }

    /**
     * Retourne le montant de la cotisation
     *
     * @return float
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    /**
     * @return string
     */
    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getCp(): ?string
    {
        return $this->cp;
    }

    /**
     * @return int
     */
    public function getIdContact(): ?int
    {
        return $this->id_contact;
    }

    /* fin getters */

    /* début setters */

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
     * @param string $subscribed_at subscribed_at
     *
     * @return object
     */
    public function setSubscribedAt(string $subscribed_at): object
    {
        if ($this->subscribed_at !== $subscribed_at) {
            $this->subscribed_at = $subscribed_at;
            $this->modified_fields['subscribed_at'] = true;
        }

        return $this;
    }

    /**
     * @param bool $adult adult
     *
     * @return object
     */
    public function setAdult(bool $adult): object
    {
        if ($this->adult !== $adult) {
            $this->adult = $adult;
            $this->modified_fields['adult'] = true;
        }
        return $this;
    }

    /**
     * @param float $amount amount
     *
     * @return object
     */
    public function setAmount(float $amount): object
    {
        if ($this->amount !== $amount) {
            $this->amount = $amount;
            $this->modified_fields['amount'] = true;
        }
        return $this;
    }

    /**
     * @param string $first_name first_name
     *
     * @return object
     */
    public function setFirstName(string $first_name): object
    {
        if ($this->first_name !== $first_name) {
            $this->first_name = $first_name;
            $this->modified_fields['first_name'] = true;
        }

        return $this;
    }

    /**
     * @param string $last_name last_name
     *
     * @return object
     */
    public function setLastName(string $last_name): object
    {
        if ($this->last_name !== $last_name) {
            $this->last_name = $last_name;
            $this->modified_fields['last_name'] = true;
        }

        return $this;
    }

    /**
     * @param string $email email
     *
     * @return object
     * @throws \Exception
     */
    public function setEmail(string $email): object
    {
        if (!Email::validate($email)) {
            throw new \Exception('email ' . $email . ' invalide');
        }

        if ($this->email !== $email) {
            $this->email = $email;
            $this->modified_fields['email'] = true;
        }

        return $this;
    }

    /**
     * @param string $cp cp
     *
     * @return object
     */
    public function setCp(string $cp): object
    {
        if ($this->cp !== $cp) {
            $this->cp = $cp;
            $this->modified_fields['cp'] = true;
        }

        return $this;
    }

    /**
     * @param int $id_contact id_contact
     *
     * @return object
     */
    public function setIdContact(int $id_contact): object
    {
        if ($this->id_contact !== $id_contact) {
            $this->id_contact = $id_contact;
            $this->modified_fields['id_contact'] = true;
        }

        return $this;
    }

    /* fin setters */
}
