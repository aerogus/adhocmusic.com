#!/usr/bin/php
<?php

require_once __DIR__ . '/../config.php';

/**
 * recalcule le nombre d'audio,photo,video pour un event
 */

Event::syncNbMedia();

