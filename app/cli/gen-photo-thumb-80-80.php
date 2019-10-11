#!/usr/bin/env php
<?php declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

/**
 * génère dans le cache l'ensemble des photos
 * en 80x80 zoomé
 */

echo "nb photos : " . Photo::getPhotosCount() . "\n";

$photos = Photo::getPhotos(
    [
        'online' => true,
        'sort' => 'id_photo',
        'sens' => 'ASC',
        'limit' => 2500,
    ]
);

foreach ($photos as $photo) {
    Photo::invalidatePhotoInCache($photo['id'], 80, 80, '000000', false, true);
    $url = Photo::getPhotoUrl($photo['id'], 80, 80, '000000', false, true);
    echo $photo['id'] . " - " . $url . "\n";
    flush();
}
