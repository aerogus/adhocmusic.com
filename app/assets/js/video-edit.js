/*global jQuery*/

jQuery(document).ready(function ($) {

  'use strict';

  $('#id_lieu').keypress(function () {
    $('#id_lieu').trigger('change');
  });

  $('#id_lieu').change(function () {
    var id_lieu = $('#id_lieu').val();
    // doit être initialisé dans le script
    var video_id_event = null;
    //var video_id_event = {$video->getIdEvent()};
    $('#id_event').empty();
    $('<option value="0">---</option>').appendTo('#id_event');
    $.getJSON('/events/get-events-by-lieu.json', {
      l: id_lieu
    }, function (data) {
      var selected = '';
      $.each(data, function (event_id, event) {
        if (video_id_event === event.id) {
          selected = ' selected="selected"';
        } else {
          selected = '';
        }
        $('<option value="' + event.id + '"' + selected + '>' + event.date + ' - ' + event.name + '</option>').appendTo('#id_event');
      });
    });
  });

  $('#form-video-edit').submit(function () {
    var valid = true;
    if ($('#name').val().length === 0) {
      $('#name').prev('.error').fadeIn();
      valid = false;
    } else {
      $('#name').prev('.error').fadeOut();
    }
    return valid;
  });

  $('#id_lieu').trigger('change');

});
