{include file="common/header.tpl"}

{if !empty($unknown_video)}

<p class="infobulle error">Cette vidéo est introuvable !</p>

{else}

<div class="box">
  <header>
    <h1>{$video->getName()|escape}</h1>
  </header>
  <div class="reset">
    <style>
.fluid-video-player {
  overflow: hidden;
  padding-top: 56.25%;
  position: relative;
}
.fluid-video-player iframe {
  border: 0;
  height: 100%;
  left: 0;
  position: absolute;
  top: 0;
  width: 100%;
}
</style>
    <div class="fluid-video-player">
    {$video->getPlayer(true)}
    </div>
  </div>
</div>

<div class="grid-4 has-gutter-l">

  <div class="box">
    <header>
      <h2>Partager cette vidéo</h2>
    </header>
    <div>
      {include file="comments/share.tpl" title="" url=$video->getUrl()}
    </div>
  </div>

  {if !empty($groupe)}
  <div class="box">
    <header>
      <h2>Groupe</h2>
    </header>
    <div>
      <a href="{$groupe->getUrl()}"><img style="float: right;" src="{$groupe->getMiniPhoto()}" alt=""><strong>{$groupe->getName()|escape}</strong></a>
    </div>
  </div>
  {/if}

  {if !empty($event)}
  <div class="box">
    <header>
      <h2>Événement</h2>
    </header>
    <div>
      <a href="{$event->getUrl()}"><img style="float: right;" src="{$event->getFlyer100Url()}" alt=""><strong>{$event->getName()|escape}</strong></a><br>{$event->getDate()|date_format:'%d/%m/%Y'}
    </div>
  </div>
  {/if}

  {if !empty($lieu)}
  <div class="box">
    <header>
      <h2>Lieu</h2>
    </header>
    <div>
      <a href="{$lieu->getUrl()}"><strong>{$lieu->getName()|escape}</strong></a><br>{$lieu->getAddress()}<br>{$lieu->getCp()} {$lieu->getCity()|escape}
    </div>
  </div>
  {/if}

</div>

{if !empty($videos)}
<div class="box">
  <header>
    <h2>Vidéos Du même concert</h2>
  </header>
  <div class="reset grid-6">
    {foreach $videos as $vid}
    {if $vid.id != $video->getId()}
    <div class="thumb-80">
      <a href="{$vid.url}"><img src="{$vid.thumb_80_80}" alt="{$vid.name|escape}"><br>{$vid.name|truncate:15:"...":true:true|escape}</a>
      <a class="overlay-80 overlay-video-80" href="{$vid.url}" title="{$vid.name|escape}"></a>
    </div>
    {/if}
    {/foreach}
  </div>
</div>
{/if}

{if !empty($photos)}
<div class="box">
  <header>
    <h2>Photos du même concert</h2>
  </header>
  <div class="reset gallery">
  {foreach from=$photos item=photo}
    <div class="photo">
      <a href="{$photo.thumb_1000}" data-at-1000="{$photo.thumb_1000}" title="{$photo.name|escape}{if !empty($photo.groupe_name)} ({$photo.groupe_name|escape}){/if}">
        <img src="{$photo.thumb_320}" alt="{$photo.name|escape}{if !empty($photo.groupe_name)} ({$photo.groupe_name|escape}){/if}">
      </a>
    </div>
  {/foreach}
  </div>
</div>
{/if}

{/if} {* test unknown video *}

{include file="common/footer.tpl"}
