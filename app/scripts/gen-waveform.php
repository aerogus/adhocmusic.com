#!/usr/bin/php
<?php

require_once 'common-cli.inc.php';

/**
 * génère les waveform des mp3
 */

define('AUDIO_PATH', '/var/www/adhocmusic.com/media/audio');
define('WAVEFORM_PATH', '/var/www/adhocmusic.com/media/audiowaveform');

$audios = Audio::getAudios(array(
    'online' => true,
    'limit'  => 5000,
));

echo "*** BEGIN ***\n";

foreach($audios as $audio)
{
    echo "-- audio " . $audio['id'] . " --\n";
    $a = new AudioWaveForm();
    $a->setSourceFile(AUDIO_PATH . '/' . $audio['id'] . '.mp3');
    $a->setDestinationFile(WAVEFORM_PATH . '/' . $audio['id'] . '.png');
    $a->setDestinationWidth(500);
    $a->setDestinationHeight(100);
    $a->setDestinationColor('#ed3438');
    $a->setDestinationBgcolor('#ffffff');
    $a->run();
    unset($a);
    echo "\n";
}

echo "*** END ***\n";
