/*global jQuery,validateEmail*/

jQuery(document).ready(function ($) {

  'use strict';

  $('#check').val($('#form-contact-submit').data('check'));

  $('#form-contact').submit(function () {
    var valid = true;
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
    if ($('#subject').val().length === 0) {
      $('#error_subject').fadeIn();
      valid = false;
    } else {
      $('#error_subject').fadeOut();
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

