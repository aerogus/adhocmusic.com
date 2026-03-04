#!/usr/bin/env php
<?php

/**
 * Test du parseur d'url pour extraire l'identifiant
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */

declare(strict_types=1);

use Adhoc\Model\Video;

require_once __DIR__ . '/../bootstrap.php';

$url = 'https://www.youtube.com/watch?v=9TGlc0Fufgk&list=RD9TGlc0Fufgk&start_radio=1';

$info = Video::parseStringForVideoUrl($url);

var_dump($info);

