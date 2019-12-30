/*global jQuery*/

jQuery(document).ready(function ($) {

  'use strict';

  $('#form-comments-delete').submit(function (event) {

    $('#sablier').show();
    event.preventDefault();
    var checked = $(this).find('input:checked');
    var ids = checked.map(function() {
      var id = this.id.replace('com-del-', '');
      $.post('/comments/ajax-delete', { id: id }, function (data) {
        $('#row-' + id).hide();
      });
    });
    $('#sablier').hide();

  });

});