#!/usr/bin/php
<?php

require_once dirname(__FILE__) . '/../config.php';

/**
 * recalcule le nombre d'audio,photo,video pour un event
 */

Event::syncNbMedia();

