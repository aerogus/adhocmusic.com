/* global document, jQuery, window */

jQuery(document).ready(function ($) {

  'use strict';

  $("#photofull").noContext();

  $(document).keydown(function(e) {
    if (e.keyCode == 37) {
       window.location = '{$prev}#p';
       e.preventDefault();
    }
    if (e.keyCode == 39) {
       window.location = '{$next}#p';
       e.preventDefault();
    }
  });

});
