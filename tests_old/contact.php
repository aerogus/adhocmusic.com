#!/usr/bin/env php
<?php

/**
 * Liste des contacts
 *
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */

declare(strict_types=1);

use Adhoc\Model\Contact;

require_once __DIR__ . '/../bootstrap.php';

$cs = Contact::findAll();

$tbl = new \Console_Table();
$tbl->setHeaders(
    ['id_contact', 'email', 'is_membre', 'mailing']
);

foreach ($cs as $c) {
    $row = [];
    $row[] = $c->getIdContact();
    $row[] = $c->getEmail();
    if ($c->getMembre()) {
        $row[] = $c->isMembre();
        $row[] = $c->getMembre()->getMailing();
    } else {
        $row[] = $c->isMembre();
        $row[] = true;
    }
    $tbl->addRow($row);
}

echo $tbl->getTable();
