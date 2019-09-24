#!/usr/bin/env php
<?php declare(strict_types=1);

/**
 * Initialise des contacts
 */

require_once __DIR__ . '/../../bootstrap.php';

$emails = [
    'gus@adhocmusic.com',
    'lara@adhocmusic.com',
];

/*
Contact::getInstance(1)->delete();
Contact::getInstance(2)->delete();
*/

foreach ($emails as $email) {
    $id_contact = Contact::init()
        ->setEmail($email)
        ->save();
    echo $id_contact;
}