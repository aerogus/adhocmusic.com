<?php declare(strict_types=1);

/**
 * L'éphéméride extrait les groupes qui ont jour à Épinay durant toute
 * l'histoire de l'association
 */
class Ephemeride
{
    /**
     * @var array
     */
    protected array $_data;

    /**
     * Retourne toutes les données
     *
     * @return array
     */
    public function getAll(): array
    {
        return $this->_data;
    }

    /**
     * Retourne les données pour un jour donné
     *
     * @param string $date date format MM-DD
     *
     * @return array ou false
     */
    public function getDate(string $date)
    {
        if (strlen($date) !== 5) {
            return;
        }
        if (!array_key_exists($date, $this->_data)) {
            return;
        }
        return $this->_data[$date];
    }

    /**
     *
     */
    public function __construct()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT g.id_groupe, g.name, e.`date`, YEAR(e.`date`) AS `year`, DATE_FORMAT(e.`date`, '%m-%d') AS `day` "
             . "FROM adhoc_groupe g, adhoc_participe_a pa, adhoc_event e, adhoc_organise_par o, adhoc_structure s "
             . "WHERE g.id_groupe = pa.id_groupe "
             . "AND pa.id_event = e.id_event "
             . "AND e.id_event = o.id_event "
             . "AND o.id_structure = s.id_structure "
             . "AND s.id_structure = 1 "
             . "AND e.id_lieu = 1 "
             . "ORDER BY MONTH(e.`date`) ASC, DAY(e.`date`) ASC, e.`date` ASC";

        $rows = $db->queryWithFetch($sql);

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

        $this->_data = $data;
    }
}
