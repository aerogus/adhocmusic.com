#!/usr/bin/php
<?php

require_once 'common-cli.inc.php';

$db = DataBase::getInstance();

// charge la procédure stockée mysql de calcul de distance

Lieu::mysql_init_geo();

