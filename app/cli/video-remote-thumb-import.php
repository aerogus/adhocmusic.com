#!/usr/bin/env php
<?php

/**
 * Script pour récupérer / remplacer les imagettes vidéos
 *
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */

declare(strict_types=1);

use Adhoc\Model\Video;

require_once __DIR__ . '/../bootstrap.php';

$videos = Video::find(
    [
        'order_by'  => 'id_video',
        'sort'  => 'ASC',
        'limit' => 1000,
    ]
);

define('URL_DEST', MEDIA_PATH . '/video/');

foreach ($videos as $video) {
    echo "Video : " . $video->getIdVideo() . "\n";
    if (in_array($video->getIdHost(), [Video::HOST_YOUTUBE, Video::HOST_DAILYMOTION], true)) {
        if (strlen($thumbUrl = Video::getRemoteThumbnail($video->getIdHost(), $video->getReference())) > 0) {
            echo "Thumb : " . $thumbUrl . "\n";
            $thumb = file_get_contents($thumbUrl);
            $dest = URL_DEST . $video->getIdVideo() . '.jpg';
            $nb = file_put_contents($dest, $thumb);
            echo $nb . " | " . $dest . "\n";
        } else {
            echo "Thumb : *** non récupérée ***\n";
        }
    }
    echo "---\n";
}
