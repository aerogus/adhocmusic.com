#!/usr/bin/env php
<?php

/**
 * Liste des pays du monde
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */

declare(strict_types=1);

use Adhoc\Model\WorldCountry;
use cli\Table;

require_once __DIR__ . '/../bootstrap.php';

$wcs = WorldCountry::findAll();

$headers = [
    'id_country',
    'name',
];

$data = [];
foreach ($wcs as $wc) {
    $data[] = [
        $wc->getIdCountry(),
        $wc->getName(),
    ];
}

$table = new Table();
$table->setHeaders($headers);
$table->setRows($data);
$table->display();