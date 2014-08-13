#!/usr/bin/php
<?php

require_once 'common-cli.inc.php';

/**
 * recalcule le nombre d'audio,photo,video pour un event
 */

Event::syncNbMedia();

