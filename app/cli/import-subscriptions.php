#!/usr/bin/env php
<?php

/**
 * Import en masse de cotisations
 *
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */

declare(strict_types=1);

use Adhoc\Model\Subscription;

require_once __DIR__ . '/../bootstrap.php';

define('IMPORT_FILE', __DIR__ . '/subscriptions.csv');

if (($handle = fopen(IMPORT_FILE, 'r')) !== false) {
    while (($data = fgetcsv($handle, 1000, ',')) !== false) {
        echo "Insertion cotisation\n";
        (new Subscription())
            ->setSubscribedAt($data[0])
            ->setAmount((float) $data[1])
            ->setFirstName($data[2])
            ->setLastName($data[3])
            ->setEmail($data[4])
            ->setCp($data[5])
            ->save();
    }
    fclose($handle);
}
