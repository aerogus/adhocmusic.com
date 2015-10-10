#!/usr/bin/php
<?php

require_once 'common-cli.inc.php';

/**
 * génère dans le cache l'ensemble des vignettes vidéos
 * en 80x80 zoomé
 */

echo "nb vidéos : " . Video::getVideosCount() . "\n";

$videos = Video::getVideos(array(
    'online' => true,
    'sort' => 'id_video',
    'sens' => 'ASC',
    'limit' => 2500,
));

foreach($videos as $video)
{
    Video::invalidateVideoThumbInCache($video['id'], 80, 80, '000000', false, true);
    $url = Video::getVideoThumbUrl($video['id'], 80, 80, '000000', false, true);
    echo $video['id'] . " - " . $url . "\n";
    flush();
}
