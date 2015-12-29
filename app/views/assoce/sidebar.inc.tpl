<div class="box">
  <header>
    <h2>Présentation</h2>
  </header>
  <div style="width: 320px; height: 225px;">
  <p id="container0">Please install the Flash Plugin</p>
  <script>
  var flashvars = {
      file: 'http://static.adhocmusic.com/media/video/343.mp4',
      autostart: 'false',
      controlbar: 'bottom',
      backcolor: '990000',
      frontcolor: 'FFFFFF',
      screencolor: '000000',
      autostart: 'false'
  };
  var params = {
      allowfullscreen: 'true',
      allowscriptaccess: 'always'
  };
  var attributes = {
      id: 'player0',
      name: 'player0'
  };
  swfobject.embedSWF('http://static.adhocmusic.com/jwplayer/player.swf', 'container0', '300','225', '9.0.115', 'false', flashvars, params, attributes);
  </script>
  </div>
</div>

<div class="box">
  <header>
    <h2>Souvenez vous</h2>
  </header>
  <div>
  {foreach from=$videos item=video}
  <div class="thumb-80 thumb-video-80">
    <a href="{$video.url}"><img src="{$video.thumb_80_80}" alt="{$video.name|escape}{if !empty($video.groupe_name)} ({$video.groupe_name|escape}){/if}" />{$video.name|truncate:15:"...":true:true|escape}</a>
    <a class="overlay-80 overlay-video-80" href="{$video.url}" title="Regarder {$video.name|escape}{if !empty($video.groupe_name)} ({$video.groupe_name|escape}){/if}"></a>
  </div>
  {/foreach}
  {foreach from=$photos item=photo}
  <div class="thumb-80 thumb-photo-80">
    <a href="{$photo.url}"><img src="{$photo.thumb_80_80}" alt="{$photo.name|escape}{if !empty($photo.groupe_name)} ({$photo.groupe_name|escape}){/if}" />{$photo.name|truncate:15:"...":true:true|escape}</a>
    <a class="overlay-80 overlay-photo-80" href="{$photo.url}" title="Voir {$photo.name|escape}{if !empty($photo.groupe_name)} ({$photo.groupe_name|escape}){/if}"></a>
  </div>
  {/foreach}
  </div>
</div>
