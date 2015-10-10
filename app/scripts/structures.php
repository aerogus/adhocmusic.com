#!/usr/bin/php
<?php

require_once 'common-cli.inc.php';

/**
 * lie des evenements a des structures
 */

die('désactivé');

// à préciser
define('ID_STRUCTURE', 12);
define('ID_LIEU', 250);

$db = DataBase::getInstance();
$sql = "SELECT `id_event` FROM `adhoc_event` WHERE `id_lieu` = " . ID_LIEU;
$res = $db->queryWithFetch($sql);

foreach($res as $_res) {
    $id_event = (int) $_res['id_event'];
    $sql = "INSERT INTO `adhoc_organise_par` (`id_structure`, `id_event`) VALUES(".ID_STRUCTURE.", ".$id_event.")";
    echo $sql ."\n";
    $db->query($sql);
}

