#!/usr/bin/env php
<?php declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

/**
 * génère dans le cache l'ensemble des vignettes vidéos
 * en 80x80 zoomé
 */

echo "nb vidéos : " . Video::getVideosCount() . "\n";

$videos = Video::getVideos(
    [
        'online' => true,
        'sort' => 'id_video',
        'sens' => 'ASC',
        'limit' => 2500,
    ]
);

foreach ($videos as $video) {
    Video::invalidateVideoThumbInCache($video['id'], 80, 80, '000000', false, true);
    $url = Video::getVideoThumbUrl($video['id'], 80, 80, '000000', false, true);
    echo $video['id'] . " - " . $url . "\n";
    flush();
}

