#!/usr/bin/env php
<?php

/**
 * Liste des pays du monde
 *
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */

declare(strict_types=1);

use Adhoc\Model\WorldCountry;

require_once __DIR__ . '/../bootstrap.php';

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
