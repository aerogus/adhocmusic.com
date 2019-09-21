#!/usr/bin/env php
<?php declare(strict_types=1);

// outil cli pour afficher/cache un groupe
// usage: ./grp.php aliasgroupe 0|1

require_once __DIR__ . '/../bootstrap.php';

$alias = $argv[1];
$online = (bool) $argv[2];

// groupes n'ayant jamais joué à Épinay

$sql = "SELECT adhoc_groupe.id_groupe, adhoc_groupe.alias FROM adhoc_groupe WHERE online = 1 AND id_groupe NOT IN (";
$sql .= "SELECT DISTINCT(adhoc_groupe.id_groupe)
        FROM adhoc_groupe, adhoc_participe_a, adhoc_event, adhoc_lieu
        WHERE adhoc_groupe.id_groupe = adhoc_participe_a.id_groupe
        AND adhoc_participe_a.id_event = adhoc_event.id_event
        AND adhoc_event.id_lieu = adhoc_lieu.id_lieu
        AND adhoc_lieu.cp = '91360'";
$sql .= ")";

$db = DataBase::getInstance();

if (!$alias) {
    echo "Liste des groupes n'ayant jamais joué à Épinay\n";
    $rows = $db->queryWithFetch($sql);
    foreach ($rows as $idx => $row) {
        echo $idx . ' ' . $row['alias'] . "\n";
    }
    die();
}

$grp = Groupe::getInstance(Groupe::getIdByAlias($alias));

echo $grp->getName();
echo $grp->getOnline();
echo 'online = ' . $online . "\n";
$grp->setOnline($online);
$r = $grp->save();
echo $r;
