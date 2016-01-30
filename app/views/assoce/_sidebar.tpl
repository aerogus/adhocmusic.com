<div class="box">
  <header>
    <h2>Présentation</h2>
  </header>
  <div style="padding: 0">
    <video width="320" height="260" src="/media/video/343.mp4"></video>
  </div>
</div>

<div class="box">
  <header>
    <h2>Souvenez vous</h2>
  </header>
  <div>
  {foreach from=$videos item=video}
  <div class="thumb-80 thumb-video-80">
    <a href="{$video.url}"><img src="{$video.thumb_80_80}" alt="{$video.name|escape}{if !empty($video.groupe_name)} ({$video.groupe_name|escape}){/if}">{$video.name|truncate:15:"...":true:true|escape}</a>
    <a class="overlay-80 overlay-video-80" href="{$video.url}" title="Regarder {$video.name|escape}{if !empty($video.groupe_name)} ({$video.groupe_name|escape}){/if}"></a>
  </div>
  {/foreach}
  {foreach from=$photos item=photo}
  <div class="thumb-80 thumb-photo-80">
    <a href="{$photo.url}"><img src="{$photo.thumb_80_80}" alt="{$photo.name|escape}{if !empty($photo.groupe_name)} ({$photo.groupe_name|escape}){/if}">{$photo.name|truncate:15:"...":true:true|escape}</a>
    <a class="overlay-80 overlay-photo-80" href="{$photo.url}" title="Voir {$photo.name|escape}{if !empty($photo.groupe_name)} ({$photo.groupe_name|escape}){/if}"></a>
  </div>
  {/foreach}
  </div>
</div>
