<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Utils\DataBase;
use Adhoc\Utils\ObjectModel;

/**
 * Classe WorldRegion
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class WorldRegion extends ObjectModel
{
    /**
     * @var array<string>
     */
    protected static array $pk = [
        'id_country',
        'id_region',
    ];

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
     * @var ?string
     */
    protected ?string $name = null;

    /**
     * @var ?WorldCountry
     */
    protected ?WorldCountry $country = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_country' => 'string', // pk
        'id_region' => 'string', // pk
        'name' => 'string',
    ];

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

    /**
     * @return ?WorldCountry
     */
    public function getCountry(): ?WorldCountry
    {
        if (is_null($this->getIdCountry())) {
            return null;
        }

        if (is_null($this->country)) {
            $this->country = WorldCountry::getInstance($this->getIdCountry());
        }

        return $this->country;
    }

    /**
     * @return ?string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param ?string $name nom
     *
     * @return static
     */
    public function setName(?string $name): static
    {
        if ($this->name !== $name) {
            $this->name = $name;
            $this->modified_fields['name'] = true;
        }

        return $this;
    }

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

        if (isset($params['id_country'])) {
            $sql .= "AND `id_country` = '" . $params['id_country'] . "' ";
        }

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$all_fields), true)))) {
            $sql .= "ORDER BY `" . $params['order_by'] . "` ";
        } else {
            $pks = array_map(function ($item) {
                return '`' . $item . '`';
            }, static::getDbPk());
            $sql .= 'ORDER BY ' . implode(', ', $pks) . ' '; // tri par région
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
            $objs[] = static::getInstance((array) $id);
        }

        return $objs;
    }
}
