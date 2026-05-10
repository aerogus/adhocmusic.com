#!/usr/bin/env php
<?php

/**
 * Liste des membres
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */

declare(strict_types=1);

use Adhoc\Model\Membre;
use cli\Table;

require_once __DIR__ . '/../bootstrap.php';

$ms = Membre::findAll();

$headers = [
    'id_contact',
    'pseudo',
    'email',
    'first_name',
    'last_name',
    'mailing',
];

$data = [];
foreach ($ms as $m) {
    $data[] = [
        $m->getIdContact(),
        $m->getPseudo(),
        $m->getContact()->getEmail(),
        $m->getFirstName(),
        $m->getLastName(),
        $m->getMailing(),
    ];
}

$table = new Table();
$table->setHeaders($headers);
$table->setRows($data);
$table->display();