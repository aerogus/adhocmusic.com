#!/usr/bin/php
<?php

require_once 'common-cli.inc.php';

$db = DataBase::getInstance();

// set l'id region pour les lieux, à partir de leur id_country et id_departement

$lieux = Lieux::getLieux(array(
    'limit' => 2000,
    'country' => 'FR',
));

foreach($lieux as $lieu)
{
    $id_region = Departement::getRegion($lieu['id_departement']);

    $sql = "UPDATE `adhoc_lieu` SET `id_region = '" . $db->escape($id_region) . "' WHERE `id_lieu` = " . (int) $lieu['id'];
    //$res = $db->query($sql);
    echo $sql."\n";
}


