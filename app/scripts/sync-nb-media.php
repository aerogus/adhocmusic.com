#!/usr/bin/php
<?php

require_once __DIR__ . '/../config.php';

/**
 * Recalcule le nombre d'audio,photo,video pour un event
 */

Event::syncNbMedia();

