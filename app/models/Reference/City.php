<?php

declare(strict_types=1);

namespace Reference;

use DataBase;
use Reference;

/**
 * Classe City
 * (villes de France uniquement)
 * pk = code insee
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class City extends Reference
{
    /**
     * Instance de l'objet
     *
     * @var object
     */
    protected static $instance = null;

    /**
     * @var string
     */
    protected static string $pk = 'id_city';

    /**
     * @var string
     */
    protected static string $table = 'geo_fr_city';

    /**
     * @var ?int
     */
    protected ?int $id_city = null;

    /**
     * @var ?string
     */
    protected ?string $id_departement = null;

    /**
     * @var ?string
     */
    protected ?string $cp = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_city'        => 'int', // pk
        'id_departement' => 'string',
        'cp'             => 'string',
        'name'           => 'string',
    ];

    /* début getter */

    /**
     * @return string|null
     */
    public function getIdCity(): ?string
    {
        return $this->city;
    }

    /**
     * @return string|null
     */
    public function getIdDepartement(): ?string
    {
        return $this->departement;
    }

    /**
     * @return string|null
     */
    public function getCp(): ?string
    {
        return $this->cp;
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
     * @return array<City>
     */
    public static function find(array $params): array
    {
        $db = DataBase::getInstance();
        $objs = [];

        $sql = "SELECT `" . static::getDbPk() . "` FROM `" . static::getDbTable() . "` WHERE 1 ";

        if (isset($params['id_departement'])) {
            $sql .= "AND `id_departement` = '" . $db->escape($params['id_departement']) . "' ";
        }

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$all_fields))))) {
            $sql .= "ORDER BY `" . $params['order_by'] . "` ";
        } else {
            $sql .= "ORDER BY `" . static::$pk . "` ";
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
            $objs[] = static::getInstance((int) $id);
        }

        return $objs;
    }
}
