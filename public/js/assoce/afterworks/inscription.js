/* global document, jQuery, validateEmail */

jQuery(document).ready(function ($) {

  'use strict';

  $('#check').val($('#form-afterworks-submit').data('check'));

  $('#form-afterworks').submit(function () {
    let valid = true;
    if ($('#name').val().length === 0) {
      $('#error_name').fadeIn();
      valid = false;
    } else {
      $('#error_name').fadeOut();
    }
    if ($('#email').val().length === 0 || !validateEmail($('#email').val())) {
      $('#error_email').fadeIn();
      valid = false;
    } else {
      $('#error_email').fadeOut();
    }
    if ($('#date').val().length === 0) {
      $('#error_date').fadeIn();
      valid = false;
    } else {
      $('#error_date').fadeOut();
    }
    let selectedHours = false;
    if ($('#h1930-2030').prop('checked')) {
      selectedHours = true;
    }
    if ($('#h2030-2130').prop('checked')) {
      selectedHours = true;
    }
    if ($('#h2130-2230').prop('checked')) {
      selectedHours = true;
    }
    if (!selectedHours) {
      $('#error_hour').fadeIn();
      valid = false;
    } else {
      $('#error_hour').fadeOut();
    }
    return valid;
  });

});

