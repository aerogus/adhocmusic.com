/*globals jQuery, CodeMirror*/

jQuery(document).ready(function ($) {

  'use strict';

  CodeMirror.fromTextArea(document.getElementById('content'), {
    lineNumbers: true,
    mode: 'xml'
  });

  $('#form-newsletter-edit-upload').submit(function () {
    var formData = new FormData(document.getElementById('form-newsletter-edit-upload'));
    $.ajax({
      type: 'POST',
      url: '/adm/newsletter/upload',
      data: formData,
      processData: false,
      contentType: false,
      success: function(data) {
        console.log('success ' + data);
      }
    });
    console.log('submitted');
    return false;
  });

});
