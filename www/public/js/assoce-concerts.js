/* global document, jQuery, Masonry, imagesLoaded */

jQuery(document).ready(function () {

  'use strict';

  let galleries = document.getElementsByClassName('gallery');
  let msnry;

  if (galleries.length > 0) {

    let options = {
      itemSelector: '.photo',
      fitWidth: true,
      gutter: 20
    };

    for (let i = 0; i < galleries.length; i++) {
      let gallery_id = '#' + galleries[i].id;
      imagesLoaded(document.querySelector(gallery_id), function () {
        msnry = new Masonry(gallery_id, options);
        msnry.layout();
      });
    }

  }

});
