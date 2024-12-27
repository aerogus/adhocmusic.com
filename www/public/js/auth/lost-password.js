/* global document, jQuery, validateEmail */

jQuery(document).ready(function ($) {

  'use strict';

  $('#form-lost-password').submit(function() {
    let valid = true;
    if($('#email').val().length === 0) {
      $('#email').prev('.error').fadeIn();
      valid = false;
    } else {
      $('#email').prev('.error').fadeOut();
    }

    if($('#email').val().length !== 0) {
      if(!validateEmail($('#email').val())) {
        $('#email').prev('.error').fadeIn();
        valid = false;
      } else {
        $('#email').prev('.error').fadeOut();
      }
    }
    return valid;
  });

});