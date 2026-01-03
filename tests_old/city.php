#!/usr/bin/env php
<?php

/**
 * Liste des villes
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */

declare(strict_types=1);

use Adhoc\Model\City;

require_once __DIR__ . '/../bootstrap.php';

$cs = City::find([
    'id_departement' => 91,
]);

$tbl = new \Console_Table();
$tbl->setHeaders(
    ['id_city', 'cp', 'name', 'id_departement', 'name', 'id_region', 'name', 'id_country', 'name']
);

foreach ($cs as $c) {
    $row = [];
    $row[] = $c->getIdCity();
    $row[] = $c->getCp();
    $row[] = $c->getName();
    $row[] = $c->getDepartement()->getIdDepartement();
    $row[] = $c->getDepartement()->getName();
    $row[] = $c->getDepartement()->getRegion()->getIdRegion();
    $row[] = $c->getDepartement()->getRegion()->getName();
    $row[] = $c->getDepartement()->getRegion()->getCountry()->getIdCountry();
    $row[] = $c->getDepartement()->getRegion()->getCountry()->getName();
    $tbl->addRow($row);
}

echo $tbl->getTable();
