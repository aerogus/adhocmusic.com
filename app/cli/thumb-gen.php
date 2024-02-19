#!/usr/bin/env php
<?php

declare(strict_types=1);

use Adhoc\Model\Event;
use Adhoc\Model\Photo;
use Adhoc\Model\Video;
use Adhoc\Utils\Conf;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Vide et regénère le cache de l'ensemble des miniature des photos + vidéos + events
 */

$conf = Conf::getInstance();

$scheduler = [
    'photo' => [
        'process' => isset($_ENV['photo_process']) ? $_ENV['photo_process'] : false,
        'erase' => isset($_ENV['photo_erase']) ? $_ENV['photo_erase'] : false,
        'create' => isset($_ENV['photo_create']) ? $_ENV['photo_create'] : false,
        'widths' => $conf->get('photo')['thumb_width']
    ],
    'video' => [
        'process' => isset($_ENV['video_process']) ? $_ENV['video_process'] : false,
        'erase' => isset($_ENV['video_erase']) ? $_ENV['video_erase'] : false,
        'create' => isset($_ENV['video_create']) ? $_ENV['video_create'] : false,
        'widths' => $conf->get('video')['thumb_width'],
    ],
    'event' => [
        'process' => isset($_ENV['event_process']) ? $_ENV['event_process'] : false,
        'erase' => isset($_ENV['event_erase']) ? $_ENV['event_erase'] : false,
        'create' => isset($_ENV['event_create']) ? $_ENV['event_create'] : false,
        'widths' => $conf->get('event')['thumb_width'],
    ],
];

if ($scheduler['photo']['process']) {
    echo Photo::count() . " photos trouvées\n";
    $photos = Photo::find(
        [
            'order_by' => 'id_photo',
            'sort' => 'ASC',
        ]
    );
    foreach ($photos as $photo) {
        echo "Photo " . $photo->getIdPhoto() . "\n";
        if ($scheduler['photo']['erase']) {
            echo "  Erase\n";
            foreach ($scheduler['photo']['widths'] as $maxWidth) {
                if ($photo->clearThumb($maxWidth)) {
                    echo "    OK - " . $maxWidth . "\n";
                } else {
                    echo "    KO - " . $maxWidth . "\n";
                }
            }
        }
        if ($scheduler['photo']['create']) {
            echo "  Create\n";
            foreach ($scheduler['photo']['widths'] as $maxWidth) {
                if ($photo->genThumb($maxWidth)) {
                    echo "    OK - " . $maxWidth . " : " . $photo->getThumbUrl($maxWidth) . "\n";
                } else {
                    echo "    KO - " . $maxWidth . "\n";
                }
            }
        }
    }
}

if ($scheduler['video']['process']) {
    echo Video::count() . " vidéos trouvées\n";
    $videos = Video::find(
        [
            'order_by' => 'id_video',
            'sort' => 'ASC',
        ]
    );
    foreach ($videos as $video) {
        echo "Vidéo " . $video->getIdVideo() . "\n";
        if ($scheduler['video']['erase']) {
            echo "  Erase\n";
            foreach ($scheduler['video']['widths'] as $maxWidth) {
                if ($video->clearThumb($maxWidth)) {
                    echo "    OK - " . $maxWidth . "\n";
                } else {
                    echo "    KO - " . $maxWidth . "\n";
                }
            }
        }
        if ($scheduler['video']['create']) {
            echo "  Create " . $video->getIdVideo() . "\n";
            foreach ($scheduler['video']['widths'] as $maxWidth) {
                if ($video->genThumb($maxWidth)) {
                    echo "    OK - " . $maxWidth . " : " . $video->getThumbUrl($maxWidth) . "\n";
                } else {
                    echo "    KO - " . $maxWidth . "\n";
                }
            }
        }
    }
}

if ($scheduler['event']['process']) {
    echo Event::count() . " événements trouvés\n";
    $events = Event::find(
        [
            'order_by' => 'id_event',
            'sort' => 'ASC',
        ]
    );
    foreach ($events as $event) {
        echo "Événement " . $event->getIdEvent() . "\n";
        if ($scheduler['event']['erase']) {
            echo "  Erase\n";
            foreach ($scheduler['event']['widths'] as $maxWidth) {
                if ($event->clearThumb($maxWidth)) {
                    echo "    OK - " . $maxWidth . "\n";
                } else {
                    echo "    KO - " . $maxWidth . "\n";
                }
            }
        }
        if ($scheduler['event']['create']) {
            echo "  Create " . $event->getIdEvent() . "\n";
            foreach ($scheduler['event']['widths'] as $maxWidth) {
                if ($event->genThumb($maxWidth)) {
                    echo "    OK - " . $maxWidth . " : " . $event->getThumbUrl($maxWidth) . "\n";
                } else {
                    echo "    KO - " . $maxWidth . "\n";
                }
            }
        }
    }
}

echo "FIN\n";
