#!/usr/bin/env php
<?php

/**
 * Dump d'un lieu
 *
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */

declare(strict_types=1);

use Adhoc\Model\Lieu;

require_once __DIR__ . '/../app/bootstrap.php';

$id_lieu = $argv[1] ?? null;

if (!is_null($id_lieu)) {
    $lieu = Lieu::getInstance($id_lieu);
    var_dump($lieu);
}
