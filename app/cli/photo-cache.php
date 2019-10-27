#!/usr/bin/env php
<?php declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

/**
 * Vide et regénère le cache de l'ensemble des photos
 */

echo "nb photos trouvées : " . Photo::getPhotosCount() . "\n";

define('CACHE_ERASE',  true);
define('CACHE_CREATE', true);

$photos = Photo::getPhotos(
    [
        'sort' => 'id_photo',
        'sens' => 'ASC',
        'limit' => 5000,
    ]
);

foreach ($photos as $photo) {

    // efface le cache des formats anciens et actuels
    if (CACHE_ERASE) {
        if (Photo::invalidatePhotoInCache((int) $photo['id'],   80,  80, '000000', false,  true)) { // carré 80
            echo "erase " . $photo['id'] . " -    80x80\n";
        }
        if (Photo::invalidatePhotoInCache((int) $photo['id'],  130, 130, '000000', false, false)) { // deprecated
            echo "erase " . $photo['id'] . " -  130x130\n";
        }
        if (Photo::invalidatePhotoInCache((int) $photo['id'],  400, 300, '000000', false, false)) { // deprecated
            echo "erase " . $photo['id'] . " -  400x300\n";
        }
        if (Photo::invalidatePhotoInCache((int) $photo['id'],  680, 600, '000000', false, false)) { // page photo show
            echo "erase " . $photo['id'] . " -  680x600\n";
        }
        if (Photo::invalidatePhotoInCache((int) $photo['id'],  320,   0, '000000', false, false)) { // new 2019
            echo "erase " . $photo['id'] . " -    320x0\n";
        }
        if (Photo::invalidatePhotoInCache((int) $photo['id'], 1000,   0, '000000', false, false)) { // new 2019
            echo "erase " . $photo['id'] . " -   1000x0\n";
        }
    }

    if (CACHE_CREATE) {
        $url = Photo::getPhotoUrl((int) $photo['id'],    80,  80, '000000', false,  true);
        echo "create " . $photo['id'] . " -   80x80 - " . $url . "\n";
        $url = Photo::getPhotoUrl((int) $photo['id'],   680, 600, '000000', false, false);
        echo "create " . $photo['id'] . " - 680x600 - " . $url . "\n";
        $url = Photo::getPhotoUrl((int) $photo['id'],   320,   0, '000000', false, false);
        echo "create " . $photo['id'] . " -   320x0 - " . $url . "\n";
        $url = Photo::getPhotoUrl((int) $photo['id'],  1000,   0, '000000', false, false);
        echo "create " . $photo['id'] . " -  1000x0 - " . $url . "\n";
        flush();
    }
}
