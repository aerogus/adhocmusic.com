#!/usr/bin/env php
<?php

declare(strict_types=1);

use Adhoc\Model\Video;

// migration champ video.id_groupe vers table video_groupe

require_once __DIR__ . '/../bootstrap.php';

$videos = Video::findAll();
foreach ($videos as $video) {
    echo $video->getIdVideo() . ' ' . $video->getName() . "\n";
    if (!is_null($video->getIdGroupe())) {
        echo "link grp " . $video->getIdGroupe() . "\n";
        $video->linkGroupe($video->getIdGroupe());
        $video->setIdGroupe(null);
        $video->save();
    }
}
