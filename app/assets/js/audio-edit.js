/*globals jQuery*/

jQuery(document).ready(function ($) {

  'use strict';

  $('#id_lieu').keypress(function () {
    $('#id_lieu').trigger('change');
  });

  $('#id_lieu').change(function () {
    var id_lieu = $('#id_lieu').val();
    //var audio_id_event = {$audio->getIdEvent()};
    var audio_id_event = 0;
    $('#id_event').empty();
    $('<option value="0">---</option>').appendTo('#id_event');
    $.getJSON('/events/get-events-by-lieu.json', {
      l: id_lieu
    }, function (data) {
      var selected = '';
      $.each(data, function (event_id, event) {
        if(audio_id_event === event.id) {
          selected = ' selected="selected"';
        } else {
          selected = '';
        }
        $('<option value="' + event.id + '"' + selected + '>' + event.date + ' - ' + event.name + '</option>').appendTo('#id_event');
      });
    });
  });

  $('#form-audio-edit').submit(function () {
    var valid = true;
    if ($('#name').val().length === 0) {
      $('#name').parent().find('.error').fadeIn();
      valid = false;
    } else {
      $('#name').parent().find('.error').fadeOut();
    }
    if ($('#id_groupe').val() === '0' && $('#id_lieu').val() === '0' && $('#id_event').val() === '0') {
      $('#id_groupe').parent().find('.error').fadeIn();
      valid = false;
    } else {
      $('#id_groupe').parent().find('.error').fadeOut();
    }
    return valid;
  });

  $('#id_lieu').trigger('change');

});
