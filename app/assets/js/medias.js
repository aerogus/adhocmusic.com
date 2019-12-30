/*globals jQuery */

jQuery(document).ready(function ($) {

  'use strict';

  $('#search-results').html('Sélectionnez un groupe ou un événement');

  $('#groupe').change(function () {
    $('#event').val('');
    $.get('/medias/search-results', {
      groupe: $(this).val(),
    }, function (data) {
      $('#search-results').html(data);
    });
  });

  $('#event').change(function () {
    $('#groupe').val('');
    $.get('/medias/search-results', {
      event: $(this).val(),
    }, function (data) {
      $('#search-results').html(data);
    });
  });

});
