/* global document, jQuery */

jQuery(document).ready(function ($) {

  'use strict';

  $('#form-comments-delete').submit(function (event) {

    $('#sablier').show();
    event.preventDefault();
    let checked = $(this).find('input:checked');
    checked.map(function() {
      let id = this.id.replace('com-del-', '');
      $.post('/comments/ajax-delete', { id: id }, function () {
        $('#row-' + id).hide();
      });
    });
    $('#sablier').hide();

  });

});