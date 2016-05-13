#!/usr/bin/php
<?php

/**
 * Script pour récupérer / remplacer les imagettes vidéos
 *
 * @package adhoc
 * @author Guillaume Seznec <guillaume.seznec@gmail.com>
 */

require_once 'common-cli.inc.php';

$videos = Video::getVideos(array(
    'limit' => 1000,
    'sort'  => 'id',
    'sens'  => 'ASC',
));

define('URL_DEST', ADHOC_ROOT_PATH . '/media/video/');

foreach($videos as $video)
{
    echo "Video : ".$video['id_video']."\n";
    if($video['id_host'] === Video::HOST_YOUTUBE || $video['id_host'] === Video::HOST_DAILYMOTION) {
        if($thumbUrl = Video::getRemoteThumbnail($video['id_host'], $video['reference'], false)) {
            echo "Thumb : ".$thumbUrl."\n";
            $thumb = file_get_contents($thumbUrl);
            $dest = URL_DEST.$video['id_video'].'.jpg';
            $nb = file_put_contents($dest, $thumb);
            echo $nb." | ".$dest."\n";
        } else {
            echo "Thumb : *** non récupérée ***\n";
        }
    }
    echo "---\n";
}

