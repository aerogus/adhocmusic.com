#!/usr/bin/env php
<?php declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

/**
 * génère dans le cache l'ensemble des vignettes vidéos
 * en 80x80 zoomé
 */

echo "nb vidéos : " . Video::count() . "\n";

$videos = Video::find(
    [
        'online' => true,
        'order_by' => 'id_video',
        'sort' => 'ASC',
        'limit' => 2500,
    ]
);

foreach ($videos as $video) {
    Video::invalidateVideoThumbInCache($video->getIdVideo(), 80, 80, '000000', false, true);
    $url = Video::getVideoThumbUrl($video->getIdVideo(), 80, 80, '000000', false, true);
    echo $video->getIdVideo() . " - " . $url . "\n";
    flush();
}

