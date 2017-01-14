{include file="common/header.tpl"}

{if !empty($unknown_audio)}

<p class="error">Cet audio est introuvable !</p>

{else}

<link rel="stylesheet" href="/js/jplayer.blue.monday/jplayer.blue.monday.css">
<script src="/js/jquery.jplayer.min.js"></script>

<script>
$(function() {
  $("#jquery_jplayer_1").jPlayer( {
    ready: function (event) {
      $(this).jPlayer("setMedia", {
        mp3: "{$audio->getDirectUrl()}"
      });
    },
    swfPath: "/js",
    supplied: "mp3",
    wmode: "window"
  });
});
</script>

{include file="common/boxstart.tpl" boxtitle=$audio->getName()|escape}

{if $audio->getIdGroupe()}
<a href="{$groupe->getUrl()}"><img style="float: left; margin: 5px;" src="{$groupe->getMiniPhoto()}" alt="{$groupe->getName()|escape}"></a>
{/if}

<div class="audiometa">
<ul>
  <li>Titre : <strong>{$audio->getName()}</strong></li>
  {if $audio->getIdGroupe()}
  <li>Groupe : <a href="{$groupe->getUrl()}"><strong>{$groupe->getName()}</strong></a></li>
  {/if}
  {if $audio->getIdEvent()}
  <li>Evénement : <a href="{$event->getUrl()}"><strong>{$event->getName()}</strong></a> ({$event->getDate()|date_format:'%d/%m/%Y'})</li>
  {/if}
  {if $audio->getIdLieu()}
  <li>Lieu : <a href="{$lieu->getUrl()}"><strong>{$lieu->getName()}</strong></a></li>
  {/if}
  <li>Mise en ligne : le {$audio->getCreatedOn()|date_format:'%d/%m/%Y'} par <a href="/membres/show/{$audio->getIdContact()}"><strong>{$audio->getIdContact()|pseudo_by_id}</strong></a></li>
</ul>
</div>

<br style="clear: both;">

{*
<div id="player">
  <img src="{$audio->getWaveForm()}" alt="">
</div>
*}

<div class="og_listen_to_song">écouter</div>

<div id="jquery_jplayer_1" class="jp-jplayer"></div>
<div id="jp_container_1" class="jp-audio">
  <div class="jp-type-single">
    <div class="jp-gui jp-interface">
      <ul class="jp-controls">
        <li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
        <li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
        <li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
        <li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
        <li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
        <li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
      </ul>
      <div class="jp-progress">
        <div class="jp-seek-bar">
          <div class="jp-play-bar"></div>
        </div>
      </div>
      <div class="jp-volume-bar">
        <div class="jp-volume-bar-value"></div>
      </div>
      <div class="jp-time-holder">
        <div class="jp-current-time"></div>
        <div class="jp-duration"></div>
        <ul class="jp-toggles">
          <li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
          <li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
        </ul>
      </div>
    </div>
    <div class="jp-title">
      <ul>
        <li>{$audio->getName()}</li>
      </ul>
    </div>
    <div class="jp-no-solution">
      <span>Update Required</span>
      To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
    </div>
  </div>
</div>

{include file="comments/share.tpl" title="cette chanson" url=$audio->getUrl()}

{include file="comments/box.tpl" type="a" id_content=$audio->getId()}

{include file="common/boxend.tpl"}

{if !empty($photos) || !empty($videos)}
{include file="common/boxstart.tpl" boxtitle="Photos et Vidéos de ce concert" width="700px"}
{foreach from=$photos item=photo}
<div class="thumb-80 thumb-photo-80">
  <a href="{$photo.url}"><img src="{$photo.thumb_80_80}" alt="{$photo.name|escape}"><br>{$photo.name|truncate:15:"...":true:true|escape}</a>
  <a class="overlay-80 overlay-photo-80" href="{$photo.url}" title="{$photo.name|escape}"></a>
</div>
{/foreach}
{foreach from=$videos item=video}
<div class="thumb-80 thumb-video-80">
  <a href="{$video.url}"><img src="{$video.thumb_80_80}" alt="{$video.name|escape}"><br>{$video.name|truncate:15:"...":true:true|escape}</a>
  <a class="overlay-80 overlay-video-80" href="{$video.url}" title="{$video.name|escape}"></a>
</div>
{/foreach}
{include file="common/boxend.tpl"}
{/if}

{include file="common/boxend.tpl"}

{/if} {* test unknown audio *}

{include file="common/footer.tpl"}
