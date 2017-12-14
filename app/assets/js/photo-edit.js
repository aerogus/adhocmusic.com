/*globals jQuery*/

jQuery(document).ready(function ($) {

  'use strict';

  $('#id_lieu').keypress(function() {
    $('#id_lieu').trigger('change');
  });

  $('#id_lieu').change(function() {
    var id_lieu = $('#id_lieu').val();
    var photo_id_event = $('#id_photo').val();
    $('#id_event').empty();
    $('<option value="0">---</option>').appendTo('#id_event');
    $.getJSON('/events/get-events-by-lieu.json', {
      l: id_lieu
    }, function (data) {
      var selected = '';
      $.each(data, function (event_id, event) {
        if (photo_id_event === event.id) {
          selected = ' selected="selected"';
        } else {
          selected = '';
        }
        $('<option value="' + event.id + '"' + selected + '>' + event.date + ' - ' + event.name + '</option>').appendTo('#id_event');
      });
    });
  });

  $('#form-photo-edit').submit(function () {
    var valid = true;
    if($('#name').val().length === 0) {
      $('#name').prev('.error').fadeIn();
      valid = false;
    } else {
      $('#name').prev('.error').fadeOut();
    }
    if($('#credits').val().length === 0) {
      $('#credits').prev('.error').fadeIn();
      valid = false;
    } else {
      $('#credits').prev('.error').fadeOut();
    }
    if($('#id_groupe').val().length === 0) {
      $('#id_groupe').prev('.error').fadeIn();
      valid = false;
    } else {
      $('#id_groupe').prev('.error').fadeOut();
    }
    return valid;
  });

  $('#id_lieu').trigger('change');

});
