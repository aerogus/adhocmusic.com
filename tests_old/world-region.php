#!/usr/bin/env php
<?php

/**
 * Liste des régions du monde
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */

declare(strict_types=1);

use Adhoc\Model\WorldRegion;
use cli\Table;

require_once __DIR__ . '/../bootstrap.php';

$wrs = WorldRegion::find([
    'order_by' => 'id_country',
    'sort' => 'ASC',
]);

$headers = [
    'id_country',
    'id_region',
    'world_country.name',
    'world_region.name',
];

$data = [];
foreach ($wrs as $wr) {
    $data[] = [
        $wr->getIdCountry(),
        $wr->getIdRegion(),
        $wr->getCountry()->getName(),
        $wr->getName(),
    ];
}

$table = new Table();
$table->setHeaders($headers);
$table->setRows($data);
$table->display();