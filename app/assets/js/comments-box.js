/*globals jQuery, adhoc*/

jQuery(document).ready(function ($) {

  'use strict';

  $('#form-comment-box-write').submit(function () {

    var valid = true;

    if (!adhoc.is_auth) {
      if ($('#form-comment-box-pseudo').val().length === 0) {
        $('#error_pseudo').fadeIn();
        valid = false;
      } else {
        $('#error_pseudo').fadeOut();
      }
      if ($('#form-comment-box-email').val().length === 0) {
        $('#error_email').fadeIn();
        valid = false;
      } else {
        $('#error_email').fadeOut();
      }
      if ($('#form-comment-box-antispam').val() !== 'oui') {
        $('#error_antispam').fadeIn();
        valid = false;
      } else {
        $('#error_antispam').fadeOut();
      }
    }

    if ($('#form-comment-box-text').val().length === 0) {
      $('#error_text').fadeIn();
      valid = false;
    } else {
      $('#error_text').fadeOut();
    }

    return valid;

  });

});
