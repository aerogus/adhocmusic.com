<?php

/**
 * @package adhoc
 */

/**
 * Classe WorldRegion
 *
 * @package adhoc
 * @author Guillaume Seznec <guillaume.seznec@gmail.com>
 */
class WorldRegion extends Liste
{
    /**
     * instance de l'objet
     *
     * @var mixed
     */
    protected static $_instance = null;

    /**
     * Code pays ok ?
     *
     * @param string $id_country
     * @param string $id_region
     * @return bool
     */
    function isWorldRegionOk($id_country, $id_region)
    {
        $o = static::getInstance();
        return $o->_isWorldRegionOk($id_country, $id_region);
    }

    /**
     * retourne le nom d'une région
     *
     * @param string $id_country
     * @param string $id_region
     * @return string
     */
    static function getName($id_country, $id_region)
    {
        $o = static::getInstance();
        return $o->_getName($id_country, $id_region);
    }

    /**
     * Code pays ok ?
     *
     * @param string $id_country
     * @param string $id_region
     * @return bool
     */
    protected function _isWorldRegionOk($id_country, $id_region)
    {
        if(array_key_exists($id_country, static::$_liste)) {
            if(array_key_exists($id_region, static::$_liste[$id_country])) {
                return true;
            }
        }
        return false;
    }

    /**
     * retourne le nom d'une région
     *
     * @param string $id_country
     * @param string $id_region
     * @return string
     */
    protected function _getName($id_country, $id_region)
    {
        if(array_key_exists($id_country, static::$_liste)) {
            if(array_key_exists($id_region, static::$_liste[$id_country])) {
                return static::$_liste[$id_country][$id_region];
            }
        }
        return false;
    }

    /**
     * Charge la liste des régions triés par pays
     *
     * @return bool
     */
    protected function _loadFromDb()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_country`, `id_region`, `name` "
             . "FROM `geo_world_region` "
             . "ORDER BY `id_country` ASC, `id_region` ASC";

        static::$_liste = array();
        if($res = $db->queryWithFetch($sql)) {
            foreach($res as $_res) {
                static::$_liste[$_res['id_country']][$_res['id_region']] = $_res['name'];
            }
            return true;
        }
        return false;

    }
}
