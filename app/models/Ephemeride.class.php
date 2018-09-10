<?php

/**
 * L'éphéméride extrait les groupes qui ont jour à Épinay durant toute
 * l'histoire de l'association
 */
class Ephemeride extends ObjectModel
{
    /**
     * @var mixed
     */
    protected static $_instance = null;

    /**
     * @var array
     */
    protected $_data;

    /**
     * Retourne toutes les données
     *
     * @return array
     */
    function getAll()
    {
        return $this->_data;
    }

    /**
     * Retourne les données pour un jour donné
     *
     * @param string date MM-DD
     * @return array ou false
     */
    function getDate($date)
    {
        if (strlen($date) !== 5) return;
        if (!array_key_exists($date, $this->_data)) return;
        return $this->_data[$date];
    }

    /**
     * @return array
     */
    protected function _loadFromDb()
    {
        $db = DataBase::getInstance();

        $sql = "
        SELECT g.name, e.`date`, YEAR(e.`date`) AS `year`, DATE_FORMAT(e.`date`, '%m-%d') AS `day`
        FROM adhoc_groupe g, adhoc_participe_a pa, adhoc_event e, adhoc_organise_par o, adhoc_structure s
        WHERE g.id_groupe = pa.id_groupe
        AND pa.id_event = e.id_event
        AND e.id_event = o.id_event
        AND o.id_structure = s.id_structure
        AND s.id_structure = 1
        ORDER BY MONTH(e.`date`) ASC, DAY(e.`date`) ASC, e.`date` ASC
        ";

        $rows = $db->queryWithFetch($sql);

        $eph = [];
        foreach ($rows as $row) {
            if (!array_key_exists($row['day'], $eph)) {
                $eph[$row['day']] = [];
            }
            if (!array_key_exists($row['year'], $eph[$row['day']])) {
                $eph[$row['day']][$row['year']] = [];
            }
            array_push($eph[$row['day']][$row['year']], $row['name']);
        }

        $this->_data = $eph;

        return $eph;
    }
}
