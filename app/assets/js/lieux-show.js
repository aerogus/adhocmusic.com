/*globals lieu_lat, lieu_lng, lieu_name */

function adhocLieuInitMap()
{
  var center = new google.maps.LatLng({lat: lieu_lat, lng: lieu_lng});
  var map = new google.maps.Map(document.getElementById("map_canvas"), {
    zoom: 15,
    center: center,
    mapTypeId: google.maps.MapTypeId.HYBRID,
    disableDefaultUI: true
  });
  var image = new google.maps.MarkerImage('/img/pin/note.png',
    new google.maps.Size(32, 32), // taille
    new google.maps.Point(0,0),   // origine
    new google.maps.Point(16, 16)  // ancre
  );
  var marker = new google.maps.Marker({
    position: center,
    map: map,
    icon: image,
    title: lieu_name
  });
};
