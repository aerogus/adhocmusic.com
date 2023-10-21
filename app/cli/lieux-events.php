#!/usr/bin/env php
<?php

declare(strict_types=1);

// récupère les lieux avec/sans événements

require_once __DIR__ . '/../bootstrap.php';

$lieuxWithEvents = Lieu::find(['with_events' => true]);
$lieuxWithoutEvents = Lieu::find(['with_events' => false]);

$lieuxCount = Lieu::count();
$lieuxWithEventsCount = count($lieuxWithEvents);
$lieuxWithoutEventsCount = count($lieuxWithoutEvents);

echo "nombre de lieux: {$lieuCount}\n";

echo "lieux avec événements ({$lieuxWithEventsCount}):\n";
foreach ($lieuxWithEvents as $lieu) {
    echo $lieu->getUrl() . ' ' . $lieu->getName() . "\n";
}

echo "lieux sans événements ({$lieuxWithoutEventsCount}):\n";
foreach ($lieuxWithoutEvents as $lieu) {
    echo $lieu->getUrl() . ' ' . $lieu->getName() . "\n";
}
