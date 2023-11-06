<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Utils\ObjectModel;
use Adhoc\Utils\DataBase;

/**
 * Requêtes d'interaction avec les styles de groupes
 *
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class GroupeStyle extends ObjectModel
{
    /**
     * Instance de l'objet
     *
     * @var ?object
     */
    protected static ?object $instance = null;

    /**
     * @var string|array<string>
     */
    protected static string|array $pk = [
        'id_groupe',
        'id_style',
    ];

    /**
     * @var string
     */
    protected static string $table = 'adhoc_groupe_style';

    /**
     * Identifiant groupe
     *
     * @var ?int
     */
    protected ?string $id_groupe = null;

    /**
     * Identifiant style
     *
     * @var ?int
     */
    protected ?int $id_style = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_groupe' => 'int', // pk
        'id_style' => 'int', // pk
    ];

    /**
     * @return ?string
     */
    public function getIdGroupe(): ?string
    {
        return $this->id_groupe;
    }

    /**
     * @return ?int
     */
    public function getIdStyle(): ?int
    {
        return $this->id_style;
    }

    /**
     * @param int $id_groupe
     *
     * @return object
     */
    public function setIdGroupe(int $id_groupe): object
    {
        if ($this->id_groupe !== $id_groupe) {
            $this->id_groupe = $id_groupe;
            $this->modified_fields['id_groupe'] = true;
        }

        return $this;
    }

    /**
     * @param int $id_style
     *
     * @return object
     */
    public function setIdStyle(int $id_style): object
    {
        if ($this->id_style !== $id_style) {
            $this->id_style = $id_style;
            $this->modified_fields['id_style'] = true;
        }

        return $this;
    }

    /**
     * Retourne une collection d'objets "GroupeStyle" répondant au(x) critère(s) donné(s)
     *
     * @TODO utiliser les placeholders PDO
     *
     * @param array<string,mixed> $params [
     *                      'id_groupe' => int,
     *                      'id_style' => int,
     *                      'order_by' => string,
     *                      'sort' => string,
     *                      'start' => int,
     *                      'limit' => int,
     *                      ]
     *
     * @return array<GroupeStyle>
     */
    public static function find(array $params): array
    {
        $db = DataBase::getInstance();
        $objs = [];

        $sql = 'SELECT ';
        if (is_array(static::getDbPk())) {
            $pks = array_map(
                function ($item) {
                    return '`' . $item . '`';
                },
                static::getDbPk()
            );
            $sql .= implode(', ', $pks) . ' ';
        } else {
            $sql .= '`' . static::getDbPk() . '` ';
        }
        $sql .= 'FROM `' . static::getDbTable() . '` ';
        $sql .= 'WHERE 1 ';

        if (isset($params['id_groupe'])) {
            $sql .= 'AND `id_groupe` = ' . (int) $params['id_groupe'] . ' ';
        }

        if (isset($params['id_style'])) {
            $sql .= 'AND `id_style` = ' . (int) $params['id_style'] . ' ';
        }

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$all_fields), true)))) {
            $sql .= 'ORDER BY `' . $params['order_by'] . '` ';
        } else {
            if (is_array(static::getDbPk())) {
                $pks = array_map(function ($item) {
                    return '`' . $item . '`';
                }, static::getDbPk());
                $sql .= 'ORDER BY ' . implode(', ', $pks) . ' ';
            } else {
                $sql .= 'ORDER BY `' . static::getDbPk() . '` ';
            }
        }

        if ((isset($params['sort']) && (in_array($params['sort'], ['ASC', 'DESC'], true)))) {
            $sql .= $params['sort'] . ' ';
        } else {
            // /!\ en cas de pk multiple, le sort n'est que sur la dernière key
            $sql .= 'ASC ';
        }

        if (!isset($params['start'])) {
            $params['start'] = 0;
        }

        if (isset($params['limit'])) {
            $sql .= 'LIMIT ' . (int) $params['start'] . ', ' . (int) $params['limit'];
        }

        $stm = $db->pdo->query($sql);
        $stm->execute();
        $rows = $stm->fetchAll();
        foreach ($rows as $row) {
            if (is_array(static::getDbPk())) {
                $pks = [];
                foreach (static::getDbPk() as $pk) {
                    $pks[$pk] = $row[$pk];
                }
                $objs[] = static::getInstance($pks);
            } else {
                $objs[] = static::getInstance($row[static::getDbPk()]);
            }
        }

        return $objs;
    }
}
