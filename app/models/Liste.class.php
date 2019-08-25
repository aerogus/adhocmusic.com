<?php

/**
 * Classe abstraite Liste à étendre
 * utilisé pour World
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
abstract class Liste
{
    /**
     * Instance de l'objet
     *
     * @var mixed
     */
    protected static $_instance = null;

    /**
     * Conteneur de la liste brute
     *
     * @var array
     */
    protected static $_liste = [];

    /**
     *
     */
    function __construct()
    {
        $this->_loadFromDb();
        static::$_instance = $this;
    }

    /**
     *
     */
    static function getInstance()
    {
        //if (is_null(static::$_instance)) {
            return new static();
        //}
        return static::$_instance;
    }

    /**
     *
     */
    static function deleteInstance()
    {
        if (isset(static::$_instance)) {
            static::$_instance = null;
            return true;
        }
        return false;
    }

    /**
     * retourne le tableau de la liste
     *
     * @return array
     */
    static function getHashTable()
    {
        $o = static::getInstance();
        return $o->_getHashTable();
    }

    /**
     * @return array
     */
    protected function _getHashTable()
    {
        return static::$_liste;
    }
}
