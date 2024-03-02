#!/usr/bin/env php
<?php

declare(strict_types=1);

use Adhoc\Model\Reference\WorldCountry;
use Adhoc\Utils\LogNG;

require_once __DIR__ . '/../app/bootstrap.php';

$wcs = WorldCountry::findAll();

$tbl = new \Console_Table();
$tbl->setHeaders(
    ['id_country', 'name']
);

foreach ($wcs as $wc) {
    $row = [];
    $row[] = $wc->getIdCountry();
    $row[] = $wc->getName();
    $tbl->addRow($row);
}

echo $tbl->getTable();
