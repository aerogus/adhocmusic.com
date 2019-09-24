#!/usr/bin/env php
<?php declare(strict_types=1);

/**
 * Initialise des contacts
 */

require_once __DIR__ . '/../../bootstrap.php';

$data = [
    ['gus@adhocmusic.com', 'Gus', 'Seznec'],
    ['lara@adhocmusic.com', 'Lara', 'Etcheverry'],
];

foreach ($data as $idx => $_data) {
    $id_contact = Contact::init()
        ->setEmail($_data[0])
        ->save();
    echo "créa  contact " . $id_contact . "\n";

    Membre::getInstance($id_contact)
        ->setFirstName($_data[1])
        ->setLastName($_data[2])
        ->save();
    echo "créa membre\n";
}
