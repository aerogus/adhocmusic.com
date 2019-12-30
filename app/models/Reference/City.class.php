<?php declare(strict_types=1);

namespace Reference;

use \DataBase;

/**
 * Classe City
 * (villes de France uniquement)
 * pk = code insee
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class City extends \Reference
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
    protected static $_pk = 'id_city';

    /**
     * @var string
     */
    protected static $_table = 'geo_fr_city';

    /**
     * @var int
     */
    protected $_id_city = null;

    /**
     * @var string
     */
    protected $_id_departement = null;

    /**
     * @var string
     */
    protected $_cp = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array
     */
    protected static $_all_fields = [
        'id_city'        => 'int', // pk
        'id_departement' => 'string',
        'cp'             => 'string',
        'name'           => 'string',
    ];

    /* début getter */

    /**
     * @return string|null
     */
    function getIdCity(): ?string
    {
        return $this->_id_city;
    }

    /**
     * @return string|null
     */
    function getIdDepartement(): ?string
    {
        return $this->_id_department;
    }

    /**
     * @return string|null
     */
    function getCp(): ?string
    {
        return $this->_cp;
    }

    /* fin getters */

    /* début setters */

    // à implémenter

    /* fin setters */

    /**
     * Retourne une collection d'objets "City" répondant au(x) critère(s)
     *
     * @param array $params [
     *                      'id_departement' => string,
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

        $sql = "SELECT `" . static::getDbPk() . "` FROM `" . static::getDbTable() . "` WHERE 1 ";

        if (isset($params['id_departement'])) {
            $sql .= "AND `id_departement` = '" . $db->escape($params['id_departement']) . "' ";
        }

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$_all_fields))))) {
            $sql .= "ORDER BY `" . $params['order_by'] . "` ";
        } else {
            $sql .= "ORDER BY `" . static::$_pk . "` ";
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

        $ids = $db->queryWithFetchFirstFields($sql);
        foreach ($ids as $id) {
            $objs[] = static::getInstance((int) $id);
        }

        return $objs;
    }
}
