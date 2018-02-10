#!/usr/bin/env php
<?php

/**
 * Efface les groupes
 * + toutes leurs photos
 * + toutes leurs dates
 * + toutes leurs vidéos
 * + tous leurs sons
 * + liaison compte/groupe
 * + liaison groupe/evenement
 */

require_once dirname(__FILE__) . '/../config.php';

if (empty($argv[1]))
  die('usage: cleangrp.php alias_groupe');

$alias = $argv[1];
$do = false;
if (!empty($argv[2])) {
    $do = (bool) $argv[2];
}

if (!($id_groupe = Groupe::getIdByAlias($alias)))
  die('groupe ' . $alias . ' introuvable');

$groupe = Groupe::getInstance($id_groupe);
echo "Groupe: " . $groupe->getName() . "\n";

$photos = Photo::getPhotos(['groupe' => $id_groupe]);
echo "Photos: ". sizeof($photos) . "\n";

$audios = Audio::getAudios(['groupe' => $id_groupe]);
echo "Audios: " . sizeof($audios) . "\n";

$videos = Video::getVideos(['groupe' => $id_groupe]);
echo "Videos: " . sizeof($videos) . "\n";

$events = Event::getEvents(['groupe' => $id_groupe, 'limit' => 100]);
echo "Evenements: " . sizeof($events) . "\n";

if ($do) {

    foreach ($photos as $photo) {
        $p = Photo::getInstance($photo['id']);
        echo "delete photo " . $p->getName() . "\n";
        $p->delete();
    }

    foreach ($audios as $audio) {
        $a = Audio::getInstance($audio['id']);
        echo "delete audio " . $a->getName() . "\n";
        $a->delete();
    }

    foreach ($videos as $video) {
        $v = Video::getInstance($video['id']);
        echo "delete video " . $v->getName() . "\n";
        $v->delete();
    }

    foreach ($events as $event) {
        $e = Event::getInstance($event['id']);
        echo "delete event " . $e->getName() . "\n";
        $e->delete();
    }

    echo "delete groupe " . $groupe->getName();
    $groupe->delete();
}
