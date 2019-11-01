<?php declare(strict_types=1);

/**
 * Classe City
 * (villes de France uniquement)
 * pk = code insee
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class City extends Liste
{
    /**
     * Instance de l'objet
     *
     * @var mixed
     */
    protected static $_instance = null;

    /**
     * @param int $id_city id_city
     *
     * @return string
     */
    static function getName(int $id_city)
    {
        $o = static::getInstance();
        return $o->_getName($id_city);
    }

    /**
     * @param int $id_city id_city
     *
     * @return string
     */
    static function getIdDepartement(int $id_city)
    {
        $o = static::getInstance();
        return $o->_getIdDepartement($id_city);
    }

    /**
     * @param int $id_city id_city
     *
     * @return string
     */
    static function getCp(int $id_city)
    {
        $o = static::getInstance();
        return $o->_getCp($id_city);
    }

    /**
     * Retourne le nom d'une ville
     *
     * @param int $id_city id_city
     *
     * @return string
     */
    protected function _getName(int $id_city)
    {
        if (array_key_exists($id_city, static::$_liste)) {
            return static::$_liste[$id_city]['name'];
        }
        return false;
    }

    /**
     * Retourne l'id du département
     *
     * @param int $id_city id_city
     *
     * @return string
     */
    protected function _getIdDepartement(int $id_city)
    {
        if (array_key_exists($id_city, static::$_liste)) {
            return static::$_liste[$id_city]['id_departement'];
        }
        return false;
    }

    /**
     * Retourne le code postal
     *
     * @param int $id_city id_city
     *
     * @return string
     */
    protected function _getCp(int $id_city)
    {
        if (array_key_exists($id_city, static::$_liste)) {
            return static::$_liste[$id_city]['cp'];
        }
        return false;
    }

    /**
     * @return bool
     */
    protected function _loadFromDb(): bool
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_city`, `cp`, `id_departement`, `name` "
             . "FROM `geo_fr_city` "
             . "ORDER BY `id_departement` ASC, `name` ASC";

        static::$_liste = [];
        if ($rows = $db->queryWithFetch($sql)) {
            foreach ($rows as $row) {
                static::$_liste[$row['id_city']] = $row;
            }
            return true;
        }
        return false;
    }
}
