<?php

/**
 * @package adhoc
 */

/**
 * Classe WorldCountry
 *
 * @see http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2
 * @package adhoc
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class WorldCountry extends Liste
{
    /**
     * instance de l'objet
     *
     * @var mixed
     */
    protected static $_instance = null;

    /**
     * retourne le libellé d'un pays, en français ou anglais
     *
     * @param int $cle
     * @return string
     */
    static function getName($id_country, $locale = 'fr_FR')
    {
        $o = static::getInstance();
        return $o->_getName($id_country, $locale);
    }

    /**
     * @param string $id_country
     * @return bool
     */
    static function isWorldCountryOk($id_country)
    {
        $o = static::getInstance();
        return $o->_isWorldCountryOk($id_country);
    }

    /**
     * @param string
     * @return string
     */
    protected function _getName($id_country, $locale = 'fr_FR')
    {
        $lang = 'en';
        if (strpos($locale, 'fr') !== false) {
            $lang = 'fr';
        }
        return static::$_liste[$id_country][$lang];
    }

    /**
     * @param string
     * @return bool
     */
    protected function _isWorldCountryOk($id_country)
    {
        if (array_key_exists($id_country, static::$_liste)) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    protected function _loadFromDb()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_country`, `name_fr`, `name_en` "
             . "FROM `geo_world_country` "
             . "ORDER BY `name_fr` ASC";

        static::$_liste = [];
        if ($res = $db->queryWithFetch($sql)) {
            foreach ($res as $_res) {
                static::$_liste[$_res['id_country']] = [
                    'fr' => $_res['name_fr'],
                    'en' => $_res['name_en'],
                ];
            }
            return true;
        }
        return false;
    }
}
