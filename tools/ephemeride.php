#!/usr/bin/env php
<?php

/**
 * Calcul de l'éphéméride AD'HOC
 *
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */

declare(strict_types=1);

use Adhoc\Model\Ephemeride;
use Adhoc\Model\Groupe;
use Adhoc\Model\Membre;

require_once __DIR__ . '/../bootstrap.php';

$eph = new Ephemeride();
$res = $eph->getAll();

$grps = [];
$mbrs = [];

foreach ($res as $day => $data) {
    echo \DateTime::createFromFormat('m-d', $day)->format('F dS') . "\n";
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
