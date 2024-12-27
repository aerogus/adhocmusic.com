<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Utils\DataBase;
use Adhoc\Utils\ObjectModel;

/**
 * Classe de gestion des styles musicaux
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class Style extends ObjectModel
{
    /**
     * @var array<string>
     */
    protected static array $pk = [
        'id_style',
    ];

    /**
     * @var string
     */
    protected static string $table = 'adhoc_style';

    /**
     * @var ?int
     */
    protected ?int $id_style = null;

    /**
     * @var ?string
     */
    protected ?string $name = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_style' => 'int', // pk
        'name' => 'string',
    ];

    /**
     * @return ?int
     */
    public function getIdStyle(): ?int
    {
        return $this->id_style;
    }

    /**
     * @return ?string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param int $id_style
     *
     * @return static
     */
    public function setIdStyle(int $id_style): static
    {
        if ($this->id_style !== $id_style) {
            $this->id_style = $id_style;
            $this->modified_fields['id_style'] = true;
        }

        return $this;
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
     * @return array<static>
     */
    public static function find(array $params): array
    {
        $db = DataBase::getInstance();
        $objs = [];

        $sql  = "SELECT ";

        $pks = array_map(
            function ($item) {
                return '`' . $item . '`';
            },
            static::getDbPk()
        );
        $sql .= implode(', ', $pks) . ' ';

        $sql .= "FROM `" . static::getDbTable() . "` ";
        $sql .= "WHERE 1 ";

        if (isset($params['id_event'])) {
            $subSql  = "SELECT `id_style` ";
            $subSql .= "FROM `adhoc_event_style` ";
            $subSql .= "WHERE `id_event` = " . (int) $params['id_event'] . " ";
            if ($ids_style = $db->pdo->query($subSql)->fetchAll(\PDO::FETCH_COLUMN)) {
                $sql .= "AND `id_style` IN (" . implode(',', $ids_style) . ") ";
            } else {
                return $objs;
            }
        }

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$all_fields), true)))) {
            $sql .= "ORDER BY `" . $params['order_by'] . "` ";
        } else {
            $pks = array_map(function ($item) {
                return '`' . $item . '`';
            }, static::getDbPk());
            $sql .= 'ORDER BY ' . implode(', ', $pks) . ' ';
        }

        if ((isset($params['sort']) && (in_array($params['sort'], ['ASC', 'DESC'], true)))) {
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

        $ids = $db->pdo->query($sql)->fetchAll(\PDO::FETCH_COLUMN);
        foreach ($ids as $id) {
            $objs[] = static::getInstance((int) $id);
        }

        return $objs;
    }
}
