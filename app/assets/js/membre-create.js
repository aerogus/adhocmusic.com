/*globals jQuery, validateEmail */

jQuery(document).ready(function ($) {

  'use strict';

  $('#email').blur(function () {
    $('#email').removeClass('valid error');
    $('#error_email').fadeOut();
    $('#error_invalid_email').fadeOut();
    $('#error_already_member').fadeOut();
    if ($(this).val().length > 2) {
      // check existence email
      var email = $('#email').val();
      $.getJSON('/auth/check-email.json', {
        email: email
      }, function (data) {
        if (data.status === 'KO_INVALID_EMAIL') {
          $('#error_invalid_email').fadeIn();
          $('#email').addClass('error');
        } else if (data.status === 'KO_ALREADY_MEMBER') {
          $('#error_already_member').fadeIn();
          $('#email').addClass('error');
        } else {
          $('#email').addClass('valid');
        }
      });
    } else {
      $('#error_email').fadeIn();
      $('#email').addClass('error');
    }
  });

  $('#pseudo').blur(function () {
    $('#pseudo').removeClass('valid error');
    $('#error_pseudo').fadeOut();
    $('#error_pseudo_unavailable').fadeOut();
    if ($(this).val().length > 2) {
      // check dispo du pseudo
      var pseudo = $('#pseudo').val();
      $.getJSON('/auth/check-pseudo.json', {
        pseudo: pseudo
      }, function (data) {
        if (data.status === 'KO_PSEUDO_UNAVAILABLE') {
          $('#error_pseudo_unavailable').fadeIn();
          $('#pseudo').addClass('error');
        } else {
          $('#pseudo').addClass('valid');
        }
      });
    } else {
      $('#error_pseudo').fadeIn();
      $('#pseudo').addClass('error');
    }
  });

  $('#first_name').blur(function () {
    $('#first_name').removeClass('valid error');
    $('#error_first_name').fadeOut();
    if ($(this).val().length > 2) {
      $('#first_name').addClass('valid');
    } else {
      $('#error_first_name').fadeIn();
      $('#first_name').addClass('error');
    }
  });

  $('#last_name').blur(function () {
    $('#last_name').removeClass('valid error');
    $('#error_last_name').fadeOut();
    if ($(this).val().length > 2) {
      $('#last_name').addClass('valid');
    } else {
      $('#error_last_name').fadeIn();
      $('#last_name').addClass('error');
    }
  });

  $('#form-member-create').submit(function () {
    var validate = true;
    if ($('#email').val().length === 0 || validateEmail($('#email').val()) === 0) {
      $('#email').prev('.error').fadeIn();
      validate = false;
    } else {
      $('#email').prev('.error').fadeOut();
    }
    if ($('#pseudo').val().length === 0) {
      $('#pseudo').prev('.error').fadeIn();
      validate = false;
    } else {
      $('#pseudo').prev('.error').fadeOut();
    }
    if ($('#last_name').val().length === 0) {
      $('#last_name').prev('.error').fadeIn();
      validate = false;
    } else {
      $('#last_name').prev('.error').fadeOut();
    }
    if ($('#first_name').val().length === 0) {
      $('#first_name').prev('.error').fadeIn();
      validate = false;
    } else {
      $('#first_name').prev('.error').fadeOut();
    }
    return validate;
  });

});
