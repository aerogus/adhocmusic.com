<?php
/**
 * this script creates the badges thanks to a txt file.
 *
 * @package adhoc
 * @author Taddei Gilles <gilles.taddei@gmail.com>
 * @brief This script calls "gen_planch" with a file filing it.
 */

//require_once "genplanche.php";
require_once "planch_creator.php";
header('Content-Type: text/html; charset=utf-8');

echo "<!DOCTYPE html>\n";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\"/>\n";
echo "<SCRIPT LANGUAGE=Javascript SRC=\"http://code.jquery.com/jquery-1.9.0.js\"> </SCRIPT>\n";
echo "<SCRIPT LANGUAGE=Javascript SRC=\"fonctions.js\"> </SCRIPT>\n";
echo "<SCRIPT LANGUAGE=Javascript SRC=\"jquery-1.9.0.js\"> </SCRIPT>\n";
echo "<script LANGUAGE=Javascript>\n

function change_badge(){
           date_ = document.getElementById('date').value == '' ? '1970-01-01' : document.getElementById('date').value;
           //var date_fr = Date.parse(date_);
           //date_fr.formatDate('dd-mm-yyyy', date_fr);
           //alert(date_fr.toString('dd-mm-yyyy'));
           //alert(date_);
           event_ = document.getElementById('event').value == '' ? 'AdHoc' : document.getElementById('event').value;
           gray_checked = document.getElementById('gray').checked ? 1 : 0;
           box_checked = document.getElementById('box').checked ? 1 : 0;
           red_ = document.getElementById('red').value == '' ? 0 : document.getElementById('red').value;
           green_ = document.getElementById('green').value == '' ? 0 : document.getElementById('green').value;
           blue_ = document.getElementById('blue').value == '' ? 0 : document.getElementById('blue').value;
           cont_ = document.getElementById('contrast').value == '' ? 0 : document.getElementById('contrast').value;
           bright_ = document.getElementById('brightness').value == '' ? 0 : document.getElementById('brightness').value;
           conso_ = document.getElementById('conso').value == '' ? 0 : document.getElementById('conso').value;
           band_ = document.getElementById('band').value == '' ? 'lorem ipsum' : document.getElementById('band').value;
           name_ = document.getElementById('name_fake').value == '' ? 'dolor' : document.getElementById('name_fake').value;

           pos_name_ = document.getElementById('pos_name').value == '' ? '0' : document.getElementById('pos_name').value;
           pos_event_ = document.getElementById('pos_event').value == '' ? '25' : document.getElementById('pos_event').value;
           pos_band_ = document.getElementById('pos_band').value == '' ? '100' : document.getElementById('pos_band').value;
           $.ajax({
              type:'POST',
              url:'badge.php',
              data: {nom: document.getElementById('name').value,
                     cont: cont_,
                     bright: bright_,
                     red: red_,
                     green: green_,
                     blue: blue_,
                     gray: gray_checked,
                     box: box_checked,
                     band: band_,
                     name: name_,
                     conso: conso_,
                     event: event_,
                     date: date_,
                     pos_event: pos_event_,
                     pos_name: pos_name_,
                     pos_band: pos_band_},
              success: function(data){
                //alert(data);
                document.getElementById(\"badge\").innerHTML = data;

           },
           error: function(xhr, textStatus, error){
               alert('fail');
               console.log(xhr.statusText);
               console.log(textStatus);
               console.log(error);
           }
          });
}

$(document).ready(function(){
    change_badge();
    $(\"#button\").click(function() {
      //alert(document.getElementById(\"name\").value);
           date_ = document.getElementById('date').value == '' ? '1970-01-01' : document.getElementById('date').value;
           event_ = document.getElementById('event').value == '' ? 'AdHoc' : document.getElementById('event').value;
           gray_checked = document.getElementById('gray').checked ? 1 : 0;
           box_checked = document.getElementById('box').checked ? 1 : 0;
           conso_ = document.getElementById('conso').value == '' ? 0 : document.getElementById('conso').value;
           pos_name_ = document.getElementById('pos_name').value == '' ? '0' : document.getElementById('pos_name').value;
           pos_event_ = document.getElementById('pos_event').value == '' ? '25' : document.getElementById('pos_event').value;
           pos_band_ = document.getElementById('pos_band').value == '' ? '100' : document.getElementById('pos_band').value;
           $.ajax({
              type:'POST',
              url:'planche.php',
              data: {nom: document.getElementById('name').value,
                     contraste: document.getElementById('contrast').value,
                     brightness: document.getElementById('brightness').value,
                     red: document.getElementById('red').value,
                     green: document.getElementById('green').value,
                     blue: document.getElementById('blue').value,
                     cols: document.getElementById('cols').value,
                     rows: document.getElementById('rows').value,
                     ecart_x: document.getElementById('ecart_x').value,
                     ecart_y: document.getElementById('ecart_y').value,
                     gray: gray_checked,
                     box: box_checked,
                     date: date_,
                     event: event_,
                     conso: conso_,
                     pos_event: pos_event_,
                     pos_name: pos_name_,
                     pos_band: pos_band_},
              success: function(data){
                //alert(data);
                document.getElementById(\"change\").innerHTML = data;
           },
           error: function(xhr, textStatus, error){
               alert('fail');
               console.log(xhr.statusText);
               console.log(textStatus);
               console.log(error);
           }
          });
    return false;
  });
});
</script>";


$names = array();
$groupes = array();

//$file = file_get_contents("list.txt");
if ($fd = fopen ("list.txt", "r") AND $fd2 = fopen ("list_base.txt", "r"))
    {
        echo "<body id=\"global\"><div class=\"zone_texte\">
              <FORM method=\"post\" name=\"list\" action=\"\">
              <table>

              <tr><td colspan = '2'><TEXTAREA id=\"name\" name=\"nom\" rows=20 cols=34>";
        $i = 0;

        while(!feof($fd2))
            {
                $line = fgets($fd2, 255);
                $tab_line = explode('|', $line);
                //list($names[$i], $groupes[$i]) = explode('|', $line);
                if(strcmp($line,""))
                    {
                        echo $line;
                    }
            }

        while(!feof($fd))
            {
                $line = fgets($fd, 255);
                $tab_line = explode('|', $line);
                //list($names[$i], $groupes[$i]) = explode('|', $line);
                if(strcmp($line,""))
                    {
                        echo $line;
                    }
            }

        echo "</TEXTAREA></tr>
              <tr><td><label for='event'>Évènement :</label></td>
              <td><input type='text' onchange=\"change_badge()\" name='event' id='event' value='FetEstival'/></td></tr>
              <tr><td><label for='date'>Date de celui-ci :</label></td>
              <td><input type='text' onchange=\"change_badge()\" name='date' id='date' value='29-06-2013'/></td></tr>

              <tr><td><label for='pos_name'>Position du nom :</label></td>
              <td><input type='text' onchange=\"change_badge()\" name='pos_name' id='pos_name' value='0'/></td></tr>
              <tr><td><label for='pos_event'>Position de l'évènement :</label></td>
              <td><input type='text' onchange=\"change_badge()\" name='pos_event' id='pos_event' value='25'/></td></tr>
              <tr><td><label for='pos_band'>Position du groupe :</label></td>
              <td><input type='text' onchange=\"change_badge()\" name='pos_band' id='pos_band' value='100'/></td></tr>

              <tr><td><label for='red'>Composante rouge :(0 - 255)</label></td>
              <td><input type='text' onchange=\"change_badge()\" name='red' id='red' value='255'/></td></tr>
              <tr><td><label for='green'>Composante verte :(0 - 255)</label></td>
              <td><input type='text' onchange=\"change_badge()\" name='green' id='green' value='255'/></td></tr>
              <tr><td><label for='blue'>Composante bleue :(0 - 255)</label></td>
              <td><input type='text' onchange=\"change_badge()\" name='blue' id='blue' value='255'/></td></tr>
              <tr><td><label for='contrast'>Contraste : (+/- x)</label></td>
              <td><input type='text' onchange=\"change_badge()\" name='contrast' id='contrast' value='0'/></td></tr>
              <tr><td><label for='brightness'>Luminosité : </label></td>
              <td><input type='text' onchange=\"change_badge()\" name='brightness' id='brightness' value=''/></td></tr>

              <tr><td><label for='ecart_x'>Ecart colonnes :</label></td>
              <td><input type='text' name='ecart_x' id='ecart_x' value='45'/></td></tr>

              <tr><td><label for='ecart_y'>Ecart lignes : </label></td>
              <td><input type='text' name='ecart_y' id='ecart_y' value='100'/></td></tr>
              <tr><td><label for='conso'>nb conso :</label></td><td><input type='text' onchange=\"change_badge()\" name='conso' id='conso' value='0'/></td></tr>

              <tr><td><label for='gray'> Niveaux de Gris</label></td>
              <td><input type='checkbox' onchange=\"change_badge()\" name='gray' id='gray' /></td></tr>
              
              <tr><td><label for='box'> Case blanche ?</label></td>
              <td><input type='checkbox' onchange=\"change_badge()\" checked='checked' name='box' id='box' /></td></tr>
              <tr><td colspan='2'><input id='button' type=\"submit\" value=\"Go\" return=\"false\"/></td>
              <tr><td><label for='band'> Groupe fictif :</label></td>
              <td><input type='text' onchange=\"change_badge()\" name='band' id='band' value='lorem ipsum'/></td></tr>

              <tr><td><label for='name_fake'> Nom fictif :</label></td>
              <td><input type='text' onchange=\"change_badge()\" name='name_fake' id='name_fake' value='Dolor'/></td></tr>

              <tr><td><label for='cols'><!--nb colonnes :--></label></td><td><input type='hidden' name='cols' id='cols' value='5'/></td></tr>

              <tr><td><label for='rows'><!--nb lignes :--></label></td><td><input type='hidden' name='rows' id='rows' value='4'/></td></tr>
              </table></FORM></div>";
    }
else
    {
        echo "fail ouverture";
        exit;
    }

echo "<div class=\"explain\">(Cachez ces apostrophes que je ne saurais voir !)<br/><br/>Pour ajouter un badge, saisissez le nom et le groupe séparés par un caractère '|'.<br/><br/>cliquez sur Go une fois les modifications effectuées, puis attendez. Les planches apparaitront à droite.<br/>Vous n'aurez plus qu'à les enregistrer.<br/><br/> ROCK ON !";
echo "<div id=\"badge\" class=\"badge\"></div></div>";
echo "<div id=\"change\" class=\"change\"></div>";
echo "</body>";
