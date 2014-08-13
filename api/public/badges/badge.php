<?php
$cont = (isset($_POST['cont']) ? $_POST['cont'] : -20);
$bright = (isset($_POST['bright']) ? $_POST['bright'] : -1000);
$red = (isset($_POST['red']) ? $_POST['red'] : 255);
$green = (isset($_POST['green']) ? $_POST['green'] : 255);
$blue = (isset($_POST['blue']) ? $_POST['blue'] : 255);
$gray = (isset($_POST['gray']) ? $_POST['gray'] : 255);
$box = (isset($_POST['box']) ? $_POST['box'] : 0);
$conso = (isset($_POST['conso']) ? $_POST['conso'] : 0);
$band =  (isset($_POST['band']) ? $_POST['band'] : 0);
$name =  (isset($_POST['name']) ? $_POST['name'] : 0);
$date =  (isset($_POST['date']) ? $_POST['date'] : '1970-01-01');
$event =  (isset($_POST['event']) ? $_POST['event'] : 'AdHoc');
if ($box == 0)
    {
        echo "<img width=\"300\" src='create_badge.php?cont=".$cont."&gray=".$_POST['gray']."&bright=".$bright."&red=".$red."&green=".$green."&blue=".$blue."&conso=".$conso."&band=".$band."&name=".$name."&event=".$event."&date=".$date."'\>";
    }
else
    {
        echo "<img width=\"300\" src='create_badge_case.php?cont=".$cont."&gray=".$_POST['gray']."&bright=".$bright."&red=".$red."&green=".$green."&blue=".$blue."&conso=".$conso."&event=".$event."&date=".$date."'\>";
    }