/*globals jQuery,Masonry,imagesLoaded*/

jQuery(document).ready(function () {

  'use strict';

  var galleries = document.getElementsByClassName('gallery');
  var msnry;

  if (galleries.length > 0) {

    var options = {
      itemSelector: '.photo',
      fitWidth: true,
      gutter: 20
    };

    for (var i = 0; i < galleries.length; i++) {
      let gallery_id = '#' + galleries[i].id;
      imagesLoaded(document.querySelector(gallery_id), function () {
        msnry = new Masonry(gallery_id, options);
        msnry.layout();
      });
    }

  }

});
