#!/usr/bin/env php
<?php

declare(strict_types=1);

use Adhoc\Model\Membre;
use Adhoc\Utils\LogNG;

require_once __DIR__ . '/../app/bootstrap.php';

$ms = Membre::find([
    'mailing' => true,
]);

$tbl = new \Console_Table();
$tbl->setHeaders(
    ['id_contact', 'pseudo', 'email', 'first_name', 'last_name', 'mailing',]
);

foreach ($ms as $m) {
    $row = [];
    $row[] = $m->getIdContact();
    $row[] = $m->getPseudo();
    $row[] = $m->getContact()->getEmail();
    $row[] = $m->getFirstName();
    $row[] = $m->getLastName();
    $row[] = $m->getMailing();
    $tbl->addRow($row);
}

echo $tbl->getTable();
