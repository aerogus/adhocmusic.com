#!/usr/bin/php
<?php

require_once 'common-cli.inc.php';

$db = DataBase::getInstance();

foreach(Departement::getHashTable() as $id => $data)
{
    $sql = "INSERT INTO `geo_fr_departement` "
         . "(`id_departement`, `id_region`, `id_region_old`, `name`) "
         . "VALUES ('".$db->escape($id)."', '".$db->escape($data[0])."', 0, '".$db->escape($name)."')";
    //$res = $db->query($sql);
    echo $sql."\n";
}

