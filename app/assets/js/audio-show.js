/*globals audio_url */

$(function() {
  $('#jquery_jplayer_1').jPlayer({
    ready: function (event) {
      $(this).jPlayer('setMedia', {
        mp3: audio_url/*"https://adhocmusic.com/media/audio/1052.mp3"*/
      });
    },
    swfPath: '/js',
    supplied: 'mp3',
    wmode: 'window'
  });
});
