/* global document, jQuery */

jQuery(document).ready(function ($) {

  'use strict';

  $('#form-login').submit(function () {
    let valid = true;
    if (!$('#login-pseudo').val().length) {
      $('#login-pseudo').prev('.error').fadeIn();
      valid = false;
    } else {
      $('#login-pseudo').prev('.error').fadeOut();
    }

    if (!$('#login-password').val().length) {
      $('#login-password').prev('.error').fadeIn();
      valid = false;
    } else {
      $('#login-password').prev('.error').fadeOut();
    }
    return valid;
  });

});
