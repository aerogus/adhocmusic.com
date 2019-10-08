#!/usr/bin/env php
<?php declare(strict_types=1);

/**
 * Initialise des types musiciens
 */

require_once __DIR__ . '/../../bootstrap.php';

$types = [
    "Batteur",
       "Guitariste",
  "Bassiste",
       "Chanteur",
      "Choriste",
        "Saxophoniste",
     "Flûtiste",
   "Trompettiste",
     "Tromboniste",
"Percussioniste",
   "Organiste",
   "Clavieriste",
     "Sampliste",
      "Pianiste",
    "Manager",
   "DJ",
      "VJ",
      "Ingénieur son",
       "Ingénieur lumière",
       "Violoniste",
     "Violoncelliste",
];

foreach ($types as $t) {
    TypeMusicien::init()->setName($t)->save();
}

var_dump(TypeMusicien::findAll());
