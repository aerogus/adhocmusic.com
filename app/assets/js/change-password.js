/*global jQuery*/

jQuery(document).ready(function ($) {

  'use strict';

  $('#form-password-change').submit(function () {
    var valid = true;
    if ($('#password_old').val().length === 0) {
      $('#error_password_old').fadeIn();
      valid = false;
    } else {
      $('#error_password_old').fadeOut();
    }
    if ($('#password_new_1').val().length === 0) {
      $('#error_password_new_1').fadeIn();
      valid = false;
    } else {
      $('#error_password_new_1').fadeOut();
    }
    if ($('#password_new_2').val().length === 0) {
      $('#error_password_new_2').fadeIn();
      valid = false;
    } else {
      $('#error_password_new_2').fadeOut();
    }
    if ($('#password_new_1').val() !== $('#password_new_2').val()) {
      $('#error_password_new_check').fadeIn();
      valid = false;
    } else {
      $('#error_password_new_check').fadeOut();
    }
    return valid;
  });

});
