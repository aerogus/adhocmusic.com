<?php declare(strict_types=1);

/**
 * Classe WorldCountry
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 *
 * @see http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2
 */
class WorldCountry extends Reference
{
    /**
     * Instance de l'objet
     *
     * @var mixed
     */
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static $_pk = 'id_country';

    /**
     * @var string
     */
    protected static $_table = 'geo_world_country';

    /**
     * @var string
     */
    protected $_id_country = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array
     */
    protected static $_all_fields = [
        'id_country' => 'string',
        'name'       => 'string',
    ];

    /* début getters */

    /**
     * @return string
     */
    function getIdCountry(): string
    {
        return $this->_id_country;
    }

    /* fin getters */

    /* début setters */

    /* fin setters */

    /**
     * Charge toutes les infos d'une entité
     *
     * @return bool
     * @throws Exception
     */
    protected function _loadFromDb(): bool
    {
        $db = DataBase::getInstance();

        $sql  = "SELECT * FROM `" . static::$_table . "` WHERE `" . static::$_pk . "` = '" . $this->{'_' . static::$_pk} . "'";

        if ($res = $db->queryWithFetchFirstRow($sql)) {
            $this->_arrayToObject($res);
            return true;
        }
        return false;
    }
}
