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
    protected static $_table = 'geo_world_region';

    /**
     * @var string
     */
    protected $_id_country = null;

    /**
     * @var string
     */
    protected $_id_region = null;

    /**
     * @var string
     */
    protected $_name = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array
     */
    protected static $_all_fields = [
        'id_country' => 'string', // pk
        'id_region'  => 'string', // pk
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

    /**
     * @return string
     */
    function getIdRegion(): string
    {
        return $this->_id_region;
    }

    /* fin getters */

    /* début setters */

    /* fin setters */

    /**
     * Retourne une collection d'instances
     *
     * @param string $id_country id_country
     *
     * @return array
     * @throws Exception
     */
    static function findByCountry(string $id_country): array
    {
        $db = DataBase::getInstance();
        $objs = [];

        $sql = "SELECT `" . implode('`,`', static::getDbPk()) . "` "
             . "FROM `" . static::getDbTable() . "` "
             . "WHERE `id_country` = '" . $id_country . "'";

        $rows = $db->queryWithFetch($sql);
        foreach ($rows as $row) {
            $objs[] = static::getInstance($row);
        }

        return $objs;
    }

    /**
     * Charge toutes les infos d'une entité
     *
     * @return bool
     * @throws Exception
     */
    protected function _loadFromDb(): bool
    {
        $db = DataBase::getInstance();

        $sql = "SELECT * FROM `" . static::$_table . "` WHERE 1";
        foreach (static::$_pk as $fieldName) {
            $propName = '_' . $fieldName;
            $sql .= " AND `${fieldName}` = '" . $this->$propName . "'";
        }

        if ($res = $db->queryWithFetchFirstRow($sql)) {
            $this->_arrayToObject($res);
            return true;
        }
        throw new Exception('WorldRegion introuvable');
    }
}
