#!/usr/bin/php
<?php

require_once 'common-cli.inc.php';

$db = DataBase::getInstance();

foreach(WorldRegion::getHashTable() as $id_country => $country)
{
    foreach($country as $id_region => $name)
    {
        $sql = "INSERT INTO `geo_world_region` "
             . "(`id_country`, `id_region`, `name`) "
             . "VALUES ('".$db->escape($id_country)."', '".$db->escape($id_region)."', '".$db->escape($name)."')";
        //$res = $db->query($sql);
        echo $sql."\n";
    }
}

