#!/usr/bin/env php
<?php declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

/**
 * Vide et regénère le cache de l'ensemble des photos
 */

echo "nb photos trouvées : " . Photo::count() . "\n";

define('CACHE_ERASE',  false);
define('CACHE_CREATE', true);

$photos = Photo::find(
    [
        'order_by' => 'id_photo',
        'sort' => 'ASC',
        'limit' => 5000,
    ]
);

foreach ($photos as $photo) {

    // efface le cache des formats anciens et actuels
    if (CACHE_ERASE) {
        echo "erase " . $photo->getIdPhoto() . "\n";
        if (Photo::invalidatePhotoInCache($photo->getIdPhoto(),   80,  80, '000000', false,  true)) { // carré 80
            echo "erase " . $photo->getIdPhoto() . " -    80x80\n";
        }
        if (Photo::invalidatePhotoInCache($photo->getIdPhoto(),  130, 130, '000000', false, false)) { // deprecated
            echo "erase " . $photo->getIdPhoto() . " -  130x130\n";
        }
        if (Photo::invalidatePhotoInCache($photo->getIdPhoto(),  400, 300, '000000', false, false)) { // deprecated
            echo "erase " . $photo->getIdPhoto() . " -  400x300\n";
        }
        if (Photo::invalidatePhotoInCache($photo->getIdPhoto(),  680, 600, '000000', false, false)) { // page photo show
            echo "erase " . $photo->getIdPhoto() . " -  680x600\n";
        }
        if (Photo::invalidatePhotoInCache($photo->getIdPhoto(),  320,   0, '000000', false, false)) { // new 2019
            echo "erase " . $photo->getIdPhoto() . " -    320x0\n";
        }
        if (Photo::invalidatePhotoInCache($photo->getIdPhoto(), 1000,   0, '000000', false, false)) { // new 2019
            echo "erase " . $photo->getIdPhoto() . " -   1000x0\n";
        }
        flush();
    }

    if (CACHE_CREATE) {
        echo "create " . $photo->getIdPhoto() . "\n";
        $url = Photo::getPhotoUrl($photo->getIdPhoto(),    80,  80, '000000', false,  true);
        echo "create " . $photo->getIdPhoto() . " -   80x80 - " . $url . "\n";
        $url = Photo::getPhotoUrl($photo->getIdPhoto(),   680, 600, '000000', false, false);
        echo "create " . $photo->getIdPhoto() . " - 680x600 - " . $url . "\n";
        $url = Photo::getPhotoUrl($photo->getIdPhoto(),   320,   0, '000000', false, false);
        echo "create " . $photo->getIdPhoto() . " -   320x0 - " . $url . "\n";
        $url = Photo::getPhotoUrl($photo->getIdPhoto(),  1000,   0, '000000', false, false);
        echo "create " . $photo->getIdPhoto() . " -  1000x0 - " . $url . "\n";
        flush();
    }
}
