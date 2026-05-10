#!/usr/bin/env php
<?php

/**
 * Liste des villes
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */

declare(strict_types=1);

use Adhoc\Model\City;
use cli\Table;

require_once __DIR__ . '/../bootstrap.php';

$cs = City::find([
    'id_departement' => 91,
]);


$headers = [
    'id_city',
    'cp',
    'name',
    'id_departement',
    'name',
    'id_region',
    'name',
    'id_country',
    'name',
];



$data = [];

foreach ($cs as $c) {
    $data[] = [
        $c->getIdCity(),
        $c->getCp(),
        $c->getName(),
        $c->getDepartement()->getIdDepartement(),
        $c->getDepartement()->getName(),
        $c->getDepartement()->getRegion()->getIdRegion(),
        $c->getDepartement()->getRegion()->getName(),
        $c->getDepartement()->getRegion()->getCountry()->getIdCountry(),
        $c->getDepartement()->getRegion()->getCountry()->getName(),
    ];
}

$table = new Table();
$table->setHeaders($headers);
$table->setRows($data);
$table->display();