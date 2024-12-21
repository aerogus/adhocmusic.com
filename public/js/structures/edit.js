/* global document, jQuery */

jQuery(document).ready(function ($) {

  'use strict';

  $('#form-structure-edit').submit(function () {
    let valid = true;
    if ($('#name').val().length === 0) {
      $('#name').prev('.error').fadeIn();
      valid = false;
    } else {
      $('#name').prev('.error').fadeOut();
    }
    return valid;
  });

});
