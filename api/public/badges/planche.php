<?php
/**
 * planche
 *
 * @package adhoc
 * @author Taddei Gilles <gilles.taddei@gmail.com>
 */


global $ecart_x;
global $ecart_y;
//echo "toto".$ecart_x." ".$ecart_y."titi<br/>";
//The "picture" created.
require_once "planch_creator.php";
/*foreach($_POST as $key => $value)
  echo "$key => $value<br/>";*/
$date =  (isset($_POST['date']) ? $_POST['date'] : '1970-01-01');
$event =  (isset($_POST['event']) ? $_POST['event'] : 'AdHoc');
$str = $_POST['nom'];
if ($_POST['nom'] == "")
    {
        $_POST['nom'] = "|";
    }
$size = strlen($str);
if ($size > 0)
    {
        if (!(($str[$size - 1] < 'Z' & $str[$size - 1] > 'A')
              ||($str[$size - 1] < 'z' & $str[$size - 1] > 'a')))
            {
                $str[$size - 1] = '';
            }
    }
//echo ">>" . $str[$size - 1] . "<<";
//echo $_POST['nom'];
$line = explode("\n",$_POST['nom']);
if (isset($_POST['ecart_x']))
    {
        global $ecart_x;
        $ecart_x = $_POST['ecart_x'];
    }
else
    {
        $ecart_x = 45;
    }
if (isset($_POST['ecart_y']))
    {
        global $ecart_y;
        $ecart_y = $_POST['ecart_y'];
    }
else
    {
        $ecart_y = 120;
    }
//echo "toto".$ecart_x." ".$ecart_y."titi<br/>";
//echo $_POST['contraste'];
//echo $_POST['nom'];
$names = array();
$groupes = array();
$i = 0;
foreach($line as $tl)
    {
        //echo $tl . "<br/>";
        if (strlen($tl) != 0)
            {
                $tab_line = explode("|", $tl);
                $names[$i] = $tab_line[0];
                $groupes[$i] = $tab_line[1];
                //echo $names[$i]."<br/>".$groupes[$i];
                $i++;
            }
    }
//print_r($names);
//echo "<br/>";
//print_r($groupes);
$cont = $_POST['contraste'] == '' ? 0 : $_POST['contraste'];
$bright = $_POST['brightness'] == '' ? 0 : $_POST['brightness'];
$red = $_POST['red'] == '' ? 255 : $_POST['red'];
$green = $_POST['green'] == '' ? 255 : $_POST['green'];
$blue = $_POST['blue'] == '' ? 255 : $_POST['blue'];
//echo "red :".$red."\ngreen :".$green."\nblue :".$blue."\n";
$i = 0;
$k = 0;
$nb = count($names);
echo "<ul>";
while ($i < $nb)
    {
        if (($i + $_POST['rows'] * $_POST['cols']) < $nb)
            {
                $end = $i + $_POST['rows'] * $_POST['cols'];
            }
        else
            {
                $end = $nb;
            }
        if ($i > 0)
            {
                echo "<hr/>";
            }
        //print_r($groupes);
        //echo $_POST['box'];
        //echo "gen_planche.php?groupes=".serialize($groupes)."&names=".serialize($names)."&bright=".$bright."&red=".$red."&green=".$green."&blue=".$blue."&ecart_x=".$ecart_x."&ecart_y=".$ecart_y."&cont=".$cont."&i=".$i."&nb=".$nb."&rows=".$_POST['rows']."&cols=".$_POST['cols']."&gray=".$_POST['gray']."&box=".$_POST['box']."' alt='planche".$k."' name='planche".$k."' title='planche".$k;
        echo "<a location=no href='gen_planche.php?groupes=".serialize($groupes)."&names=".serialize($names)."&bright=".$bright."&red=".$red."&green=".$green."&blue=".$blue."&ecart_x=".$ecart_x."&ecart_y=".$ecart_y."&cont=".$cont."&i=".$i."&nb=".$nb."&rows=".$_POST['rows']."&event=".$event."&date=".$date."&cols=".$_POST['cols']."&gray=".$_POST['gray']."&box=".$_POST['box']."&conso=".$_POST['conso']."' download=\"planche".$k."\">planche".$k."</a>";
        echo "<li><img width=\"300\" src='gen_planche.php?groupes=".serialize($groupes)."&names=".serialize($names)."&bright=".$bright."&red=".$red."&green=".$green."&blue=".$blue."&ecart_x=".$ecart_x."&ecart_y=".$ecart_y."&cont=".$cont."&i=".$i."&nb=".$nb."&rows=".$_POST['rows']."&event=".$event."&date=".$date."&cols=".$_POST['cols']."&gray=".$_POST['gray']."&box=".$_POST['box']."&conso=".$_POST['conso']."' alt='planche".$k."' name='planche".$k."' title='planche".$k."'\></li>";
        $k++;
        $i += $_POST['rows'] * $_POST['cols'];
    }
echo "</ul>";