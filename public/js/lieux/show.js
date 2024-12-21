/* global document, jQuery, Masonry, imagesLoaded, baguetteBox, L, asv */

jQuery(document).ready(function () {

  'use strict';

  let map = L.map('map_canvas').setView([asv.lat, asv.lng], 13);
  L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
    attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
    minZoom: 1,
    maxZoom: 20
  }).addTo(map);
  let pin = L.icon({
    iconUrl: '/img/pin/note.png',
    conSize: [32, 32],
    iconAnchor: [25, 50],
    popupAnchor: [-3, -76],
  });
  L.marker([asv.lat, asv.lng], { icon: pin }).addTo(map);

  if (document.getElementsByClassName('gallery').length > 0) {

    let gallery = new Masonry('.gallery', {
      itemSelector: '.photo',
      fitWidth: true,
      gutter: 20
    });

    imagesLoaded('.gallery', function () {
      gallery.layout();
    });

    baguetteBox.run('.gallery', {
      overlayBackgroundColor: '#141416'
    });

  }

});
