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
      $.each(data, function(event_id, event) {
        $('<option value="' + event.id + '">' + event.date + ' - ' + event.name + '</option>').appendTo('#id_event');
      });
    });
  });

  $('#form-audio-create').submit(function () {
    var valid = true;
    if($('#file').val().length === 0) {
      $('#file').parent().find('.error').fadeIn();
      valid = false;
    } else {
      $('#file').parent().find('.error').fadeOut();
    }
    if($('#name').val().length === 0) {
      $('#name').parent().find('.error').fadeIn();
      valid = false;
    } else {
      $('#name').parent().find('.error').fadeOut();
    }
    if($('#id_groupe').val() === '0' && $('#id_lieu').val() === '0' && $('#id_event').val() === '0') {
      $('#id_groupe').parent().find('.error').fadeIn();
      valid = false;
    } else {
      $('#id_groupe').parent().find('.error').fadeOut();
    }
    return valid;
  });
});
