#!/usr/bin/env php
<?php declare(strict_types=1);

/**
 * Calcul de l'éphéméride AD'HOC
 */

require_once __DIR__ . '/../bootstrap.php';

$eph = (new Ephemeride())->getAll();
$res = $eph->getAll();

foreach ($res as $day => $data) {
    echo DateTime::createFromFormat('m-d', $day)->format('F dS') . "\n";
    foreach ($data as $year => $groupes) {
        echo "- " . $year . ": " . implode($groupes, " + ") . "\n";
    }
}
