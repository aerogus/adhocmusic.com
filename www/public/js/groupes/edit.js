/* global document, jQuery */

jQuery(document).ready(function ($) {

  'use strict';

  $('#form-groupe-edit').submit(function () {
    let valid = true;
    if ($('#style').val().length === 0) {
      $('#error_style').fadeIn();
      valid = false;
    } else {
      $('#error_style').fadeOut();
    }
    if ($('#lineup').val().length === 0) {
      $('#error_lineup').fadeIn();
      valid = false;
    } else {
      $('#error_lineup').fadeOut();
    }
    if ($('#mini_text').val().length === 0 || $('#mini_text').val().length > 255) {
      $('#error_mini_text').fadeIn();
      valid = false;
    } else {
      $('#error_mini_text').fadeOut();
    }
    if ($('#text').val().length === 0) {
      $('#error_text').fadeIn();
      valid = false;
    } else {
      $('#error_text').fadeOut();
    }
    return valid;
  });

});
