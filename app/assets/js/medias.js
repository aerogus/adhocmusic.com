/*globals jQuery */

jQuery(document).ready(function ($) {

  'use strict';

  $('#search-results').html('Sélectionnez un groupe ou événement et un type de média');

  $('#groupe').change(function () {
    $('#event').val(0);
    var type = '';
    if ($('#type_video').val() === '1') {
      type += 'video,';
    }
    if ($('#type_audio').val() === '1') {
      type += 'audio,';
    }
    if ($('#type_photo').val() === '1') {
      type += 'photo,';
    }
    if (type) {
      $.get('/medias/search-results', {
        groupe: $(this).val(),
        type: type
      }, function (data) {
        $('#search-results').html(data);
      });
    }
  });

  $('#groupe').keypress(function () {
    $('#groupe').trigger('change');
  });

  $('#event').change(function () {
    $('#groupe').val(0);
    var type = '';
    if ($('#type_video').val() === '1') {
      type += 'video,';
    }
    if ($('#type_audio').val() === '1') {
      type += 'audio,';
    }
    if ($('#type_photo').val() === '1') {
      type += 'photo,';
    }
    if (type) {
      $.get('/medias/search-results', {
        event: $(this).val(),
        type: type
      }, function (data) {
        $('#search-results').html(data);
      });
    }
  });

  $('#event').keypress(function () {
    $('#event').trigger('change');
  });

});
