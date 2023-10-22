#!/usr/bin/env php
<?php

/**
 * Calcul de l'éphéméride AD'HOC
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

$eph = new Ephemeride();
$res = $eph->getAll();

$grps = [];
$mbrs = [];

foreach ($res as $day => $data) {
    echo DateTime::createFromFormat('m-d', $day)->format('F dS') . "\n";
    foreach ($data as $year => $groupes) {
        $grps = array_merge($grps, $groupes);
        $_groupes = [];
        foreach ($groupes as $groupe) {
            $grp = Groupe::getInstance($groupe);
            $_mbrs = $grp->getMembers();
            foreach ($_mbrs as $mbr) {
                $mbrs[$mbr->getIdContact()][] = $mbr->getFirstName() . ' ' . $mbr->getLastName() . ' (' . $grp->getName() . ' le ' . $year . '-' . $day . ')';
            }
            $_groupes[] = $grp->getName();
        }
        echo "- " . $year . ": " . implode(' + ', $_groupes) . "\n";
    }
}
die;
foreach ($mbrs as $id => $mbr) {
    echo sizeof($mbr) . "x\n";
    foreach ($mbr as $m) {
        echo $m . "\n";
    }
}
die;
var_dump($mbrs);
die;
// stats membres
$stat_mbrs = array_count_values($mbrs);
asort($stat_mbrs);
foreach ($stat_mbrs as $mbr => $count) {
    $m = Membre::getInstance($mbr);
    echo $m->getFirstName() . ' ' . $m->getLastName() . ' ' . $count . "\n";
}

// stats groupes
/*
$stat_grps = array_count_values($grps);
asort($stat_grps);
var_dump($stat_grps);
*/
