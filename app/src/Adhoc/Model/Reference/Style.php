<?php

declare(strict_types=1);

namespace Reference;

use DataBase;
use Reference;

/**
 * Classe de gestion des styles musicaux
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Style extends Reference
{
    /**
     * Instance de l'objet
     *
     * @var object
     */
    protected static $instance = null;

    /**
     * @var string|array<string>
     */
    protected static string|array $pk = 'id_style';

    /**
     * @var string
     */
    protected static string $table = 'adhoc_style';

    /**
     * @var int
     */
    protected int $id_style = 0;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_style' => 'int', // pk
        'name'     => 'string',
    ];

    /**
     * Retourne une collection d'objets "Style" répondant au(x) critère(s) donné(s)
     *
     * @param array<string,mixed> $params [
     *     'id_event' => int,
     *     'order_by' => string,
     *     'sort' => string,
     *     'start' => int,
     *     'limit' => int,
     * ]
     *
     * @return array<Style>
     */
    public static function find(array $params): array
    {
        $db = DataBase::getInstance();
        $objs = [];

        $sql = "SELECT `" . static::getDbPk() . "` FROM `" . static::getDbTable() . "` WHERE 1 ";

        if (isset($params['id_event'])) {
            $subSql = "SELECT `id_style` FROM `adhoc_event_style` WHERE `id_event` = " . (int) $params['id_event'] . " ";
            if ($ids_style = $db->queryWithFetchFirstFields($subSql)) {
                $sql .= "AND `id_style` IN (" . implode(',', (array) $ids_style) . ") ";
            } else {
                return $objs;
            }
        }

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$all_fields))))) {
            $sql .= "ORDER BY `" . $params['order_by'] . "` ";
        } else {
            $sql .= "ORDER BY `" . static::getDbPk() . "` ";
        }

        if ((isset($params['sort']) && (in_array($params['sort'], ['ASC', 'DESC'])))) {
            $sql .= $params['sort'];
        } else {
            $sql .= "ASC";
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
