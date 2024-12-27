/* global document, jQuery */

jQuery(document).ready(function ($) {

  'use strict';

  $('.toggle').hover(function () {
    let toggle_id = $(this).attr('id').replace('toggle_', '');
    $('#msg_' + toggle_id).toggle();
  });
  $('.thread-avatar').hover(function () {
    $(this).addClass('thread-avatar-full');
  }, function() {
    $(this).removeClass('thread-avatar-full');
  });

});
