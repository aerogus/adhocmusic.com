/*globals jQuery*/

jQuery(document).ready(function ($) {

    'use strict';

    $('#id_lieu').keypress(function () {
        $('#id_lieu').trigger('change');
    });

    $('#id_lieu').change(function () {
        var id_lieu = $('#id_lieu').val();
        $('#id_event').empty();
        $('<option value="0">---</option>').appendTo('#id_event');
        $.getJSON('/events/get-events-by-lieu.json', {
            l: id_lieu
        }, function (data) {
            $.each(data, function (event_id, event) {
                $('<option value="' + event.id + '">' + event.date + ' - ' + event.name + '</option>').appendTo('#id_event');
            });
        });
    });

    $("#form-photo-create").submit(function () {
        var valid = true;
        if($("#file").val().length === 0) {
            $("#error_file").fadeIn();
            valid = false;
        } else {
            $("#error_file").fadeOut();
        }
        if($("#name").val().length === 0) {
            $("#error_name").fadeIn();
            valid = false;
        } else {
            $("#error_name").fadeOut();
        }
        if($("#credits").val().length === 0) {
            $("#error_credits").fadeIn();
            valid = false;
        } else {
            $("#error_credits").fadeOut();
        }
        if($("#id_groupe").val() === "0" && $("#id_lieu").val() === "0" && $("#id_event").val() === "0") {
            $("#error_id_groupe").fadeIn();
            valid = false;
        } else {
            $("#error_id_groupe").fadeOut();
        }
        return valid;
    });

});
