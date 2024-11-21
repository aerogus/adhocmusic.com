#!/usr/bin/env php
<?php

declare(strict_types=1);

use Adhoc\Model\WorldRegion;
use Adhoc\Utils\LogNG;

require_once __DIR__ . '/../app/bootstrap.php';

$wrs = WorldRegion::find([
    'order_by' => 'id_country',
    'sort' => 'ASC',
]);

$tbl = new \Console_Table();
$tbl->setHeaders(
    ['id_country', 'id_region', 'world_country.name',  'world_region.name']
);

foreach ($wrs as $wr) {
    $row = [];
    $row[] = $wr->getIdCountry();
    $row[] = $wr->getIdRegion();
    $row[] = $wr->getCountry()->getName();
    $row[] = $wr->getName();
    $tbl->addRow($row);
}

echo $tbl->getTable();
