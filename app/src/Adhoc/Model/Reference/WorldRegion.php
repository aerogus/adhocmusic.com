<?php

declare(strict_types=1);

namespace Adhoc\Model\Reference;

use Adhoc\Model\Reference;
use Adhoc\Utils\DataBase;

/**
 * Classe WorldRegion
 *
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class WorldRegion extends Reference
{
    /**
     * @var string|array<string>
     */
    protected static string|array $pk = ['id_country', 'id_region'];

    /**
     * @var string
     */
    protected static string $table = 'geo_world_region';

    /**
     * @var ?string
     */
    protected ?string $id_country = null;

    /**
     * @var ?string
     */
    protected ?string $id_region = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_country' => 'string', // pk
        'id_region'  => 'string', // pk
        'name'       => 'string',
    ];

    /* début getters */

    /**
     * @return ?string
     */
    public function getIdCountry(): ?string
    {
        return $this->id_country;
    }

    /**
     * @return ?string
     */
    public function getIdRegion(): ?string
    {
        return $this->id_region;
    }

    /* fin getters */

    /* début setters */

    /* fin setters */

    /**
     * Retourne une collection d'objets "WorldRegion" répondant au(x) critère(s)
     *
     * @param array<string,mixed> $params [
     *                                'id_country' => string,
     *                                'order_by' => string,
     *                                'sort' => string
     *                                'start' => int,
     *                                'limit' => int,
     *                            ]
     *
     * @return array<static>
     */
    public static function find(array $params): array
    {
        $db = DataBase::getInstance();
        $objs = [];

        $sql  = "SELECT `" . implode('`,`', static::getDbPk()) . "` ";
        $sql .= "FROM `" . static::getDbTable() . "` ";
        $sql .= "WHERE 1 ";

        if (isset($params['id_country'])) {
            $sql .= "AND `id_country` = '" . $params['id_country'] . "' ";
        }

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$all_fields), true)))) {
            $sql .= "ORDER BY `" . $params['order_by'] . "` ";
        } else {
            $sql .= "ORDER BY `" . static::$pk[1] . "` "; // tri par région
        }

        if ((isset($params['sort']) && (in_array($params['sort'], ['ASC', 'DESC'], true)))) {
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

        $ids = $db->pdo->query($sql)->fetchAll();
        foreach ($ids as $id) {
            $objs[] = static::getInstance((string) $id);
        }

        return $objs;
    }
}
