#!/usr/bin/php
<?php

require_once 'common-cli.inc.php';

$db = DataBase::getInstance();

foreach(WorldCountry::getHashTable() as $id => $name)
{
    $sql = "INSERT INTO `geo_world_country` "
         . "(`id_country`, `name`) "
         . "VALUES ('".$db->escape($id)."', '".$db->escape($name)."')";
    //$res = $db->query($sql);
    echo $sql."\n";
}

