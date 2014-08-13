<?php
/**
 * gen_planche
 * 
 * @package adhoc
 * @author Taddei Gilles <gilles.taddei@gmail.com>
 */

//The "picture" created.
header ("Content-type: image/png");
require_once "planch_creator.php";

//print($_GET['groupes']);
//resize("badge.png","mini-radial.png");
$names = unserialize(trim($_GET['names']));
//printr($names);
$groupes = unserialize(trim($_GET['groupes']));
$i = $_GET['i'];
$nb = $_GET['nb'];
$red = $_GET['red'];
$blue = $_GET['blue'];
$green = $_GET['green'];
$conso = $_GET['conso'];
global $date;
global $event;
$event = (isset($_GET['event']) ? $_GET['event'] : "AdHoc");
$date = (isset($_GET['date']) ? $_GET['date'] : "1970-01-01");
//$image = resize_no_file("badge.png");
//imagejpeg($image);
$img = create_planch($groupes, $names, $i, $nb, $_GET['rows'], $_GET['cols'], $_GET['gray'], $_GET['box'],$_GET['ecart_x'],$_GET['ecart_y'], $_GET['cont'], $_GET['bright'], $red, $green, $blue, $conso);
/*imagefilter($img, IMG_FILTER_CONTRAST, $_GET['cont']);
  imagefilter($img, IMG_FILTER_BRIGHTNESS, $_GET['bright']);*/
imagepng($img);