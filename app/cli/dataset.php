#!/usr/bin/env php
<?php

declare(strict_types=1);

use Adhoc\Model\Audio;
use Adhoc\Model\Event;
use Adhoc\Model\FAQ;
use Adhoc\Model\Photo;
use Adhoc\Model\Groupe;
use Adhoc\Model\Lieu;
use Adhoc\Model\Structure;
use Adhoc\Model\Video;

require_once __DIR__ . '/../bootstrap.php';

if (ENV === 'PROD') {
    die('désactivé en PROD !!');
}

$classes = [
    'Event',
    'Structure',
    'Lieu',
    'Audio',
    'Photo',
    'Video',
    'Groupe',
    'FAQ',
];

foreach ($classes as $class) {
    // ménage données factices
    foreach ($class::findAll() as $obj) {
        $obj->delete();
    }
    // reset auto incrément
    $class::resetAutoIncrement();
}

// insertion données factices

for ($n = 1; $n <= 10; $n++) {
    echo "insertion structure " . $n . "\n";
    (new Structure())
        ->setName("Structure n°" . $n)
        ->save();
}

for ($n = 1; $n <= 10; $n++) {
    echo "insertion lieu " . $n . "\n";
    (new Lieu())
        ->setIdContact(1)
        ->setIdType(1)
        ->setName("Lieu n°" . $n)
        ->setText("Texte lieu n°" . $n)
        ->setIdCountry('FR')
        ->setIdRegion('A8')
        ->setIdDepartement('91')
        ->setIdCity(91216)
        ->setOnline(true)
        ->save();
}

for ($n = 1; $n <= 10; $n++) {
    echo "insertion groupe " . $n . "\n";
    $groupe = (new Groupe())
        ->setName("Groupe n°" . $n)
        ->setMiniText("Mini Texte n°" . $n)
        ->setText("Bio n°" . $n)
        ->setOnline(true);
    $groupe->save();
    $groupe->linkMember(1, 2);
}

for ($n = 1; $n <= 10; $n++) {
    echo "insertion event " . $n . "\n";
    $event = (new Event())
        ->setIdContact(1)
        ->setDate('2019-11-16 20:30:00')
        ->setName("Event n°" . $n)
        ->setText("Description event n°" . $n)
        ->setIdLieu($n)
        ->setOnline(true);
    $event->save();
    $event->linkGroupe($n);
    $event->linkStructure($n);
}

for ($n = 1; $n <= 10; $n++) {
    echo "insertion audio " . $n . "\n";
    (new Audio())
        ->setIdContact(1)
        ->setName("Audio n°" . $n)
        ->setIdGroupe($n)
        ->setOnline(true)
        ->save();
}

for ($n = 1; $n <= 10; $n++) {
    echo "insertion photo " . $n . "\n";
    (new Photo())
        ->setIdContact(1)
        ->setName("Photo n°" . $n)
        ->setIdGroupe($n)
        ->setOnline(true)
        ->save();
}

for ($n = 1; $n <= 10; $n++) {
    echo "insertion video " . $n . "\n";
    (new Video())
        ->setIdContact(1)
        ->setIdHost(1)
        ->setReference('gfdsfkl')
        ->setName("Vidéo n°" . $n)
        ->setIdGroupe($n)
        ->setOnline(true)
        ->save();
}

for ($n = 1; $n <= 10; $n++) {
    echo "insertion FAQ " . $n . "\n";
    (new FAQ())
        ->setIdCategory(1)
        ->setQuestion("Voici ma question")
        ->setAnswer("Telle est ma réponse")
        ->setOnline(true)
        ->save();
}
