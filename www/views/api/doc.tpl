<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Documentation API REST/JSON www.adhocmusic.com/api/</title>
</head>

<body>

<div id="conteneur">

<h3>Documentation de l'API AD'HOC</h3>

<p>Cette documentation décrit sommairement l'utilisation de l'api AD'HOC que vous pourrez utiliser pour alimenter votre
site web en exploitant les contenus du site AD'HOC</p>
<p>L'url de l'API est la suivante : <strong>http://www.adhocmusic.com/api/ + action + .json</strong></p>
<p>Cette url reçoit des paramètres en <strong>HTTP GET</strong></p>
<p>Le format de sortie est le <strong>json</strong></p>
<p>L'encodage de caractères de la réponse est <strong>utf-8</strong></p>

<h4>Liste des actions disponibles</h4>

<ul>
  <li>
    <h5>audios</h5>
    <p>paramètres : groupe, event, lieu, contact, debut, limit, sort</p>
    <p>Récupère une liste de contenus audios</p>
  </li>
  <li>
    <h5>videos</h5>
    <p>paramètres : groupe, event, lieu, contact, debut, limit, sort</p>
    <p>Récupère une liste de contenus vidéos</p>
  </li>
  <li>
    <h5>photos</h5>
    <p>paramètres : groupe, event, lieu, contact, debut, limit, sort</p>
    <p>Récupère une liste de contenus photos</p>
  </li>
  <li>
    <h5>events</h5>
    <p>paramètres : groupe, lieu, datdeb, datfin, debut, limit, sort</p>
    <p>Récupère une liste de contenus événements</p>
  </li>
</ul>

<p>groupe, lieu, debut, limit, event, contact sont des numériques</p>
<p>datdeb et datfin sont au format 'yyyy-mm-dd'</p>
<p>sort peut prendre la valeur id ou created_on</p>
<p>sens peut prendre la valeur ASC ou DESC</p>
 
<h4>Classe cliente PHP</h4>

<p>Si vous utilisez php comme langage de programmation, nous vous recommandons l'utilisation de cette classe afin de faciliter vos requêtes</p>

<div>{$source_client}</div>

<h5>Exemple d'utilisation côté serveur en php</h5>

<pre>
<code>
require_once "AdhocClientApi.class.php";

$photos = AdHocClientApi::query(
    array(
        'action' =&gt; 'photos',
        'groupe' =&gt; 'id_de_mon_groupe'
        'limit'  =&gt; '20',
    )
);

var_dump($photos);
</code>
</pre>

<p>Ex de requête http get : http://www.adhocmusic.com/api/events.json?groupe=7&amp;limit=5</p>

<p>En cas de difficultés, n'hésitez pas à <a href="http://www.adhocmusic.com/contact">prendre contact avec nous</a></p>

<p>Vous pouvez aussi tester notre <a href="http://www.adhocmusic.com/api/console">console de debug</a></p>

<h5>Exemple d'utilisation côté client en javascript/jquery</h5>

<pre>
<code>
{capture name='html' assign='html'}
<html>
  <head>
    <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>          
  </head>
  <body>
    <script>                                         
    $(function() {
      // récupérer et afficher 3 photos du groupe polar polar polar polar
      $.getJSON('http://www.adhocmusic.com/api/photos.json?groupe=801&limit=3', function(data) {
        var items = [];
        $.each(data, function(idx, photo) {
          items.push('<li><img src="' + photo.thumb_80_80 + '" alt="' + photo.name + '" /></li>');
        });
        $('<ul/>', {
          html: items.join('')
        }).appendTo('body');
      });
    });
    </script>
  </body>
</html>
{/capture}
{$html|escape}
</code>
</pre>

</div> {* conteneur *}

</body>

</html>
