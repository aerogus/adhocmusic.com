/*globals jQuery, validateEmail, lieu */

jQuery(document).ready(function ($) {

    'use strict';

    $('#email').focus(function () {
        $('#bubble_email').fadeIn();
    });

    $('#pseudo').focus(function () {
        $('#bubble_pseudo').fadeIn();
    });

    $('#pseudo').blur(function () {
        if ($(this).val().length > 2) {
            // check dispo du pseudo
            var pseudo = $('#pseudo').val();
            $.getJSON('/auth/check-pseudo.json', {
                pseudo: pseudo
            }, function (data) {
                if (data.status === 'KO_PSEUDO_UNAVAILABLE') {
                    $('#error_pseudo_unavailable').fadeIn();
                }
                if (data.status === 'OK') {
                    $('#error_pseudo_unavailable').fadeOut();
                }
            });
        }
    });

    $('#email').blur(function () {
        if ($(this).val().length > 2) {
            // check existence email
            var email = $('#email').val();
            $.getJSON('/auth/check-email.json', {
                email: email
            }, function (data) {
                if (data.status === 'KO_INVALID_EMAIL') {
                    $('#error_invalid_email').fadeIn();
                    $('#error_already_member').fadeOut();
                }
                if (data.status === 'KO_ALREADY_MEMBER') {
                    $('#error_invalid_email').fadeOut();
                    $('#error_already_member').fadeIn();
                }
                if (data.status === 'OK') {
                    $('#error_invalid_email').fadeOut();
                    $('#error_already_member').fadeOut();
                }
            });
        }
    });

    $('#form-member-create').submit(function () {
        var validate = true;
        if ($('#pseudo').val().length === 0) {
            $('#pseudo').prev('.error').fadeIn();
            validate = false;
        } else {
            $('#pseudo').prev('.error').fadeOut();
        }
        if ($('#email').val().length === 0 || validateEmail($('#email').val()) === 0) {
            $('#email').prev('.error').fadeIn();
            validate = false;
        } else {
            $('#email').prev('.error').fadeOut();
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
        if ($('#id_country').val() === null) {
            $('#id_country').prev('.error').fadeIn();
            validate = false;
        } else {
            $('#id_country').prev('.error').fadeOut();
        }
        return validate;
    });

});
