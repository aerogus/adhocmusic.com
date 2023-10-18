<?php declare(strict_types=1);

namespace Reference;

use DataBase;
use Reference;

/**
 * Classe Departement
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Departement extends Reference
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
    protected static string $_pk = 'id_departement';

    /**
     * @var string
     */
    protected static string $_table = 'geo_fr_departement';

    /**
     * @var ?string
     */
    protected ?string $_id_departement = null;

    /**
     * @var ?string
     */
    protected ?string $_id_region = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static $_all_fields = [
        'id_departement' => 'string', // pk
        'id_region'      => 'string',
        'name'           => 'string',
    ];

    /* début getters */

    /**
     * @return string|null
     */
    public function getIdDepartement(): ?string
    {
        return $this->_id_departement;
    }

    /**
     * @return string|null
     */
    public function getIdRegion(): ?string
    {
        return $this->_id_region;
    }

    /* fin getters */

    /* début setters */

    // à implémenter

    /* fin setters */

    /**
     * Retourne une collection d'objets "Departement" répondant au(x) critère(s)
     *
     * @param array $params [
     *                      'id_region' => string,
     *                      'order_by' => string,
     *                      'sort' => string
     *                      'start' => int,
     *                      'limit' => int,
     *                      ]
     *
     * @return array<Departement>
     */
    public static function find(array $params): array
    {
        $db = DataBase::getInstance();
        $objs = [];

        $sql = "SELECT `" . static::getDbPk() . "` FROM `" . static::getDbTable() . "` WHERE 1 ";

        if (isset($params['id_region'])) {
            $sql .= "AND `id_region` = '" . $db->escape($params['id_region']) . "' ";
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

        if (isset($params['limit'])) {
            $sql .= "LIMIT " . (int) $params['start'] . ", " . (int) $params['limit'];
        }

        $ids = $db->queryWithFetchFirstFields($sql);
        foreach ($ids as $id) {
            $objs[] = static::getInstance($id);
        }

        return $objs;
    }
}
