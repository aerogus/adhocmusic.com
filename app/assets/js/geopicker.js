/**
 * Composant de formulaire composé des champs geographiques suivants :
 * - choix du pays : liste déroulante #id_country
 * - choix de la région : liste déroulante #id_region
 * - choix du département (si FR) : liste déroulante #id_departement
 * - choix de la ville (si FR) : liste déroulante #id_city
 * - choix du lieu (pour events uniquement)
 *
 * utilisé dans création/modif d'un membre, d'un lieu, d'un événement
 */

/*globals jQuery,asv*/

jQuery(document).ready(function ($) {

  'use strict';

  $('#id_country, #id_region, #id_departement, #id_city').keypress(function () {
    $(this).trigger('change');
  });

  /**
   * chargement des pays
   */
  $.getJSON('/geo/countries.json', function (data) {
    $.each(data, function (country_id, country_name) {
      $('<option/>', {
        value: country_id,
        text: country_name
      }).appendTo('#id_country');
    });
    if (asv.id_country) {
      $('#id_country option[value="' + asv.id_country + '"]').prop('selected', true);
      $('#id_country').trigger('change');
      asv.id_country = false;
    }
  });

  /**
   * la sélection du pays charge la liste des régions
   */
  $('#id_country').change(function () {
    var id_country = $(this).find('option:selected').val();
    $.getJSON('/geo/regions/' + id_country + '.json', function (data) {
      $('#id_region, #id_departement, #id_city, #id_lieu').empty();
      $.each(data, function (region_id, region_name) {
        $('<option/>', {
          value: region_id,
          text: region_name
        }).appendTo('#id_region');
      });
      if (asv.id_region) {
        $('#id_region option[value="' + asv.id_region + '"]').prop('selected', true);
        $('#id_region').trigger('change');
        asv.id_region = false;
      }
    });
    if (id_country !== 'FR') {
      $('#id_departement, #id_city').hide();
    } else {
      $('#id_departement, #id_city').show();
    }
  });

  /**
   * la sélection de la région charge la liste des départements
   */
  $('#id_region').change(function () {
    var id_country = $('#id_country').find('option:selected').val();
    var id_region = $(this).find('option:selected').val();
    if (id_country === 'FR') {
      $.getJSON('/geo/departements.json', {
        r: id_region
      }, function (data) {
        $('#id_departement, #id_city, #id_lieu').empty();
        $.each(data, function (departement_id, departement_name) {
          $('<option/>', {
            value: departement_id,
            text: departement_name
          }).appendTo('#id_departement');
        });
        if (asv.id_departement) {
          $('#id_departement option[value="' + asv.id_departement + '"]').prop('selected', true);
          $('#id_departement').trigger('change');
          asv.id_departement = false;
        }
      });
    }
  });

  /**
   * la sélection du département charge la liste des villes
   */
  $('#id_departement').change(function () {
    var id_country = $('#id_country').find('option:selected').val();
    var id_departement = $(this).find('option:selected').val();
    if (id_country === 'FR') {
      $.getJSON('/geo/cities.json', {
        d: id_departement
      }, function (data) {
        $('#id_city, #id_lieu').empty();
        $.each(data, function (city_id, city_name) {
          $('<option/>', {
            value: city_id,
            text: city_name
          }).appendTo('#id_city');
        });
        if (asv.id_city) {
          $('#id_city option[value="' + asv.id_city + '"]').prop('selected', true);
          $('#id_city').trigger('change');
          asv.id_city = false;
        }
      });
    }
  });

  /**
   * la sélection de la ville charge la liste des lieux de la ville
   */
  $('#id_city').change(function () {
    var id_city = $(this).find('option:selected').val();
    $.getJSON('/geo/lieux.json', {
      v: id_city
    }, function (data) {
      $('#id_lieu').empty();
      $.each(data, function (lieu_id, lieu_name) {
        $('<option>', {
          value: lieu_id,
          text: lieu_name
        }).appendTo('#id_lieu');
      });
      if (asv.id_lieu) {
        $('#id_lieu option[value="' + asv.id_lieu + '"]').prop('selected', true);
        $('#id_lieu').trigger('change');
        asv.id_lieu = false;
      }
    });
  });
});
