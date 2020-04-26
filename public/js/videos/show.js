/*global jQuery,Masonry,imagesLoaded,baguetteBox*/

jQuery(document).ready(function () {

  'use strict';

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
