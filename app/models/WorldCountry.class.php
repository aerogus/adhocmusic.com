<?php declare(strict_types=1);

/**
 * Classe WorldCountry
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 *
 * @see http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2
 */
class WorldCountry extends Liste
{
    /**
     * Instance de l'objet
     *
     * @var mixed
     */
    protected static $_instance = null;

    /**
     * Retourne le libellé d'un pays, en français ou anglais
     *
     * @param string $id_country code pays
     * @param string $locale     locale
     *
     * @return string
     */
    static function getName(string $id_country, string $locale = 'fr_FR'): string
    {
        $o = static::getInstance();
        return $o->_getName($id_country, $locale);
    }

    /**
     * Le code pays est-il ok ?
     *
     * @param string $id_country code pays
     *
     * @return bool
     */
    static function isWorldCountryOk(string $id_country): bool
    {
        $o = static::getInstance();
        return $o->_isWorldCountryOk($id_country);
    }

    /**
     * Retourne le nom du pays dans la locale demandée
     *
     * @param string $id_country code pays
     * @param string $locale     locale
     *
     * @return string
     */
    protected function _getName(string $id_country, string $locale = 'fr_FR'): string
    {
        $lang = 'en';
        if (strpos($locale, 'fr') !== false) {
            $lang = 'fr';
        }
        return static::$_liste[$id_country][$lang];
    }

    /**
     * Retourne si le code pays est ok
     *
     * @param string $id_country code pays
     *
     * @return bool
     */
    protected function _isWorldCountryOk(string $id_country): bool
    {
        if (array_key_exists($id_country, static::$_liste)) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    protected function _loadFromDb(): bool
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
