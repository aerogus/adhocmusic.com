/* global document, jQuery, Masonry, imagesLoaded */

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

  }

});