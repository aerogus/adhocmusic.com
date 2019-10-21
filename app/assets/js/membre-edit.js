/*globals jQuery, validateEmail*/

jQuery(document).ready(function ($) {

  'use strict';

  $('#form-member-edit').submit(function () {
    var valid = true;
    if ($('#id_city').val().length === 0) {
      $('#id_city').prev('.error').fadeIn();
      valid = false;
    } else {
      $('#id_city').prev('.error').fadeOut();
    }
    if ($('#id_country').val().length === 0) {
      $('#id_country').prev('.error').fadeIn();
      valid = false;
    } else {
      $('#id_country').prev('.error').fadeOut();
    }
    if ($('#email').val().length === 0) {
      $('#email').prev('.error').fadeIn();
      valid = false;
    } else {
      $('#email').prev('.error').fadeOut();
    }
    if ($('#email').val().length !== 0) {
      if (validateEmail($('#email').val()) === 0) {
        $('#email').prev('.error').fadeIn();
        valid = false;
      } else {
        $('#email').prev('.error').fadeOut();
      }
    }
    return valid;
  });

});
