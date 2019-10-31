{include file="common/header.tpl"}

{if !empty($unknown_audio)}

<p class="infobulle error">Cet audio est introuvable !</p>

{else}

<script>
var audio_url = '{$og_audio.url}';
</script>

<div class="box">
  <header>
    <h1>{$audio->getName()|escape}</h1>
  </header>
  <div>

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

<audio controls="controls" src="{$audio->getDirectMp3Url()}" style="background-color:#000"></audio>

  </div>
</div>

{if !empty($photos) || !empty($videos)}
{include file="common/boxstart.tpl" boxtitle="Photos et Vidéos de ce concert" width="700px"}
{foreach $photos as $photo}
<div class="thumb-80 thumb-photo-80">
  <a href="{$photo.url}"><img src="{$photo.thumb_80_80}" alt="{$photo.name|escape}"><br>{$photo.name|truncate:15:"...":true:true|escape}</a>
  <a class="overlay-80 overlay-photo-80" href="{$photo.url}" title="{$photo.name|escape}"></a>
</div>
{/foreach}
{foreach $videos as $video}
<div class="thumb-80 thumb-video-80">
  <a href="{$video.url}"><img src="{$video.thumb_80_80}" alt="{$video.name|escape}"><br>{$video.name|truncate:15:"...":true:true|escape}</a>
  <a class="overlay-80 overlay-video-80" href="{$video.url}" title="{$video.name|escape}"></a>
</div>
{/foreach}
{include file="common/boxend.tpl"}
{/if}

{/if} {* test unknown audio *}

{include file="common/footer.tpl"}
