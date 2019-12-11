/*globals jQuery*/

jQuery(document).ready(function ($) {

  'use strict';

  $('#form-lieu-edit').submit(function () {
    var valid = true;
    if ($('#name').val() == '') {
      $('#name').prev('.error').fadeIn();
      valid = false;
    } else {
      $('#name').prev('.error').fadeOut();
    }
    if ($('#id_type').val() == '0') {
      $('#id_type').prev('.error').fadeIn();
      valid = false;
    } else {
      $('#id_type').prev('.error').fadeOut();
    }
    if ($('#address').val() == '') {
      $('#address').prev('.error').fadeIn();
      valid = false;
    } else {
      $('#address').prev('.error').fadeOut();
    }
    if ($('#text').val() == '') {
      $('#text').prev('.error').fadeIn();
      valid = false;
    } else {
      $('#text').prev('.error').fadeOut();
    }
    if ($('#id_country').val() === 'FR' && $('#id_departement').val() === '0') {
      $('#id_departement').prev('.error').fadeIn();
      valid = false;
    } else {
      $('#id_departement').prev('.error').fadeOut();
    }
    if ($('#id_country').val() == 'FR' && $('#id_city').val() == '0') {
      $('#id_city').prev('.error').fadeIn();
      valid = false;
    } else {
      $('#id_city').prev('.error').fadeOut();
    }
    if ($('#id_country').val() == '0') {
      $('#id_country').prev('.error').fadeIn();
      valid = false;
    } else {
      $('#id_country').prev('.error').fadeOut();
    }
    return valid;
  });

});
