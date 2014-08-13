<?php
header ("Content-type: image/jpeg");
require_once "planch_creator.php";
$cont = (isset($_GET['cont']) ? $_GET['cont'] : -20);
$bright = (isset($_GET['bright']) ? $_GET['bright'] : -100);
$red = (isset($_GET['red']) ? $_GET['red'] : 255);
$green = (isset($_GET['green']) ? $_GET['green'] : 255);
$blue = (isset($_GET['blue']) ? $_GET['blue'] : 255);
$gray = (isset($_GET['gray']) ? $_GET['gray'] : 255);
$conso = (isset($_GET['conso']) ? $_GET['conso'] : 0);
global $date;
global $event;
$event = (isset($_GET['event']) ? $_GET['event'] : "AdHoc");
$date = (isset($_GET['date']) ? $_GET['date'] : "1970-01-01");

$font_num = imageloadfont('verdana.gdf');

$im = create_badge_case($cont, $bright, $red, $green, $blue, $gray, $conso, $font_num);

imagejpeg($im);
