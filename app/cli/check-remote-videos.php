#!/usr/bin/env php
<?php

declare(strict_types=1);

use Adhoc\Model\Video;

require_once __DIR__ . '/../bootstrap.php';

// vérifie si les vidéos distances sont tjrs valides / publiques
// Facebook renvoie un 302 vers unsupported browser...

define('UTEMPO', 250000); // 250ms

$videos = Video::findAll();

foreach ($videos as $video) {
    $hdrs = get_headers($video->getEmbedUrl());
    echo "Video " . $video->getId() . ": " . $hdrs[0] . " " . $video->getEmbedUrl() . "\n";
    usleep(UTEMPO);
}
