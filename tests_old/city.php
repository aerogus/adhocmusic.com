#!/usr/bin/env php
<?php

declare(strict_types=1);

use Adhoc\Model\Reference\City;
use Adhoc\Utils\LogNG;

require_once __DIR__ . '/../app/bootstrap.php';

$cs = City::find([
    'id_departement' => 91
]);

foreach ($cs as $c) {
    LogNG::info($c->getName());
}

