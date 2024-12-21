/* global document, jQuery */

jQuery(document).ready(function ($) {

  'use strict';

  $('.event_title').hover(function () {
    $(this).children('.edit-event').show();
  }, function () {
    $(this).children('.edit-event').hide();
  });

});
