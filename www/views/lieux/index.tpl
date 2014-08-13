{include file="common/header.tpl"}

<script>

$(function() {

  var center = new google.maps.LatLng({$my_geocode});
  var map = new google.maps.Map(document.getElementById("map_canvas"), {
    zoom: 14,
    center: center,
    mapTypeId: google.maps.MapTypeId.HYBRID,
    disableDefaultUI: true
  });

  google.maps.event.addListenerOnce(map, 'bounds_changed', function() {
    placePoints(this);
  });
  google.maps.event.addListener(map, 'dragend', function() {
    placePoints(this);
  });
  google.maps.event.addListener(map, 'zoom_changed', function() {
    placePoints(this);
  });

  $('#id_region').keypress(function() {
    $('#id_region').trigger('change');
  });

  $('#id_departement').keypress(function() {
    $('#id_departement').trigger('change');
  });

  $('#id_region').empty();
  $('<option value="0">---</option>').appendTo('#id_region');
  $.getJSON('/geo/getregion.json', { c:'fr' }, function(data) {
    $.each(data, function(region_id, region_name) {
      $('<option value="'+region_id+'">'+region_name+'</option>').appendTo('#id_region');
    });
  });

  $('#id_region').change(function() {
    var id_region = $('#id_region').val();
    $('#id_departement').empty();
    $('<option value="0">---</option>').appendTo('#id_departement');
    $.getJSON('/geo/getdepartement.json', { r:id_region }, function(data) {
      $.each(data, function(departement_id, departement_name) {
        $('<option value="'+departement_id+'">'+departement_id+' - '+departement_name+'</option>').appendTo('#id_departement');
      });
    });
  });

  $('#id_departement').change(function() {
    var id_departement = $('#id_departement').val();
    var geocoder = new google.maps.Geocoder();
    var address = $('#id_region>option:selected').text() + ' ' + $('#id_departement>option:selected').text();
    geocoder.geocode( { 'address': address }, function (results, status) {
      if(status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
        map.setZoom(8);
      } else {
        alert('error : ' + status);
      }
    });

    $.get('/lieux/fetch.json', {
      mode: 'admin',
      lat: {$lat},
      lng: {$lng},
      limit: 50,
      id_country: 'FR',
      id_region: $('#id_region').val(),
      id_departement: $('#id_departement').val()
    }, function(points) {
      $('#search-results').show();
      $('#search-results > tbody').empty();
      $.each(points, function(i, point) {
        $('<tr><td><a href="/lieux/show/' + point.id_lieu + '">' + point.name + '</a></td><td>' + point.address + '</td><td>' + point.cp + '</td><td>' + point.city + '</td><td>à ' + point.distance + ' km</td></tr>').appendTo('#search-results > tbody');
      });
    });
  });

});

var markers = [];
var infoWindow = new google.maps.InfoWindow();

function showBubble(map, marker, content) {
  google.maps.event.addListener(marker, 'click', function() {
    infoWindow.setContent(content)
    infoWindow.open(map, marker);
  });
}

function showResults() {
}

function placePoints(map) {
  $.get('/lieux/fetch.json', {
    mode: 'boundary',
    lat: {$lat},
    lng: {$lng},
    points: map.getBounds().toUrlValue(),
    limit: 100
  }, function(points) {
    clearPoints();
    $('#search-results').show();
    $('#search-results > tbody').empty();
    var image = new google.maps.MarkerImage('{#STATIC_URL#}/img/pin/note.png',
      new google.maps.Size(32, 32), // taille
      new google.maps.Point(0,0),   // origine
      new google.maps.Point(16, 16)  // ancre
    );
    $.each(points, function(i, point) {
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(point.lat, point.lng),
        map: map,
        icon: image,
        title: point.name
      });
      markers.push(marker);
      var bubble_content = '<a href="/lieux/show/' + point.id_lieu + '"><strong style="color: #000000">' + point.name + '</strong></a><br />' + point.address + '<br />' + point.cp + ' ' + point.city;
      showBubble(map, marker, bubble_content);
      $('<tr><td><a href="/lieux/show/' + point.id_lieu + '">' + point.name + '</a></td><td>' + point.address + '</td><td>' + point.cp + ' - ' + point.city + '</td><td>à ' + point.distance + ' km</td></tr>').appendTo('#search-results > tbody');
    });
  });
}

function clearPoints()
{
  for (i in markers) {
    markers[i].setMap(null);
  }
  markers.length = 0;
}

</script>

<div id="left">

{include file="common/boxstart.tpl" boxtitle="Proche de chez vous"}
{foreach from=$lieux item=lieu}
<div style="margin 5px; padding: 5px">
  <a href="/lieux/show/{$lieu.id_lieu}"><strong>{$lieu.name|escape}</strong></a><br />
  <em>{$lieu.city|escape}</em><br />
  (à {$lieu.distance} km)
</div>
{/foreach}
</table>
{include file="common/boxend.tpl"}

{if !empty($comments)}
{include file="common/boxstart.tpl" boxtitle="Derniers commentaires"}
<ul>
  {foreach from=$comments item=comment}
  <li style="margin-bottom: 5px;">
    <strong>{$comment.pseudo}</strong> le {$comment.created_on|date_format:'%d/%m/%Y'}<br />
    <a href="/{$comment.type_full}/show/{$comment.id_content}">{$comment.text|truncate:'200'}</a>
  </li>
  {/foreach}
</ul>
{include file="common/boxend.tpl"}
{/if}

</div>

<div id="center-right">

{include file="common/boxstart.tpl" boxtitle="Lieux de diffusion"}

<form id="form-lieu-search" name="form-lieu-search">
  <legend>Chercher un lieu</legend>
   <fieldset>
    <ol>
      <li>
        <select id="id_region" name="id_region" style="float: right;">
          <option value="0">--------</option>
        </select>
        <label for="id_region">Région</label>
      </li>
      <li>
        <select id="id_departement" name="id_departement" style="float: right;">
          <option value="0">--------</option>
        </select>
        <label for="id_departement">Département</label>
      </li>
    </ol>
  </fieldset>
</form>

<div id="map_canvas" style="width: 690px; height: 320px;"></div>

<table id="search-results" style=" width: 690px; display: none">
  <thead>
    <tr>
      <th>Nom</th>
      <th>Adresse</th>
      <th>Ville</th>
      <th>Distance</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>

{include file="common/boxend.tpl"}

</div>

{include file="common/footer.tpl"}
