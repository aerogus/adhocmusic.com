#!/usr/bin/env php
<?php

require_once dirname(__FILE__) . '/../config.php';

$eph = Ephemeride::getInstance(0);
$res = $eph->getAll();

foreach ($res as $day => $data) {
  echo DateTime::createFromFormat('m-d', $day)->format('F dS') . "\n";
  foreach ($data as $year => $groupes) {
    echo "- " . $year . ": " . implode($groupes, " + ") . "\n";
  }
}

