#!/usr/bin/env php
<?php declare(strict_types=1);

/**
 * Initialise des contacts
 */

require_once __DIR__ . '/../../bootstrap.php';

$gs = ['hého', 'hàhà', 'coucou'];

foreach (Groupe::findAll() as $g) {
    $g->delete();
}

foreach ($gs as $g) {
    Groupe::init()->setName($g)->setOnline(true)->save();
}