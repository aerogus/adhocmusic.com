#!/usr/bin/env php
<?php

declare(strict_types=1);

use Adhoc\Model\Departement;
use Adhoc\Utils\LogNG;

require_once __DIR__ . '/../app/bootstrap.php';

$ds = Departement::find([
    'order_by' => 'id_departement',
    'sort' => 'ASC',
]);

$tbl = new \Console_Table();
$tbl->setHeaders(
    ['id_departement', 'name']
);

foreach ($ds as $d) {
    $row = [];
    $row[] = $d->getIdDepartement();
    $row[] = $d->getName();
    $tbl->addRow($row);
}

echo $tbl->getTable();
