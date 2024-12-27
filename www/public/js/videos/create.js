/* global document, jQuery */

jQuery(document).ready(function ($) {

  'use strict';

  $('#code').blur(function () {
    let code = $('#code').val();
    $.getJSON('/videos/get-meta.json', {
      code: code
    }, function (data) {
      if (data.status === 'OK') {
        $('#id_host').val(data.data.id_host);
        $('#name').val(data.data.title);
        $('#thumb').empty();
        $('<img src="' + data.data.thumb + '" alt="" />').appendTo('#thumb');
      }
    });
  });

  $('#id_lieu').keypress(function () {
    $('#id_lieu').trigger('change');
  });

  $('#id_lieu').change(function () {
    let id_lieu = $('#id_lieu').val();
    $('#id_event').empty();
    $('<option value="0">---</option>').appendTo('#id_event');
    $.getJSON('/events/get-events-by-lieu.json', {
      l: id_lieu
    }, function (data) {
      $.each(data, function (event_id, event) {
        $('<option value="' + event.id + '">' + event.date + ' - ' + event.name + '</option>').appendTo('#id_event');
      });
    });
  });

  $('#form-video-create').submit(function () {
    let valid = true;
    if ($('#name').val().length === 0) {
      $('#name').prev('.error').fadeIn();
      valid = false;
    } else {
      $('#name').prev('.error').fadeOut();
    }
    if ($('#code').val().length === 0) {
      $('#code').prev('.error').fadeIn();
      valid = false;
    } else {
      $('#code').prev('.error').fadeOut();
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
