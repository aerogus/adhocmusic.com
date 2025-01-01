/* global document, jQuery */

jQuery(document).ready(function ($) {

  'use strict';

  $('#form-groupe-create').submit(function () {
    let valid = true;
    if ($('#name').val().length === 0) {
      $('#error_name').fadeIn();
      valid = false;
    } else {
      $('#error_name').fadeOut();
    }
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
    if ($('#id_type_musicien').val() === '1') {
      $('#error_id_type_musicien').fadeIn();
      valid = false;
    } else {
      $('#error_id_type_musicien').fadeOut();
    }
    return valid;
  });
});
