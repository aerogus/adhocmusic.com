#!/usr/bin/env php
<?php

/**
 * Efface un membre
 * + toutes ses photos
 * + tous ses messages
 * + toutes ses vidéos
 * + tous ses sons
 * + liaison compte/groupe
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */

declare(strict_types=1);

use Adhoc\Model\Membre;
use Adhoc\Model\Photo;
use Adhoc\Model\Audio;
use Adhoc\Model\Video;
use Adhoc\Model\Event;

require_once __DIR__ . '/../bootstrap.php';

if (!isset($argv[1])) {
    die('usage: clean-mbr.php id_contact' . "\n");
}
$id_contact = (int) $argv[1];

$do = false;
if (isset($argv[2])) {
    $do = (bool) $argv[2];
}

$membre = Membre::getInstance($id_contact);
echo "Pseudo: " . $membre->getPseudo() . "\n";

$photos = Photo::find(['id_contact' => $id_contact, 'limit' => 100]);
echo "Photos: " . count($photos) . "\n";

$audios = Audio::find(['id_contact' => $id_contact]);
echo "Audios: " . count($audios) . "\n";

$videos = Video::find(['id_contact' => $id_contact]);
echo "Videos: " . count($videos) . "\n";

$events = Event::find(['id_contact' => $id_contact, 'limit' => 100]);
echo "Evenements: " . count($events) . "\n";

if ($do) {
    foreach ($photos as $photo) {
        echo "delete photo " . $photo->getName() . "\n";
        $photo->delete();
    }

    foreach ($audios as $audio) {
        echo "delete audio " . $audio->getName() . "\n";
        $audio->delete();
    }

    foreach ($videos as $video) {
        echo "delete video " . $video->getName() . "\n";
        $video->delete();
    }

    foreach ($events as $event) {
        echo "delete event " . $event->getName() . "\n";
        $event->delete();
    }

    echo "delete membre " . $membre->getPseudo() . "\n";
    $membre->delete();
}
