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

  $('#id_country').change(function () {
    var id_country = $('#id_country').val();
    var lieu_id_region = '{$lieu->getIdRegion()}';
    $('#id_region').empty();
    $('<option value="0">---</option>').appendTo('#id_region');
    $.getJSON('/geo/getregion.json', { c:id_country }, function(data) {
      var selected = '';
      $.each(data, function(region_id, region_name) {
        if(lieu_id_region == region_id) { selected = ' selected="selected"'; } else { selected = ''; }
        $('<option value="'+region_id+'"'+selected+'>'+region_name+'</option>').appendTo('#id_region');
      });
      if(id_country != 'FR') {
        $('#id_departement').hide();
        $('#id_city').hide();
      } else {
        $('#id_departement').show();
        $('#id_city').show();
      }
    });
  });

  $('#id_region').change(function () {
    var id_country = $('#id_country').val();
    var lieu_id_region = '{$lieu->getIdRegion()}';
    var id_region = $('#id_region').val();
    var lieu_id_departement = '{$lieu->getIdDepartement()}';
    $('#id_departement').empty();
    $('#id_city').empty();
    if(id_country == 'FR') {
      $('<option value="0">---</option>').appendTo('#id_departement');
      $.getJSON('/geo/getdepartement.json', { r:id_region }, function(data) {
        var selected = '';
        $.each(data, function(departement_id, departement_name) {
          if(lieu_id_departement == departement_id) { selected = ' selected="selected"'; } else { selected = ''; }
          $('<option value="'+departement_id+'"'+selected+'>'+departement_id+' - '+departement_name+'</option>').appendTo('#id_departement');
        });
      });
    }
  });

  $('#id_departement').change(function () {
    var id_country = $('#id_country').val();
    var id_departement = $('#id_departement').val();
    var lieu_id_city = '{$lieu->getIdCity()}';
    $('#id_city').empty();
    if(id_country == 'FR') {
      $('<option value="0">---</option>').appendTo('#id_city');
      $.getJSON('/geo/getcity.json', { d:id_departement }, function(data) {
        var selected = '';
        $.each(data, function(city_id, city_name) {
          if(lieu_id_city == city_id) { selected = ' selected="selected"'; } else { selected = ''; }
          $('<option value="'+city_id+'"'+selected+'>'+city_name+'</option>').appendTo('#id_city');
        });
      });
    }
  });

  $('#id_country').trigger('change');
  $('#id_region').trigger('change');
  $('#id_departement').trigger('change');

});
