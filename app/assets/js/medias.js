/*globals jQuery */

jQuery(document).ready(function ($) {

    'use strict';

    $(".check_media").toggle(function () {
        $(this).css('background-color', '#ff9999');
    }, function () {
        $(this).css('background-color', '#99ff99');
    });

    $("#check_video").click(function () {
        if ($("#type_video").val() === '1') {
            $("#type_video").val(0);
        } else {
            $("#type_video").val(1);
        }
        $('#groupe').trigger('change');
    });

    $("#check_audio").click(function () {
        if ($("#type_audio").val() === '1') {
            $("#type_audio").val(0);
        } else {
            $("#type_audio").val(1);
        }
        $('#groupe').trigger('change');
    });

    $("#check_photo").click(function () {
        if ($("#type_photo").val() === '1') {
            $("#type_photo").val(0);
        } else {
            $("#type_photo").val(1);
        }
        $('#groupe').trigger('change');
    });

    $("#search-results").html("Sélectionnez un groupe ou événement et un type de média");

    $("#groupe").change(function () {
        $("#event").val(0);
        var type = '';
        if ($("#type_video").val() === '1') {
            type += 'video,';
        }
        if ($("#type_audio").val() === '1') {
            type += 'audio,';
        }
        if ($("#type_photo").val() === '1') {
            type += 'photo,';
        }
        if (type) {
            $.get('/medias/search-results', {
                groupe: $(this).val(),
                type: type
            }, function (data) {
                $("#search-results").html(data);
            });
        }
    });

    $('#groupe').keypress(function () {
        $('#groupe').trigger('change');
    });

    $("#event").change(function () {
        $("#groupe").val(0);
        var type = '';
        if ($("#type_video").val() === '1') {
            type += 'video,';
        }
        if ($("#type_audio").val() === '1') {
            type += 'audio,';
        }
        if ($("#type_photo").val() === '1') {
            type += 'photo,';
        }
        if (type) {
            $.get('/media/search-results', {
                event: $(this).val(),
                type: type
            }, function (data) {
                $("#search-results").html(data);
            });
        }
    });

    $("#event").keypress(function () {
        $('#event').trigger('change');
    });

});
