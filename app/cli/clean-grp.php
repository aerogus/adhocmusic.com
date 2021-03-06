#!/usr/bin/env php
<?php declare(strict_types=1);

/**
 * Efface les groupes
 * + toutes leurs photos
 * + toutes leurs dates
 * + toutes leurs vidéos
 * + tous leurs sons
 * + liaison compte/groupe
 * + liaison groupe/evenement
 */

require_once __DIR__ . '/../bootstrap.php';

if (empty($argv[1])) {
    die('usage: cleangrp.php alias_groupe');
}

$alias = $argv[1];
$do = false;
if (!empty($argv[2])) {
    $do = (bool) $argv[2];
}

if (!($id_groupe = Groupe::getIdByAlias($alias))) {
    die('groupe ' . $alias . ' introuvable');
}

$groupe = Groupe::getInstance($id_groupe);
echo "Groupe: " . $groupe->getName() . "\n";

$photos = Photo::find(['id_groupe' => $id_groupe, 'limit' => 100]);
echo "Photos: ". count($photos) . "\n";

$audios = Audio::find(['id_groupe' => $id_groupe]);
echo "Audios: " . count($audios) . "\n";

$videos = Video::find(['id_groupe' => $id_groupe]);
echo "Videos: " . count($videos) . "\n";

$events = Event::find(['id_groupe' => $id_groupe, 'limit' => 100]);
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

    echo "delete groupe " . $groupe->getName();
    $groupe->delete();
}
