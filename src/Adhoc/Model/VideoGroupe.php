<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Utils\DataBase;
use Adhoc\Utils\ObjectModel;

/**
 * Classe VideoGroupe
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class VideoGroupe extends ObjectModel
{
    /**
     * @var array<string>
     */
    protected static array $pk = [
        'id_video',
        'id_groupe',
    ];

    /**
     * @var string
     */
    protected static string $table = 'adhoc_video_groupe';

    /**
     * Identifiant vidéo
     *
     * @var ?int
     */
    protected ?int $id_video = null;

    /**
     * Identifiant groupe
     *
     * @var ?int
     */
    protected ?int $id_groupe = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_video' => 'int', // pk
        'id_groupe' => 'int', // pk
    ];

    /**
     * @return ?int
     */
    public function getIdVideo(): ?int
    {
        return $this->id_video;
    }

    /**
     * @return ?int
     */
    public function getIdGroupe(): ?int
    {
        return $this->id_groupe;
    }

    /**
     * @param int $id_video
     *
     * @return static
     */
    public function setIdVideo(int $id_video): static
    {
        if ($this->id_video !== $id_video) {
            $this->id_video = $id_video;
            $this->modified_fields['id_video'] = true;
        }

        return $this;
    }

    /**
     * @param int $id_groupe
     *
     * @return static
     */
    public function setIdGroupe(int $id_groupe): static
    {
        if ($this->id_groupe !== $id_groupe) {
            $this->id_groupe = $id_groupe;
            $this->modified_fields['id_groupe'] = true;
        }

        return $this;
    }

    /**
     * Retourne une collection d'objets "VideoGroupe" répondant au(x) critère(s) donné(s)
     *
     * @TODO utiliser les placeholders PDO
     *
     * @param array<string,mixed> $params [
     *                      'id_video' => int,
     *                      'id_groupe' => int,
     *                      'order_by' => string,
     *                      'sort' => string,
     *                      'start' => int,
     *                      'limit' => int,
     *                      ]
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

        if (isset($params['id_video'])) {
            $sql .= 'AND `id_video` = ' . (int) $params['id_video'] . ' ';
        }

        if (isset($params['id_groupe'])) {
            $sql .= 'AND `id_groupe` = ' . (int) $params['id_groupe'] . ' ';
        }

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$all_fields), true)))) {
            $sql .= 'ORDER BY `' . $params['order_by'] . '` ';
        } else {
            $pks = array_map(function ($item) {
                return '`' . $item . '`';
            }, static::getDbPk());
            $sql .= 'ORDER BY ' . implode(', ', $pks) . ' ';
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
            $pks = [];
            foreach (static::getDbPk() as $pk) {
                $pks[$pk] = $row[$pk];
            }
            $objs[] = static::getInstance($pks);
        }

        return $objs;
    }
}
