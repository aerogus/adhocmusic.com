#!/usr/bin/env php
<?php

/**
 * vieux groupes n'ayant jamais mis à jour leur fiche depuis des lustres
 */

require_once dirname(__FILE__) . '/../config.php';

$db = DataBase::getInstance();

$sql = "SELECT alias, modified_on FROM adhoc_groupe WHERE DATE(modified_on) < '2010-01-01' ORDER BY modified_on DESC";

$rows = $db->queryWithFetch($sql);

foreach ($rows as $row) {
    echo $row['modified_on'] . " " . $row['alias'] . "\n";
}

