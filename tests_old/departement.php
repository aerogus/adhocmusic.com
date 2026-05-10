#!/usr/bin/env php
<?php

/**
 * Liste des départements
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */

declare(strict_types=1);

use Adhoc\Model\Departement;
use cli\Table;

require_once __DIR__ . '/../bootstrap.php';

$ds = Departement::find([
    'order_by' => 'id_departement',
    'sort' => 'ASC',
]);

$headers = [
    'id_departement',
    'name',
];

$data = [];
foreach ($ds as $d) {
    $data[] = [
        $d->getIdDepartement(),
        $d->getName(),
    ];
}

$table = new Table();
$table->setHeaders($headers);
$table->setRows($data);
$table->display();