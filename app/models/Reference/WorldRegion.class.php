<?php declare(strict_types=1);

namespace Reference;

use \DataBase;

/**
 * Classe WorldRegion
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class WorldRegion extends \Reference
{
    /**
     * Instance de l'objet
     *
     * @var object
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
     * Retourne une collection d'objets "WorldRegion" répondant au(x) critère(s)
     *
     * @param array $params [
     *                      'id_country' => string,
     *                      'order_by' => string,
     *                      'sort' => string
     *                      'start' => int,
     *                      'limit' => int,
     *                      ]
     *
     * @return array
     */
    static function find(array $params): array
    {
        $db = DataBase::getInstance();
        $objs = [];

        $sql = "SELECT `" . implode('`,`', static::getDbPk()) . "` FROM `" . static::getDbTable() . "` WHERE 1 ";

        if (isset($params['id_country'])) {
            $sql .= "AND `id_country` = '" . $db->escape($params['id_country']) . "' ";
        }

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$_all_fields))))) {
            $sql .= "ORDER BY `" . $params['order_by'] . "` ";
        } else {
            $sql .= "ORDER BY `" . static::$_pk[1] . "` "; // tri par région
        }

        if ((isset($params['sort']) && (in_array($params['sort'], ['ASC', 'DESC'])))) {
            $sql .= $params['sort'] . " ";
        } else {
            $sql .= "ASC ";
        }

        if (!isset($params['start'])) {
            $params['start'] = 0;
        }

        if (isset($params['start']) && isset($params['limit'])) {
            $sql .= "LIMIT " . (int) $params['start'] . ", " . (int) $params['limit'];
        }

        $ids = $db->queryWithFetch($sql);
        foreach ($ids as $id) {
            $objs[] = static::getInstance($id);
        }

        return $objs;
    }
}
