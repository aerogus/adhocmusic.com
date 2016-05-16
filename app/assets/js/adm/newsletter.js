/*globals jQuery, CodeMirror*/

jQuery(document).ready(function ($) {

    'use strict';

    CodeMirror.fromTextArea(document.getElementById("content"), {
        lineNumbers: true,
        mode: "xml"
    });

    $('#form-newsletter-edit-upload').submit(function () {
        var formData = new FormData($('#form-newsletter-edit-upload'));
        $.post('/adm/newsletter/upload', {
            data: formData
        }, function (data) {
            console.log('success ' + data);
        });
        console.log('submitted');
        return false;
    });

});
