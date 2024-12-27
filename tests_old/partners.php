#!/usr/bin/env php
<?php

/**
 * Dump d'un lieu
 *
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */

declare(strict_types=1);

use Adhoc\Model\Partner;

require_once __DIR__ . '/../bootstrap.php';

$ps = Partner::findAll();
var_dump($ps);

/*
$p = Partner::init();
$p->setTitle('MJC François Rabelais');
$p->setDescription("MJC de Savigny sur Orge");
$p->setUrl('https://www.mjcsavigny.net');
$p->save();
*/