#!/usr/bin/env php
<?php declare(strict_types=1);

/**
 * Initialise des styles
 */

require_once __DIR__ . '/../../bootstrap.php';

$s = Style::find(1);
echo $s;
die;

$styles = [
  "Rock",
       "Reggae",
     "Techno",
      "Métal",
      "World",
  "Chanson",
 "Hip Hop",
      "R'n'B",
        "Jazz",
         "Funk",
   "Disco",
     "Classique",
    "Pop",
    "Progressif",
       "Punk",
        "Ska",
       "Trip Hop",
        "Fusion",
       "Dub",
        "Heavy",
     "Drum 'n Bass",
       "Celtique",
       "House",
     "Electro",
 "Soul",
     "Blues",
        "Festif",
 "Raï",
     "Folk",
        "Latino",
     "Country",
];

foreach ($styles as $s) {
    Style::init()->setName($s)->save();
}

var_dump(Style::findAll());
