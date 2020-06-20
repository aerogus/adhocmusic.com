{include file="common/header.tpl"}

{if !empty($unknown_lieu)}

<p class="infobulle error">Ce lieu est introuvable !</p>

{else}

{if !empty($create)}
<div class="infobulle success">Le lieu a bien été ajouté</div>
{/if}

{if !empty($edit)}
<div class="infobulle success">Le lieu a bien été modifié</div>
{/if}

<div class="box">
  <header>
    <h1>{$lieu->getName()}</h1>
  </header>
  <div>
    <div id="map_canvas" style="width: 320px; height: 320px; float: right;"></div>
    {*<img src="{$lieu->getMapUrl()}" alt="carte" align="right">*}

    <div class="infos" style="width: 300px; padding: 10px;">
      <strong>{$lieu->getName()|escape}</strong><br>
      {$lieu->getAddress()|escape}<br>
      {$lieu->getCity()->getCp()|escape} {$lieu->getCity()->getName()|escape}<br>
      {if $lieu->getIdCountry() === 'FR'}
      {$lieu->getIdDepartement()} / {$lieu->getDepartement()->getName()}<br>
      {/if}
      {$lieu->getRegion()->getName()}<br>
      <img src="{$lieu->getCountry()->getFlagUrl()}" alt="{$lieu->getIdCountry()}"> {$lieu->getCountry()->getName()}
    </div>

    <div class="infos" style="padding: 10px;">
      {$lieu->getType()}<br>
      {if $lieu->getSite()}
      <a href="{$lieu->getSite()}">{$lieu->getSite()}</a><br>
      {/if}
    </div>

    <div class="infos" style="padding: 10px;">
    {$lieu->getText()|escape|nl2br}
    </div>

    <br style="clear: both;">

  </div>
</div>

{if !empty($events_f)}
<div class="box">
  <header>
    <h2>Agenda</h2>
  </header>
  <div>
    <ul>
      {foreach $events_f as $event}
      {assign var=structures value=$event->getStructures()}
      <li>{if $structures}<img src="{$structures[0]->getPicto()}" alt="" title="Organisé par {$structures[0]->getName()|escape}">{/if}<a href="{$event->getUrl()}">Le {$event->getDate()|date_format:"%d/%m/%Y %H:%M"} - {$event->getName()|escape}</a></li>
      {/foreach}
    </ul>
  </div>
</div>
{/if}

{if !empty($events_p)}
<div class="box">
  <header>
    <h2>Evénements passés</h2>
  </header>
  <div>
    <ul>
      {foreach from=$events_p item=event}
      {assign var=structures value=$event->getStructures()}
      <li>{if $structures}<img src="{$structures[0]->getPicto()}" alt="" title="Organisé par {$structures[0]->getName()|escape}">{/if}<a href="{$event->getUrl()}">Le {$event->getDate()|date_format:"%d/%m/%Y %H:%M"} - {$event->getName()|escape}</a></li>
      {/foreach}
    </ul>
  </div>
</div>
{/if}

{if !empty($photos)}
<div class="box">
  <header>
    <h2>Photos</h2>
  </header>
  <div class="reset gallery">
  {foreach from=$photos item=photo}
    <div class="photo">
      <a href="{$photo->getThumbUrl(1000)}" data-id="{$photo->getIdPhoto()}" data-at-1000="{$photo->getThumbUrl(1000)}" title="{$photo->getName()|escape}{if !empty($photo->getGroupe())} ({$photo->getGroupe()->getName()|escape}){/if} 📷 {$photo->getCredits()}">
        <img data-id="{$photo->getIdPhoto()}" src="{$photo->getThumbUrl(320)}" alt="{$photo->getName()|escape}{if !empty($photo->getGroupe())} ({$photo->getGroupe()->getName()|escape}){/if}">
      </a>
    </div>
  {/foreach}
  </div>
</div>
{/if}

{if !empty($audios)}
<div class="box">
  <header>
    <h2>Sons</h2>
  </header>
  <div>
    <ul>
      {foreach $audios as $audio}
      <li>Titre : <strong>{$audio->getName()|escape}</strong>
      {if !empty($audio->getGroupe())}<br>Groupe : <a href="{$audio->getGroupe()->getUrl()}">{$audio->getGroupe()->getName()}</a>{/if}
      {if !empty($audio->getEvent())}<br>Evénement : <a href="{$audio->getEvent()->getUrl()}">{$audio->getEvent()->getName()}</a> ({$audio->getEvent()->getDate()|date_format:'%d/%m/%Y'}){/if}
      <br><audio src="{$audio->getDirectMp3Url()}"></audio></li>
      {/foreach}
    </ul>
  </div>
</div>
{/if}

{if !empty($videos)}
<div class="box">
  <header>
    <h2>Vidéos</h2>
  </header>
  <div class="reset grid-3-small-2 has-gutter">
    {foreach $videos as $video}
    <div class="video">
      <div class="thumb" style="background-image: url({$video->getThumbUrl(320)})">
        <a class="playbtn" href="{$video->getUrl()}" title="Regarder la vidéo {$video->getName()|escape}">▶</a>
      </div>
      <p class="title"><a href="{$video->getUrl()}" title="Regarder la vidéo {$video->getName()|escape}">{$video->getName()}</a></p>
      <p class="subtitle">
        {if !empty($video->getGroupe())}<a href="{$video->getGroupe()->getUrl()}" title="Aller à la page du groupe {$video->getGroupe()->getName()|escape}">{$video->getGroupe()->getName()}</a>{/if}
        {if !empty($video->getGroupe()) && !empty($video->getEvent())}<br/>{/if}
        {if !empty($video->getEvent())}<a href="{$video->getEvent()->getUrl()}" title="Aller à la page de l'événement {$video->getEvent()->getName()|escape}">{$video->getEvent()->getDate()|date_format:"%a %e %B %Y"}</a>{/if}
      </p>
    </div>
    {/foreach}
  </div>
</div>
{/if}

{/if} {* test unknown lieu *}

{include file="common/footer.tpl"}
