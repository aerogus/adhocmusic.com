<?php

declare(strict_types=1);

namespace Adhoc\Model\Reference;

use Adhoc\Model\Reference;
use Adhoc\Utils\DataBase;

/**
 * Classe City
 * (villes de France uniquement)
 * pk = code insee
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class City extends Reference
{
    /**
     * @var string|array<string>
     */
    protected static string|array $pk = 'id_city';

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
     * @return ?int
     */
    public function getIdCity(): ?int
    {
        return $this->id_city;
    }

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
     * @param array<string,mixed> $params [
     *                                'id_departement' => string,
     *                                'order_by' => string,
     *                                'sort' => string
     *                                'start' => int,
     *                                'limit' => int,
     *                            ]
     *
     * @return array<static>
     */
    public static function find(array $params = []): array
    {
        $db = DataBase::getInstance();
        $data = [];
        $objs = [];

        $sql  = "SELECT `" . static::getDbPk() . "` ";
        $sql .= "FROM `" . static::getDbTable() . "` ";
        $sql .= "WHERE 1 ";

        if (isset($params['id_departement'])) {
            $sql .= "AND `id_departement` = :id_departement ";
            $data['id_departement'] = $params['id_departement'];
        }

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$all_fields), true)))) {
            $sql .= "ORDER BY `" . $params['order_by'] . "` ";
        } else {
            $sql .= "ORDER BY `" . static::$pk . "` ";
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

        $stmt = $db->pdo->prepare($sql);
        $stmt->execute($data);
        $ids = $stmt->fetchAll(\PDO::FETCH_COLUMN);

        foreach ($ids as $id) {
            $objs[] = static::getInstance((int) $id);
        }

        return $objs;
    }
}
