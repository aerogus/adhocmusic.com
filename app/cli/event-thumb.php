#!/usr/bin/env php
<?php declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

/**
 * Vide et regénère le cache de l'ensemble des miniatures des événements
 */

echo "nb d'événements trouvées : " . Event::count() . "\n";

define('CACHE_ERASE',  false);
define('CACHE_CREATE', true);

$events = Event::find(
    [
        'order_by' => 'id_event',
        'sort' => 'ASC',
    ]
);

foreach ($events as $event) {

    echo "Traitement événement " . $event->getIdEvent() . "\n";

    if (CACHE_ERASE) {
        echo "erase " . $event->getIdEvent() . "\n";
        foreach ([100, 320] as $maxWidth) {
            if ($event->clearThumb($maxWidth)) {
                echo "erase OK " . $event->getIdEvent() . " - " . $maxWidth . "\n";
            }
        }
        flush();
    }

    if (CACHE_CREATE) {
        echo "create " . $event->getIdEvent() . "\n";
        foreach ([100, 320] as $maxWidth) {
            if ($event->genThumb($maxWidth)) {
                echo "create OK " . $event->getIdEvent() . " - " . $maxWidth . " : " . $event->getThumbUrl($maxWidth) . "\n";
            }
        }
        flush();
    }

}

echo "fin\n";
