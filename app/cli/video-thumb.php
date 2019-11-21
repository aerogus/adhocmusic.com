#!/usr/bin/env php
<?php declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

/**
 * génère dans le cache l'ensemble des vignettes vidéos
 * en 80x80 zoomé
 */

echo "nb de vidéos trouvées : " . Video::count() . "\n";

define('CACHE_ERASE',  false);
define('CACHE_CREATE', true);

$videos = Video::find(
    [
        'order_by' => 'id_video',
        'sort' => 'ASC',
    ]
);

foreach ($videos as $video) {

    if (CACHE_ERASE) {
        echo "erase " . $video->getIdVideo() . "\n";
        foreach ([80, 320] as $maxWidth) {
            if ($video->clearThumb($maxWidth)) {
                echo "erase OK " . $video->getIdVideo() . " - " . $maxWidth . "\n";
            }
        }
        flush();
    }

    if (CACHE_CREATE) {
        echo "create " . $video->getIdPhoto() . "\n";
        foreach ([80, 320] as $maxWidth) {
            if ($video->genThumb($maxWidth)) {
                echo "create OK " . $video->getIdVideo() . " - " . $maxWidth . " : " . $video->getThumbUrl($maxWidth) . "\n";
            }
        }
        flush();
    }

}
