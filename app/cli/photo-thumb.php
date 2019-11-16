#!/usr/bin/env php
<?php declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

/**
 * Vide et regénère le cache de l'ensemble des photos
 */

echo "nb de photos trouvées : " . Photo::count() . "\n";

define('CACHE_ERASE',  false);
define('CACHE_CREATE', true);

$photos = Photo::find(
    [
        'order_by' => 'id_photo',
        'sort' => 'ASC',
        'start' => 0,
        'limit' => 5000,
    ]
);

foreach ($photos as $photo) {

    if (CACHE_ERASE) {
        echo "erase " . $photo->getIdPhoto() . "\n";
        foreach ([80, 320, 680, 100] as $maxWidth) {
            if ($photo->clearThumb($maxWidth)) {
                echo "erase OK " . $photo->getIdPhoto() . " - " . $maxWidth . "\n";
            }
        }
        flush();
    }

    if (CACHE_CREATE) {
        echo "create " . $photo->getIdPhoto() . "\n";
        foreach ([80, 320, 680, 100] as $maxWidth) {
            if ($photo->genThumb($maxWidth)) {
                echo "create OK " . $photo->getIdPhoto() . " - " . $maxWidth . " : " . $photo->getThumbUrl($maxWidth) . "\n";
            }
        }
        flush();
    }

}
