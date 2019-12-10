#!/usr/bin/env php
<?php declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

// vérifie si les vidéos distances sont tjrs valides / publiques

$videos = Video::findAll();

foreach ($videos as $video) {
    echo "Video " . $video->getId() . ": " . $video->getEmbedUrl() . "\n";
}
