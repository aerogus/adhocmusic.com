<?php

/**
 * Gestion des interactions avec le compte OVH
 * API SOAP OVH
 * @see http://www.ovh.com/soapi/fr/
 */
class OvhApi
{
    const URL         = "https://www.ovh.com/soapi/soapi-re-1.30.wsdl";
    const DOMAIN      = "adhocmusic.com";

    private static $_instance = null;

    private $_soap     = null;
    private $_session  = null;
    private $_errstr   = null;

    private static $_accounts = array(
        'sg81-ovh' => 'oa42if73',
        'dg48001-ovh' => 'fdhnyycbjn',
    );

    private $_nickhandle = null;

    /**
     *
     */
    public function __construct($nickhandle = 'sg81-ovh')
    {
        $this->_soap = new SoapClient(self::URL);
        $this->_session = $this->_soap->login($nickhandle, self::_getPassword($nickhandle), "fr", false);
        $this->_nickhandle = $nickhandle;
        self::$_instance = $this;
    }

    /**
     *
     */
    public function __destruct()
    {
        $this->_soap->logout($this->_session);
    }

    /**
     *
     */
    public static function getInstance($nickhandle)
    {
        if (is_null(self::$_instance)) {
            // pas du tout d'instance: on en crée une, le constructeur ira s'enregistrer
            // dans la variable statique.
            return new self($nickhandle);
        }
        if (static::$_instance->_nickhandle != $nickhandle) {
            // on a deja une instance, mais ce n'est pas le bon id
            self::deleteInstance();
            new self($nickhandle);
        } else {
            // tout est ok
        }
        return self::$_instance;
    }

    /**
     *
     */
    public static function deleteInstance()
    {
        if (isset(self::$_instance)) {
            self::$_instance = null;
            return true;
        }
        return false;
    }

    /*********************************/

    public function billingInvoiceList()
    {
        $r = $this->_soap->billingInvoiceList($this->_session);
        return $r;
    }

    public function domainList()
    {
        $r = $this->_soap->domainList($this->_session);
        return $r;
    }

    public function domainInfo($domain)
    {
        $r = $this->_soap->domainInfo($this->_session, $domain);
        return $r;
    }

    /**
     * retourne la liste des bases de données
     * @return array
     */
    public function databaseList()
    {
        $r = $this->_soap->databaseList($this->_session, self::DOMAIN);
        return $r;
    }

    /**
     * retourne la liste des listes de diffusion
     * @return array
     */
    public function mailingListList()
    {
        $r = $this->_soap->mailingListList($this->_session, self::DOMAIN);
        return $r;
    }

    /**
     * retourne les infos d'une liste de diffusion
     * @param string nom de la liste
     * @return array
     */
    public function mailingListInfo($ml, $full = false)
    {
        if($full) {
            $r = $this->_soap->mailingListFullInfo($this->_session, self::DOMAIN, $ml);
        } else {
            $r = $this->_soap->mailingListInfo($this->_session, self::DOMAIN, $ml);
        }
        return $r;
    }

    public function mailingListSubscriberAdd($ml, $email)
    {
        $r = $this->_soap->mailingListSubscriberAdd($this->_session, self::DOMAIN, $ml, $email);
        return $r;
    }

    public function mailingListSubscriberDel($ml, $email)
    {
        $r = $this->_soap->mailingListSubscriberDel($this->_session, self::DOMAIN, $ml, $email);
        return $r;
    }

    public function mailingListSubscriberList($ml)
    {
        $r = $this->_soap->mailingListSubscriberList($this->_session, self::DOMAIN, $ml);
        return $r;
    }

    public function automatedMailGetErrors()
    {
        return false;
    }

    public function automatedMailGetState()
    {
        return false;
    }

    public function automatedMailGetTodo()
    {
        return false;
    }

    public function automatedMailGetVolumeHistory()
    {
        return false;
    }

    public function redirectedEmailAdd()
    {
        return false;
    }

    public function redirectedEmailDel()
    {
        return false;
    }

    public function redirectedEmailList()
    {
        return false;
    }

    public function redirectedEmailModify()
    {
        return false;
    }

    /*********************************/

    /**
     * @return string
     */
    private static function _getPassword($nickhandle)
    {
        return str_rot13(self::$_accounts[$nickhandle]);
    }
}
