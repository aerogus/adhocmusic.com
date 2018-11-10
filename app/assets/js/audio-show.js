/*globals audio_url */

$(function() {
  $('#jquery_jplayer_1').jPlayer({
    ready: function (event) {
      $(this).jPlayer('setMedia', {
        mp3: audio_url
      });
    },
    swfPath: '/js',
    supplied: 'mp3',
    wmode: 'window'
  });
});
