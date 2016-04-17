/*globals jQuery, adhoc*/

jQuery(document).ready(function ($) {

    'use strict';

    $("#date").datepicker({
        dateFormat: 'dd/mm/yy',
        showAnim: 'slideDown'
    });

    $("#form-event-create").submit(function () {
        var valid = true;
        if ($("#name").val().length === 0) {
            $("#error_name").fadeIn();
            valid = false;
        } else {
            $("#error_name").fadeOut();
        }
        if ($("#id_lieu").val() === "0") {
            $("#error_id_lieu").fadeIn();
            valid = false;
        } else {
            $("#error_id_lieu").fadeOut();
        }
        if ($("#text").val().length === 0) {
            $("#error_text").fadeIn();
            valid = false;
        } else {
            $("#error_text").fadeOut();
        }
        if ($("#price").val().length === 0) {
            $("#error_price").fadeIn();
            valid = false;
        } else {
            $("#error_price").fadeOut();
        }
        return valid;
    });

    $('#id_country, #id_region, #id_departement, #id_city').keypress(function () {
        $(this).trigger('change');
    });

    /**
     *
     */
    $('#id_country').change(function () {
        console.log('id_country change');
        var id_country = $('#id_country').val();
        var event_id_region = adhoc.lieu.id_region;
        $('#id_region').empty();
        $('#id_departement').empty();
        $('#id_city').empty();
        $('<option value="0">---</option>').appendTo('#id_region');
        $.getJSON('/geo/getregion.json', {
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
     *
     */
    $('#id_region').change(function () {
        console.log('id_region change');
        var id_country = $('#id_country').val();
        var id_region = $('#id_region').val();
        var event_id_departement = '{$data.id_departement}';
        $('#id_departement').empty();
        $('#id_city').empty();
        if (id_country === 'FR') {
            $('<option value="0">---</option>').appendTo('#id_departement');
            $.getJSON('/geo/getdepartement.json', {
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
     *
     */
    $('#id_departement').change(function () {
        console.log('id_departement change');
        var id_country = $('#id_country').val();
        var id_departement = $('#id_departement').val();
        $('#id_city').empty();
        if (id_country === 'FR') {
            $('<option value="0">---</option>').appendTo('#id_city');
            $.getJSON('/geo/getcity.json', {
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
     *
     */
    $('#id_city').change(function () {
        console.log('id_city change');
        var id_city = $('#id_city').val();
        $('#id_lieu').empty();
        $('<option value="0">---</option>').appendTo('#id_lieu');
        $.getJSON('/geo/getlieu.json', {
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
     *
     */
    $('#id_lieu').change(function () {
        console.log('id_lieu change');
        $('#id_country').parent().css('background-color', '');
        $('#id_region').parent().css('background-color', '');
        $('#id_departement').parent().css('background-color', '');
        $('#id_city').parent().css('background-color', '');
        $('#id_lieu').parent().css('background-color', '');
        $('#bloc_lieu li').css('background-color', '#006600');
    });

    $('#id_country').trigger('change');
    $('#id_region').trigger('change');
    $('#id_departement').trigger('change');

});
