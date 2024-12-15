#!/usr/bin/env php
<?php

declare(strict_types=1);

use Adhoc\Model\Photo;
use Adhoc\Model\Audio;
use Adhoc\Model\Video;

require_once __DIR__ . '/../bootstrap.php';

// vérifie que les photos + vidéos + audios ont bien leur id_lieu et id_event synchro

$medias = Photo::findAll();
//$medias = Audio::findAll();
//$medias = Video::findAll();

foreach ($medias as $media) {
    if (!is_null($media->getIdEvent())) {
        if (is_null($media->getIdLieu())) {
            echo "[" . get_class($media) . " " . $media->getIdMedia() . "] event " . $media->getIdEvent() . " mais 0 lieu, zarb\n";
   //         $media->setIdLieu($media->getEvent()->getIdLieu())->save();
        } else {
            if ($media->getEvent()->getIdLieu() !== $media->getIdLieu()) {
                echo "[" . get_class($media) . " " . $media->getIdMedia() . "] id_lieu = " . $media->getIdLieu() . " mais event::id_lieu = " . $media->getEvent()->getIdLieu() . ", zarb\n";
     //           $media->setIdLieu($media->getEvent()->getIdLieu())->save();
            }
        }
    }
}
