<?php declare(strict_types=1);

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
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static $_pk = 'id_subscription';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_subscription';

    /**
     * @var int
     */
    protected $_id_subscription = 0;

    /**
     * @var string
     */
    protected $_created_at = null;

    /**
     * @var string
     */
    protected $_subscribed_at = null;

    /**
     * @var bool
     */
    protected $_adult = null;

    /**
     * @var float
     */
    protected $_amount = null;

    /**
     * @var string
     */
    protected $_first_name = null;

    /**
     * @var string
     */
    protected $_last_name = null;

    /**
     * @var string
     */
    protected $_email = null;

    /**
     * @var string
     */
    protected $_cp = null;

    /**
     * @var int
     */
    protected $_id_contact = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array
     */
    protected static $_all_fields = [
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
     * @return string|false
     */
    function getCreatedAt(): ?string
    {
        if (!is_null($this->_created_at) && Date::isDateTimeOk($this->_created_at)) {
            return $this->_created_at;
        }
        return null;
    }

    /**
     * Retourne la date de la cotisation format YYYY-MM-DD HH:II:SS
     *
     * @return string|false
     */
    function getSubscribedAt(): ?string
    {
        if (!is_null($this->_subscribed_at) && Date::isDateTimeOk($this->_subscribed_at)) {
            return $this->_subscribed_at;
        }
        return null;
    }

    /**
     * Est-ce un adulte au moment de l'inscription
     *
     * @return bool
     */
    function getAdult(): ?bool
    {
        return $this->_adult;
    }

    /**
     * Retourne le montant de la cotisation
     *
     * @return bool
     */
    function getAmount(): ?float
    {
        return $this->_amount;
    }

    /**
     * @return string
     */
    function getFirstName(): ?string
    {
        return $this->_first_name;
    }

    /**
     * @return string
     */
    function getLastName(): ?string
    {
        return $this->_last_name;
    }

    /**
     * @return string
     */
    function getEmail(): ?string
    {
        return $this->_email;
    }

    /**
     * @return string
     */
    function getCp(): ?string
    {
        return $this->_cp;
    }

    /**
     * @return int
     */
    function getIdContact(): ?int
    {
        return $this->_id_contact;
    }

    /* fin getters */

    /* début setters */

    /**
     * @param string $created_at created_at
     *
     * @return object
     */
    function setCreatedAt(string $created_at): object
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
    function setCreatedNow(): object
    {
        $now = date('Y-m-d H:i:s');

        if ($this->_created_at !== $now) {
            $this->_created_at = $now;
            $this->_modified_fields['created_at'] = true;
        }

        return $this;
    }

    /**
     * @param string $subscribed_at subscribed_at
     *
     * @return object
     */
    function setSubscribedAt(string $subscribed_at): object
    {
        if ($this->_subscribed_at !== $subscribed_at) {
            $this->_subscribed_at = $subscribed_at;
            $this->_modified_fields['subscribed_at'] = true;
        }

        return $this;
    }

    /**
     * @param bool $adult adult
     *
     * @return object
     */
    function setAdult(bool $adult): object
    {
        if ($this->_adult !== $adult) {
            $this->_adult = $adult;
            $this->_modified_fields['adult'] = true;
        }
        return $this;
    }

    /**
     * @param float $amount amount
     *
     * @return object
     */
    function setAmount(float $amount): object
    {
        if ($this->_amount !== $amount) {
            $this->_amount = $amount;
            $this->_modified_fields['amount'] = true;
        }
        return $this;
    }

    /**
     * @param string $first_name first_name
     *
     * @return object
     */
    function setFirstName(string $first_name): object
    {
        if ($this->_first_name !== $first_name) {
            $this->_first_name = $first_name;
            $this->_modified_fields['first_name'] = true;
        }

        return $this;
    }

    /**
     * @param string $last_name last_name
     *
     * @return object
     */
    function setLastName(string $last_name): object
    {
        if ($this->_last_name !== $last_name) {
            $this->_last_name = $last_name;
            $this->_modified_fields['last_name'] = true;
        }

        return $this;
    }

    /**
     * @param string $email email
     *
     * @return object
     * @throws Exception
     */
    function setEmail(string $email): object
    {
        if (!Email::validate($email)) {
            throw new Exception('email ' . $email . ' invalide');
        }

        if ($this->_email !== $email) {
            $this->_email = $email;
            $this->_modified_fields['email'] = true;
        }

        return $this;
    }

    /**
     * @param string $cp cp
     *
     * @return object
     */
    function setCp(string $cp): object
    {
        if ($this->_cp !== $cp) {
            $this->_cp = $cp;
            $this->_modified_fields['cp'] = true;
        }

        return $this;
    }

    /**
     * @param int $id_contact id_contact
     *
     * @return object
     */
    function setIdContact(int $id_contact): object
    {
        if ($this->_id_contact !== $id_contact) {
            $this->_id_contact = $id_contact;
            $this->_modified_fields['id_contact'] = true;
        }

        return $this;
    }

    /* fin setters */
}
