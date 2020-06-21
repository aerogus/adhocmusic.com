/*globals jQuery,Masonry,imagesLoaded,baguetteBox,L,asv */

jQuery(document).ready(function () {

  'use strict';

  var map = L.map('map_canvas').setView([asv.lat, asv.lng], 13);
  var marker = L.marker([asv.lat, asv.lng]).addTo(map);

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
