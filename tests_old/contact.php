#!/usr/bin/env php
<?php

/**
 * Liste des contacts
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */

declare(strict_types=1);

use Adhoc\Model\Contact;
use cli\Table;

require_once __DIR__ . '/../bootstrap.php';

$cs = Contact::findAll();

$headers = [
    'id_contact',
    'email',
    'is_membre',
    'mailing',
];

$data = [];
foreach ($cs as $c) {
    $data[] = [
        $c->getIdContact(),
        $c->getEmail(),
        $c->isMembre(),
        $c->getMembre() ? $c->getMembre()->getMailing() : true,
    ];
}

$table = new Table();
$table->setHeaders($headers);
$table->setRows($data);
$table->display();