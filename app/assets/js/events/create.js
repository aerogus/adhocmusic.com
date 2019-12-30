/*globals jQuery*/

jQuery(document).ready(function ($) {

  'use strict';

  $('#date').datepicker({
    dateFormat: 'dd/mm/yy',
    showAnim: 'slideDown'
  });

  $('#form-event-create').submit(function () {
    var valid = true;
    if ($('#name').val().length === 0) {
      $('#error_name').fadeIn();
      valid = false;
    } else {
      $('#error_name').fadeOut();
    }
    if ($('#id_lieu').val() === '0') {
      $('#error_id_lieu').fadeIn();
      valid = false;
    } else {
      $('#error_id_lieu').fadeOut();
    }
    if ($('#text').val().length === 0) {
      $('#error_text').fadeIn();
      valid = false;
    } else {
      $('#error_text').fadeOut();
    }
    if ($('#price').val().length === 0) {
      $('#error_price').fadeIn();
      valid = false;
    } else {
      $('#error_price').fadeOut();
    }
    return valid;
  });

});
