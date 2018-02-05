#!/usr/bin/env php
<?php

require_once dirname(__FILE__) . '/../config.php';

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
foreach($rows as $row) {
  if (!array_key_exists($row['day'], $eph)) {
    $eph[$row['day']] = [];
  }
  if (!array_key_exists($row['year'], $eph[$row['day']])) {
    $eph[$row['day']][$row['year']] = [];
  }
  array_push($eph[$row['day']][$row['year']], $row['name']);
}

foreach ($eph as $day => $data) {
  echo DateTime::createFromFormat('m-d', $day)->format('F dS') . "\n";
  foreach ($data as $year => $groupes) {
    echo "- " . $year . ": " . implode($groupes, " + ") . "\n";
  }
}

