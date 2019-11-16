#!/usr/bin/env php
<?php declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

echo Departement::getInstance('92')->getName() . "\n";
echo City::getInstance(91216)->getName() . "\n";
echo WorldCountry::getInstance('FR')->getName() . "\n";

$wr = WorldRegion::getInstance(
    [
        'id_country' => 'FR',
        'id_region' => '97',
    ]
);

echo $wr->getIdCountry() . "\n";
echo $wr->getIdRegion() . "\n";
echo $wr->getName() . "\n";
