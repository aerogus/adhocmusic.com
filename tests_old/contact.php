#!/usr/bin/env php
<?php

declare(strict_types=1);

use Adhoc\Model\Contact;
use Adhoc\Utils\LogNG;

require_once __DIR__ . '/../app/bootstrap.php';

$cs = Contact::findAll();

$tbl = new \Console_Table();
$tbl->setHeaders(
    ['id_contact', 'email', 'mailing']
);

foreach ($cs as $c) {
    $row = [];
    $row[] = $c->getIdContact();
    $row[] = $c->getEmail();
    if ($c->getMembre()) {
        $row[] = $c->getMembre()->getMailing();
    } else {
        $row[] = true;
    }
    $tbl->addRow($row);
}

echo $tbl->getTable();
