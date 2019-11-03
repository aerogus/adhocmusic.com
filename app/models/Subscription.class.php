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
     * on précise si en base c'est de type :
     * - numérique/integer/float/bool (= int)
     * - datetime/text (= str)
     * ceci est utile pour la formation de la requête
     *
     * @var array
     */
    protected static $_all_fields = [
        'id_subscription' => 'int',
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
     * @param string $val val
     *
     * @return object
     */
    function setCreatedAt(string $val): object
    {
        if ($this->_created_at !== $val) {
            $this->_created_at = $val;
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
     * @param string $val val
     *
     * @return object
     */
    function setSubscribedAt(string $val): object
    {
        if ($this->_subscribed_at !== $val) {
            $this->_subscribed_at = $val;
            $this->_modified_fields['subscribed_at'] = true;
        }

        return $this;
    }

    /**
     * @param bool $val val
     *
     * @return object
     */
    function setAdult(bool $val): object
    {
        if ($this->_adult !== $val) {
            $this->_adult = $val;
            $this->_modified_fields['adult'] = true;
        }
        return $this;
    }

    /**
     * @param float $val val
     *
     * @return object
     */
    function setAmount(float $val): object
    {
        if ($this->_amount !== $val) {
            $this->_amount = $val;
            $this->_modified_fields['amount'] = true;
        }
        return $this;
    }

    /**
     * @param string $val val
     *
     * @return object
     */
    function setFirstName(string $val): object
    {
        if ($this->_first_name !== $val) {
            $this->_first_name = $val;
            $this->_modified_fields['first_name'] = true;
        }

        return $this;
    }

    /**
     * @param string $val val
     *
     * @return object
     */
    function setLastName(string $val): object
    {
        if ($this->_last_name !== $val) {
            $this->_last_name = $val;
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
     * @param string $val val
     *
     * @return object
     */
    function setCp(string $val): object
    {
        if ($this->_cp !== $val) {
            $this->_cp = $val;
            $this->_modified_fields['cp'] = true;
        }

        return $this;
    }

    /**
     * @param int $val val
     *
     * @return object
     */
    function setIdContact(int $val): object
    {
        if ($this->_id_contact !== $val) {
            $this->_id_contact = $val;
            $this->_modified_fields['id_contact'] = true;
        }

        return $this;
    }

    /* fin setters */
}
