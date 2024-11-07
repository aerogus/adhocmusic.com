<?php

declare(strict_types=1);

namespace Adhoc\Model\Reference;

use Adhoc\Model\Reference;
use Adhoc\Utils\DataBase;

/**
 * Classe Departement
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class Departement extends Reference
{
    /**
     * @var array<string>
     */
    protected static array $pk = [
        'id_departement',
    ];

    /**
     * @var string
     */
    protected static string $table = 'geo_fr_departement';

    /**
     * @var ?string
     */
    protected ?string $id_departement = null;

    /**
     * @var ?string
     */
    protected ?string $id_region = null;

    /**
     * @var ?WorldRegion
     */
    protected ?WorldRegion $region = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_departement' => 'string', // pk
        'id_region' => 'string',
        'name' => 'string',
    ];

    /* début getters */

    /**
     * @return ?string
     */
    public function getIdDepartement(): ?string
    {
        return $this->id_departement;
    }

    /**
     * @return ?string
     */
    public function getIdRegion(): ?string
    {
        return $this->id_region;
    }

    /**
     * @return ?WorldRegion
     */
    public function getRegion(): ?WorldRegion
    {
        if (is_null($this->getIdRegion())) {
            return null;
        }

        if (is_null($this->region)) {
            $this->region = WorldRegion::getInstance([
                'id_country' => 'FR',
                'id_region' => $this->getIdRegion(),
            ]);
        }

        return $this->region;
    }

    /* fin getters */

    /* début setters */

    // à implémenter

    /* fin setters */

    /**
     * Retourne une collection d'objets "Departement" répondant au(x) critère(s)
     *
     * @param array<string,mixed> $params [
     *                                        'id_region' => string,
     *                                        'order_by' => string,
     *                                        'sort' => string
     *                                        'start' => int,
     *                                        'limit' => int,
     *                                    ]
     *
     * @return array<static>
     */
    public static function find(array $params): array
    {
        $db = DataBase::getInstance();
        $objs = [];


        $sql = 'SELECT ';

        $pks = array_map(
            function ($item) {
                return '`' . $item . '`';
            },
            static::getDbPk()
        );
        $sql .= implode(', ', $pks) . ' ';

        $sql .= 'FROM `' . static::getDbTable() . '` ';
        $sql .= 'WHERE 1 ';

        if (isset($params['id_region'])) {
            $sql .= "AND `id_region` = '" . $params['id_region'] . "' ";
        }

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$all_fields), true)))) {
            $sql .= "ORDER BY `" . $params['order_by'] . "` ";
        } else {
            $sql .= "ORDER BY `" . static::getDbPk()[0] . "` ";
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

        $ids = $db->pdo->query($sql)->fetchAll(\PDO::FETCH_COLUMN);
        foreach ($ids as $id) {
            $objs[] = static::getInstance($id);
        }

        return $objs;
    }
}
