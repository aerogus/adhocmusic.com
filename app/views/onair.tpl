{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Live</h1>
  </header>
  <div>
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <video id="video"></video>
    <script>
  var video = document.getElementById('video');
  var videoSrc = 'https://live.adhocmusic.com/hls/onair.m3u8';
  if (Hls.isSupported()) {
    var hls = new Hls();
    hls.loadSource(videoSrc);
    hls.attachMedia(video);
    hls.on(Hls.Events.MANIFEST_PARSED, function() {
      video.play();
    });
  } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
    video.src = videoSrc;
    video.addEventListener('loadedmetadata', function() {
      video.play();
    });
  }
</script>
  </div>
</div>

{include file="common/footer.tpl"}
