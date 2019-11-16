{include file="common/header.tpl"}

{if !empty($unknown_video)}

<p class="infobulle error">Cette vidéo est introuvable !</p>

{else}

<div class="box">
  <header>
    <h1>{$video->getName()|escape}</h1>
  </header>
  <div class="reset">
    <div class="fluid-video-player ratio-16-9">
    {$video->getPlayer()}
    </div>
  </div>
</div>

<div class="grid-4-small-2 has-gutter">

  <div class="box">
    <header>
      <h2>Partager cette vidéo</h2>
    </header>
    <div class="reset">
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
    <h2>Vidéos du même concert</h2>
  </header>
  <div class="reset grid-6">
    {foreach $videos as $_video}
    {if $_video->getIdVideo() !== $video->getIdVideo()}
    <div class="thumb-80">
      <a href="{$_video->getUrl()}"><img src="{$_video->getThumb80Url()}" alt="{$_video->getName()|escape}"><br>{$_video->getName()|truncate:15:"...":true:true|escape}</a>
      <a class="overlay-80 overlay-video-80" href="{$_video->getUrl()}" title="{$_video->getName()|escape}"></a>
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
      <a href="{$photo->getThumb1000Url()}" data-at-1000="{$photo->getThumb1000Url()}" title="{$photo->getName()|escape}{if !empty($photo->getGroupe())} ({$photo->getGroupe->getName()|escape}){/if}">
        <img src="{$photo->getThumb320Url()}" alt="{$photo->getName()|escape}{if !empty($photo->getGroupe())} ({$photo->getGroupe->getName()|escape}){/if}">
      </a>
    </div>
  {/foreach}
  </div>
</div>
{/if}

{/if} {* test unknown video *}

{include file="common/footer.tpl"}
