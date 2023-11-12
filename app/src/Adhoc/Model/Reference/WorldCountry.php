<?php

declare(strict_types=1);

namespace Adhoc\Model\Reference;

use Adhoc\Model\Reference;
use Adhoc\Utils\DataBase;
use Adhoc\Utils\ObjectModel;

/**
 * Classe WorldCountry
 *
 * @template TObjectModel as WorldCountry
 * @extends Reference<TObjectModel>
 *
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 *
 * @see http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2
 */
class WorldCountry extends Reference
{
    /**
     * Instance de l'objet
     *
     * @var ?TObjectModel
     */
    protected static ?ObjectModel $instance = null;

    /**
     * @var string|array<string>
     */
    protected static string|array $pk = 'id_country';

    /**
     * @var string
     */
    protected static string $table = 'geo_world_country';

    /**
     * @var ?string
     */
    protected ?string $id_country = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_country' => 'string',
        'name'       => 'string',
    ];

    /* début getters */

    /**
     * @return string
     */
    public function getIdCountry(): string
    {
        return $this->id_country;
    }

    /**
     * Retourne l'url de l'image du drapeau pays
     *
     * @return string
     */
    public function getFlagUrl(): string
    {
        return MEDIA_URL . '/country/' . strtolower($this->id_country) . '.png';
    }

    /* fin getters */

    /* début setters */

    /* fin setters */

    /**
     * Retourne une collection d'objets "WorldCountry" répondant au(x) critère(s)
     *
     * @param array<string,mixed> $params [
     *                      'order_by' => string,
     *                      'sort' => string
     *                      'start' => int,
     *                      'limit' => int,
     *                      ]
     *
     * @return array<TObjectModel>
     */
    public static function find(array $params): array
    {
        $db = DataBase::getInstance();
        $objs = [];

        $sql = "SELECT `" . static::getDbPk() . "` FROM `" . static::getDbTable() . "` WHERE 1 ";

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
