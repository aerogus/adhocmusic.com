/*globals jQuery */

jQuery(document).ready(function ($) {

  'use strict';

  $('#search-results').html('Sélectionnez un groupe ou un événement');

  $('#groupe').change(function () {
    $('#event, #lieu').val('');
    launchSearch();
  });

  $('#event').change(function () {
    $('#groupe, #lieu').val('');
    launchSearch();
  });

  $('#lieu').change(function () {
    $('#groupe, #event').val('');
    launchSearch();
  });

  function launchSearch() {
    $.get('/medias/search-results', {
      groupe: $('#groupe').val(),
      event: $('#event').val(),
      lieu: $('#lieu').val()
    }, function (data) {
      $('#search-results').html(data);
    });
  }

});
