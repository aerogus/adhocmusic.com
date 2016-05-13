<?php

/**
 * @package adhoc
 */

/**
 * Classe City
 * (villes de France uniquement)
 * pk = code insee
 *
 * @package adhoc
 * @author Guillaume Seznec <guillaume.seznec@gmail.com>
 */
class City extends Liste
{
    /**
     * quelques racourcis codes insee
     */
    const SPINOLIE = 91216;
    const SAULX = 91587;

    /**
     * instance de l'objet
     *
     * @var mixed
     */
    protected static $_instance = null;

    /**
     * Code insee ville ok ?
     *
     * @param int $id_city
     * @return bool
     */
    function isCityOk($id_city)
    {
        $o = static::getInstance();
        return $o->_isCityOk($id_city);
    }

    /**
     *
     */
    static function getName($id_city)
    {
        $o = static::getInstance();
        return $o->_getName($id_city);
    }

    /**
     *
     */
    static function getIdDepartement($id_city)
    {
        $o = static::getInstance();
        return $o->_getIdDepartement($id_city);
    }

    /**
     *
     */
    static function getCp($id_city)
    {
        $o = static::getInstance();
        return $o->_getCp($id_city);
    }

    /**
     * Code insee ville ok ?
     *
     * @param int $id_city
     * @return bool
     */
    protected function _isCityOk($id_city)
    {
        if(array_key_exists($id_city, static::$_liste)) {
            return true;
        }
        return false;
    }

    /**
     * retourne le nom d'une ville
     *
     * @param int $id_city
     * @return string
     */
    protected function _getName($id_city)
    {
        if(array_key_exists($id_city, static::$_liste)) {
            return static::$_liste[$id_city]['name'];
        }
        return false;
    }

    /**
     * retourne l'id du département
     *
     * @param int $id_city
     * @return string
     */
    protected function _getIdDepartement($id_city)
    {
        if(array_key_exists($id_city, static::$_liste)) {
            return static::$_liste[$id_city]['id_departement'];
        }
        return false;
    }

    /**
     * retourne le code postal
     *
     * @param int $id_city
     * @return string
     */
    protected function _getCp($id_city)
    {
        if(array_key_exists($id_city, static::$_liste)) {
            return static::$_liste[$id_city]['cp'];
        }
        return false;
    }

    /**
     * @return bool
     */
    protected function _loadFromDb()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_city`, `cp`, `id_departement`, `name` "
             . "FROM `geo_fr_city` "
             . "ORDER BY `id_departement` ASC, `name` ASC";

        static::$_liste = array();
        if($rows = $db->queryWithFetch($sql)) {
            foreach($rows as $row) {
                static::$_liste[$row['id_city']] = $row;
            }
            return true;
        }
        return false;
    }
}
