/*global jQuery*/

jQuery(document).ready(function ($) {

    'use strict';

    $("#form-structure-edit").submit(function () {
        var valid = true;
        if ($("#name").val().length === 0) {
            $("#name").prev(".error").fadeIn();
            valid = false;
        } else {
            $("#name").prev(".error").fadeOut();
        }
        return valid;
    });

});
