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

/*globals jQuery, lieu*/

jQuery(document).ready(function ($) {

    "use strict";

    $('#id_country, #id_region, #id_departement, #id_city').keypress(function () {
        $(this).trigger('change');
    });

    $.getJSON('/geo/countries.json', function () {
        // récupérer les variables serveur
        /*
        lieu.id_country;
        lieu.id_region;
        lieu.id_departement;
        lieu.id_city;
        lieu.id_lieu;
        */

        // envoyer un evenement countries loaded
    });

    /**
     * la sélection du pays charge la liste des régions
     */
    $('#id_country').change(function () {
        console.log('id_country change to ' + lieu.id_country);
        var id_country = $('#id_country').val();
        var event_id_region = lieu.id_region;
        $('#id_region').empty();
        $('#id_departement').empty();
        $('#id_city').empty();
        $('<option value="0">---</option>').appendTo('#id_region');
        $.getJSON('/geo/regions.json', {
            c: id_country
        }, function (data) {
            var selected = '';
            $.each(data, function (region_id, region_name) {
                if (event_id_region === region_id) {
                    selected = ' selected="selected"';
                } else {
                    selected = '';
                }
                $('<option value="' + region_id + '"' + selected + '>' + region_name + '</option>').appendTo('#id_region');
            });
        });
        if (id_country !== 'FR') {
            $('#id_departement').hide();
            $('#id_city').hide();
        } else {
            $('#id_departement').show();
            $('#id_city').show();
        }
        $('#id_country').parent().css('background-color', '');
        $('#id_region').parent().css('background-color', '#660000');
        $('#id_departement').parent().css('background-color', '');
        $('#id_city').parent().css('background-color', '');
        $('#id_lieu').parent().css('background-color', '');
    });

    /**
     * la sélection de la région charge la liste des départements
     */
    $('#id_region').change(function () {
        console.log('id_region change to ' + lieu.id_region);
        var id_country = $('#id_country').val();
        var id_region = $('#id_region').val();
        var event_id_departement = '{$data.id_departement}';
        $('#id_departement').empty();
        $('#id_city').empty();
        if (id_country === 'FR') {
            $('<option value="0">---</option>').appendTo('#id_departement');
            $.getJSON('/geo/departements.json', {
                r: id_region
            }, function (data) {
                var selected = '';
                $.each(data, function (departement_id, departement_name) {
                    if (event_id_departement === departement_id) {
                        selected = ' selected="selected"';
                    } else {
                        selected = '';
                    }
                    $('<option value="' + departement_id + '"' + selected + '>' + departement_id + ' - ' + departement_name + '</option>').appendTo('#id_departement');
                });
            });
        }
        $('#id_country').parent().css('background-color', '');
        $('#id_region').parent().css('background-color', '');
        $('#id_departement').parent().css('background-color', '#660000');
        $('#id_city').parent().css('background-color', '');
        $('#id_lieu').parent().css('background-color', '');
    });

    /**
     * la sélection du département charge la liste des villes
     */
    $('#id_departement').change(function () {
        console.log('id_departement change to ' + lieu.id_departement);
        var id_country = $('#id_country').val();
        var id_departement = $('#id_departement').val();
        $('#id_city').empty();
        if (id_country === 'FR') {
            $('<option value="0">---</option>').appendTo('#id_city');
            $.getJSON('/geo/cities.json', {
                d: id_departement
            }, function (data) {
                $.each(data, function (city_id, city_name) {
                    $('<option value="' + city_id + '">' + city_name + '</option>').appendTo('#id_city');
                });
            });
        }
        $('#id_country').parent().css('background-color', '');
        $('#id_region').parent().css('background-color', '');
        $('#id_departement').parent().css('background-color', '');
        $('#id_city').parent().css('background-color', '#660000');
        $('#id_lieu').parent().css('background-color', '');
    });

    /**
     * la sélection de la ville charge la liste des lieux de la ville
     */
    $('#id_city').change(function () {
        console.log('id_city change to ' + lieu.id_city);
        var id_city = $('#id_city').val();
        $('#id_lieu').empty();
        $('<option value="0">---</option>').appendTo('#id_lieu');
        $.getJSON('/geo/lieux.json', {
            v: id_city
        }, function (data) {
            $.each(data, function (lieu_id, lieu_name) {
                $('<option value="' + lieu_id + '">' + lieu_name + '</option>').appendTo('#id_lieu');
            });
        });
        $('#id_country').parent().css('background-color', '');
        $('#id_region').parent().css('background-color', '');
        $('#id_departement').parent().css('background-color', '');
        $('#id_city').parent().css('background-color', '');
        $('#id_lieu').parent().css('background-color', '#660000');
    });

    /**
     * le changement de lieu met passe au vert tous les champs
     */
    $('#id_lieu').change(function () {
        console.log('id_lieu change to ' + lieu.id);
        $('#id_country').parent().css('background-color', '');
        $('#id_region').parent().css('background-color', '');
        $('#id_departement').parent().css('background-color', '');
        $('#id_city').parent().css('background-color', '');
        $('#id_lieu').parent().css('background-color', '');
        $('#bloc_lieu li').css('background-color', '#006600');
    });

    $.getJSON('/geo/countries.json', function () {
        $('#id_country').trigger('change');
        $('#id_region').trigger('change');
        $('#id_departement').trigger('change');
    });

});
