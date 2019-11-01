<?php declare(strict_types=1);

/**
 * Classe WorldRegion
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class WorldRegion extends Reference
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
    protected static $_pk = ['id_country', 'id_region'];

    /**
     * @var string
     */
    protected static $_table = 'geo_world_country';

    /**
     * @var string
     */
    protected $_id_country = null;

    /**
     * @var string
     */
    protected $_id_region = null;

    /**
     * Charge toutes les infos d'une entité
     *
     * @return bool
     * @throws Exception
     */
    protected function _loadFromDb(): bool
    {
        $db = DataBase::getInstance();

        $sql  = "SELECT * FROM `" . static::$_table . "` WHERE `" . static::$_pk . "` = " . (int) $this->{'_' . static::$_pk};

        if ($res = $db->queryWithFetchFirstRow($sql)) {
            $this->_dbToObject($res);
            return true;
        }
        return false;
    }
}
