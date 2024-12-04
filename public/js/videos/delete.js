/* globals document, jQuery, window */

jQuery(document).ready(function ($) {

  'use strict';

  $('#form-video-delete').submit(function () {
    return window.confirm('Confirmer la suppression de cette vidéo ?');
  });

});
