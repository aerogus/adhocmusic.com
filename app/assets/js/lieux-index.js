/*globals jQuery, google*/

jQuery(document).ready(function ($) {

  'use strict';

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
    var image = new google.maps.MarkerImage('/img/pin/note.png',
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
      var bubble_content = '<a href="/lieux/show/' + point.id_lieu + '"><strong style="color: #000000">' + point.name + '</strong></a><br>' + point.address + '<br>' + point.cp + ' ' + point.city;
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