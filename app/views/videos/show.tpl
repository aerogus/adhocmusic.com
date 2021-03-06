{include file="common/header.tpl"}

{if !empty($unknown_video)}

<p class="infobulle error">Cette vidéo est introuvable !</p>

{else}

<div class="box">
  <header>
    <h1>{$video->getName()|escape}</h1>
  </header>
  <div class="reset">
    <div class="fluid-video-player {$video->getPlayerRatio()}">
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
      {include file="comments/share.tpl" title="" url=$video->getUrl() text=$video->getName()}
    </div>
  </div>

  {if !empty($groupe)}
  <div class="box">
    <header>
      <h2>Groupe</h2>
    </header>
    <div>
      <a href="{$groupe->getUrl()}" style="display:block;text-align:center"><img style="display:block;margin:auto" src="{$groupe->getMiniPhoto()}" alt=""><strong>{$groupe->getName()|escape}</strong></a>
    </div>
  </div>
  {/if}

  {if !empty($event)}
  <div class="box">
    <header>
      <h2>Événement</h2>
    </header>
    <div>
      <a href="{$event->getUrl()}"><img style="float: right;" src="{$event->getThumbUrl(100)}" alt=""><strong>{$event->getName()|escape}</strong></a><br>{$event->getDate()|date_format:'%d/%m/%Y'}
    </div>
  </div>
  {/if}

  {if !empty($lieu)}
  <div class="box">
    <header>
      <h2>Lieu</h2>
    </header>
    <div>
      <a href="{$lieu->getUrl()}"><strong>{$lieu->getName()|escape}</strong></a><br>{$lieu->getAddress()}<br>{$lieu->getCity()->getCp()} {$lieu->getCity()->getName()|escape}
    </div>
  </div>
  {/if}

</div>

{if !empty($videos)}
<div class="box">
  <header>
    <h2>Vidéos du même concert</h2>
  </header>
  <div class="reset grid-3-small-2 has-gutter">
    {foreach $videos as $_video}
    {if $_video->getIdVideo() !== $video->getIdVideo()}
      <div class="video">
        <div class="thumb" style="background-image: url({$_video->getThumbUrl(320)})">
          <a class="playbtn" href="{$_video->getUrl()}" title="Regarder la vidéo {$_video->getName()|escape}">▶</a>
        </div>
        <p class="title"><a href="{$_video->getUrl()}" title="Regarder la vidéo {$_video->getName()|escape}">{$_video->getName()|escape}</a></p>
        <p class="subtitle">{if !empty($_video->getGroupe())}<a href="{$_video->getGroupe()->getUrl()}" title="Aller à la page du groupe {$_video->getGroupe()->getName()|escape}">{$_video->getGroupe()->getName()|escape}</a>{/if}</p>
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
      <a href="{$photo->getThumbUrl(1000)}" data-at-1000="{$photo->getThumbUrl(1000)}" title="{$photo->getName()|escape}{if !empty($photo->getGroupe())} ({$photo->getGroupe()->getName()|escape}){/if}">
        <img src="{$photo->getThumbUrl(320)}" alt="{$photo->getName()|escape}{if !empty($photo->getGroupe())} ({$photo->getGroupe()->getName()|escape}){/if}">
      </a>
    </div>
  {/foreach}
  </div>
</div>
{/if}

{/if} {* test unknown video *}

{include file="common/footer.tpl"}
