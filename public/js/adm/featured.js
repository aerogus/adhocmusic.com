/*globals jQuery*/

jQuery(document).ready(function ($) {

  'use strict';

  $('#datdeb, #datfin').datepicker({
    dateFormat: 'yy-mm-dd',
    showAnim: 'slideDown'
  });

  $('#form-featured-create, #form-featured-edit').submit(function () {
    var valid = true;
    if ($('#title').val().length === 0) {
      $('#error_title').fadeIn();
      valid = false;
    } else {
      $('#error_title').fadeOut();
    }
    if($('#description').val().length === 0) {
      $('#error_description').fadeIn();
      valid = false;
    } else {
      $('#error_description').fadeOut();
    }
    return valid;
  });

});
