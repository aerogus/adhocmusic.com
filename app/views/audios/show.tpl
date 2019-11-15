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
<div class="box">
  <header>
    <h2>Photos et vidéos de ce concert</h2>
  </header>
  <div>
{foreach $photos as $photo}
<div class="thumb-80 thumb-photo-80">
  <a href="{$photo->getUrl()}"><img src="{$photo->getThumb80Url()}" alt="{$photo->getName()|escape}"><br>{$photo->getName()|truncate:15:"...":true:true|escape}</a>
  <a class="overlay-80 overlay-photo-80" href="{$photo->getUrl()}" title="{$photo->getName()|escape}"></a>
</div>
{/foreach}
{foreach $videos as $video}
<div class="thumb-80 thumb-video-80">
  <a href="{$video->getUrl()}"><img src="{$video->getThumb80Url()}" alt="{$video->getName()|escape}"><br>{$video->getName()|truncate:15:"...":true:true|escape}</a>
  <a class="overlay-80 overlay-video-80" href="{$video->getUrl()}" title="{$video->getName()|escape}"></a>
</div>
{/foreach}
  </div>
</div>
{/if}

{/if} {* test unknown audio *}

{include file="common/footer.tpl"}
