/* global document, jQuery, validateEmail */

jQuery(document).ready(function ($) {

  'use strict';

  $('#check').val($('#form-contact-submit').data('check'));

  $('#form-contact').submit(function () {
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

  $('.faq p').hide();
  $('.faq h3').click((event) => {
    let arrow = $(event.currentTarget).find('i');
    let answer = $(event.currentTarget).parent().find('p');
    if (arrow.hasClass('icon-arrow--right')) {
      arrow.removeClass('icon-arrow--right').addClass('icon-arrow--down');
      answer.show();
    } else {
      arrow.removeClass('icon-arrow--down').addClass('icon-arrow--right');
      answer.hide();
    }
  });

});

