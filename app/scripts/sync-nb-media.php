#!/usr/bin/env php
<?php declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

/**
 * Recalcule le nombre d'audio,photo,video pour un event
 */

Event::syncNbMedia();

