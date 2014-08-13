#!/usr/bin/php
<?php

require_once 'common-cli.inc.php';

$db = DataBase::getInstance();

foreach(City::getHashTable() as $id => $name)
{
    $sql = "INSERT INTO `geo_fr_city` "
         . "(`id_city`, `name`) "
         . "VALUES ('".$db->escape($id)."', '".$db->escape($name)."')";
    //$res = $db->query($sql);
    echo $sql."\n";
}

