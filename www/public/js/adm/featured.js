/* global document jQuery */

jQuery(document).ready(function ($) {

  'use strict';

  $('#form-featured').submit(function () {
    let valid = true;
    if ($('#title').val().length === 0) {
      $('#error_title').fadeIn();
      valid = false;
    } else {
      $('#error_title').fadeOut();
    }
    if($('#description').val().length === 0) {
      $('#error_description').fadeIn();
      valid = false;
    } else {
      $('#error_description').fadeOut();
    }
    return valid;
  });

});
