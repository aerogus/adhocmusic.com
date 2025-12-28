/* global document, jQuery */

import WaveSurfer from '/static/library/wavesurfer@7.12.1/wavesurfer.esm.js';
import Hover from '/static/library/wavesurfer@7.12.1/plugins/hover.esm.js';

// Passage d'un temps en secondes à mm:ss:ss
function formatTimecode(time)
{
  return new Date(time * 1000).toISOString().slice(11, 19);
}

let elm = document.querySelectorAll('.waveform')[0];

// Create an instance of WaveSurfer
const ws = WaveSurfer.create({
  container: elm,
  waveColor: '#292933',
  progressColor: '#000000',
  barWidth: 0,
  barGap: 0,
  barRadius: 0,
  plugins: [
    Hover.create({
      lineColor: '#ff0000',
      lineWidth: 2,
      labelBackground: '#555',
      labelColor: '#fff',
      labelSize: '11px',
    }),
  ],
})

let playButton = document.getElementsByClassName('playButton')[0];
let currentTime = document.getElementsByClassName('currentTime')[0];
let totalTime = document.getElementsByClassName('totalTime')[0];

playButton.addEventListener('click', (e) => {
  e.preventDefault();
  if (ws.isPlaying()) {
    ws.stop();
    playButton.innerHTML = '▶️';
  } else {
    ws.play();
    playButton.innerHTML = 'II';
  }
});

ws.on('ready', (duration) => {
  totalTime.innerHTML = formatTimecode(duration);
});

ws.on('audioprocess', (_currentTime) => {
  currentTime.innerHTML = formatTimecode(_currentTime);
});

ws.load(elm.dataset.mediaUrl);

jQuery(document).ready(function ($) {

  'use strict';

  $('#id_lieu').keypress(function () {
    $('#id_lieu').trigger('change');
  });

  $('#id_lieu').change(function () {
    let id_lieu = $('#id_lieu').val();
    let audio_id_event = +$('#audio_id_event').val();
    $('#id_event').empty();
    $('<option value="0">---</option>').appendTo('#id_event');
    $.getJSON('/events/get-events-by-lieu.json', {
      l: id_lieu
    }, function (data) {
      let selected = '';
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
    let valid = true;
    if ($('#name').val().length === 0) {
      $('#name').parent().find('.alert-danger').fadeIn();
      valid = false;
    } else {
      $('#name').parent().find('.alert-danger').fadeOut();
    }
    if ($('#id_groupe').val() === '0' && $('#id_lieu').val() === '0' && $('#id_event').val() === '0') {
      $('#id_groupe').parent().find('.alert-danger').fadeIn();
      //valid = false; // pas obligé temporairement
    } else {
      $('#id_groupe').parent().find('.alert-danger').fadeOut();
    }
    return valid;
  });

  $('#id_lieu').trigger('change');

});
