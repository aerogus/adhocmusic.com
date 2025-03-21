<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Utils\DataBase;

/**
 * L'éphéméride extrait les groupes qui ont jour à Épinay durant toute
 * l'histoire de l'association
 */
class Ephemeride
{
    /**
     * @var array<string,array<mixed>>
     */
    protected array $data;

    /**
     * Retourne toutes les données
     *
     * @return array<string,array<mixed>>
     */
    public function getAll(): array
    {
        return $this->data;
    }

    /**
     * Retourne les données pour un jour donné
     *
     * @param string $date date format MM-DD
     *
     * @return array<string,mixed>|false
     */
    public function getDate(string $date): array|false
    {
        if (strlen($date) !== 5) {
            return false;
        }
        if (!array_key_exists($date, $this->data)) {
            return false;
        }
        return $this->data[$date];
    }

    /**
     *
     */
    public function __construct()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT g.id_groupe, g.name, e.`date`, YEAR(e.`date`) AS `year`, DATE_FORMAT(e.`date`, '%m-%d') AS `day` "
             . "FROM adhoc_groupe g, adhoc_event_groupe eg, adhoc_event e, adhoc_event_structure o, adhoc_structure s "
             . "WHERE g.id_groupe = eg.id_groupe "
             . "AND eg.id_event = e.id_event "
             . "AND e.id_event = o.id_event "
             . "AND o.id_structure = s.id_structure "
             . "AND s.id_structure = 1 "
             . "AND e.id_lieu = 1 "
             . "ORDER BY MONTH(e.`date`) ASC, DAY(e.`date`) ASC, e.`date` ASC";

        $stmt = $db->pdo->query($sql);
        $rows = $stmt->fetchAll();

        $data = [];
        foreach ($rows as $row) {
            if (!array_key_exists($row['day'], $data)) {
                $data[$row['day']] = [];
            }
            if (!array_key_exists($row['year'], $data[$row['day']])) {
                $data[$row['day']][$row['year']] = [];
            }
            array_push($data[$row['day']][$row['year']], $row['id_groupe']);
        }

        $this->data = $data;
    }
}
