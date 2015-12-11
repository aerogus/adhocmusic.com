/*globals jQuery, validateEmail*/

jQuery(document).ready(function ($) {

    'use strict';

    $("#form-member-edit").submit(function () {
        var valid = true;
        if ($("#last_name").val().length === 0) {
            $("#last_name").prev(".error").fadeIn();
            valid = false;
        } else {
            $("#last_name").prev(".error").fadeOut();
        }
        if ($("#first_name").val().length === 0) {
            $("#first_name").prev(".error").fadeIn();
            valid = false;
        } else {
            $("#first_name").prev(".error").fadeOut();
        }
        if ($("#id_city").val().length === 0) {
            $("#id_city").prev(".error").fadeIn();
            valid = false;
        } else {
            $("#id_city").prev(".error").fadeOut();
        }
        if ($("#id_country").val().length === 0) {
            $("#id_country").prev(".error").fadeIn();
            valid = false;
        } else {
            $("#id_country").prev(".error").fadeOut();
        }
        if ($("#email").val().length === 0) {
            $("#email").prev(".error").fadeIn();
            valid = false;
        } else {
            $("#email").prev(".error").fadeOut();
        }
        if ($("#email").val().length !== 0) {
            if (validateEmail($("#email").val()) === 0) {
                $("#email").prev(".error").fadeIn();
                valid = false;
            } else {
                $("#email").prev(".error").fadeOut();
            }
        }
        return valid;
    });

    $.ajaxSetup({
        async: false
    });

    $('#id_country').keypress(function () {
        $('#id_country').trigger('change');
    });

    $('#id_region').keypress(function () {
        $('#id_region').trigger('change');
    });

    $('#id_departement').keypress(function () {
        $('#id_departement').trigger('change');
    });

    $('#id_country').change(function () {
        var id_country = $('#id_country').val();
        var membre_id_region = '{$membre->getIdRegion()}';
        $('#id_region').empty();
        $('<option value="0">---</option>').appendTo('#id_region');
        $.getJSON('/geo/getregion.json', {
            c: id_country
        }, function (data) {
            var selected = '';
            $.each(data, function (region_id, region_name) {
                if (membre_id_region === region_id) {
                    selected = ' selected="selected"';
                } else {
                    selected = '';
                }
                $('<option value="' + region_id + '"' + selected + '>' + region_name + '</option>').appendTo('#id_region');
            });
            if (id_country !== 'FR') {
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
        var membre_id_region = '{$membre->getIdRegion()}'; // FROM SERVER
        var id_region = $('#id_region').val();
        var membre_id_departement = '{$membre->getIdDepartement()}';
        $('#id_departement').empty();
        $('#id_city').empty();
        if (id_country === 'FR') {
            $('<option value="0">---</option>').appendTo('#id_departement');
            $.getJSON('/geo/getdepartement.json', {
                r: id_region
            }, function (data) {
                var selected = '';
                $.each(data, function (departement_id, departement_name) {
                    if (membre_id_departement === departement_id) {
                        selected = ' selected="selected"';
                    } else {
                        selected = '';
                    }
                    $('<option value="' + departement_id + '"' + selected + '>' + departement_id + ' - ' + departement_name + '</option>').appendTo('#id_departement');
                });
            });
        }
    });

    $('#id_departement').change(function () {
        var id_country = $('#id_country').val();
        var id_departement = $('#id_departement').val();
        var membre_id_city = '{$membre->getIdCity()}';
        $('#id_city').empty();
        if (id_country === 'FR') {
            $('<option value="0">---</option>').appendTo('#id_city');
            $.getJSON('/geo/getcity.json', {
                d: id_departement
            }, function (data) {
                var selected = '';
                $.each(data, function (city_id, city_name) {
                    if (membre_id_city === city_id) {
                        selected = ' selected="selected"';
                    } else {
                        selected = '';
                    }
                    $('<option value="' + city_id + '"' + selected + '>' + city_name + '</option>').appendTo('#id_city');
                });
            });
        }
    });

    $('#id_country').trigger('change');
    $('#id_region').trigger('change');
    $('#id_departement').trigger('change');

});
