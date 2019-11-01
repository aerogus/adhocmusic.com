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
      {$lieu->getCp()|escape} {$lieu->getCity()|escape}<br>
      {if $lieu->getIdCountry() == 'FR'}
      {$lieu->getIdDepartement()} / {$lieu->getDepartement()}<br>
      {/if}
      {$lieu->getRegion()}<br>
      <img src="{$lieu->getCountryFlagUrl()}" alt="{$lieu->getIdCountry()}"> {$lieu->getCountry()}
    </div>

    <div class="infos" style="padding: 10px;">
      {$lieu->getType()}<br>
      {$lieu->getTel()|escape}<br>
      {$lieu->getEmail()|escape:'email'}<br>
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

<div class="box">
  <header>
    <h2>Agenda</h2>
  </header>
  <div>
    {if !empty($events_f)}
    <ul>
      {foreach $events_f as $event}
      <li>{if $event.structure_id}<img src="{$event.structure_picto}" alt="" title="Organisé par {$event.structure_name|escape}">{/if}<a href="{$event.url}">Le {$event.date|date_format:"%d/%m/%Y %H:%M"} - {$event.name|escape}</a></li>
      {/foreach}
    </ul>
    {else}
      <p>Aucun événement ! <a href="/events/create?id_lieu={$lieu->getId()}">Proposer un événement</a></p>
    {/if}
  </div>
</div>

{if !empty($events_p)}
<div class="box">
  <header>
    <h2>Evénements passés</h2>
  </header>
  <div>
    <ul>
      {foreach from=$events_p item=event}
      <li>{if $event.structure_id}<img src="{$event.structure_picto}" alt="" title="Organisé par {$event.structure_name|escape}">{/if}<a href="{$event.url}">Le {$event.date|date_format:"%d/%m/%Y %H:%M"} - {$event.name|escape}</a></li>
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
      <a href="{$photo.thumb_1000}" data-id="{$photo.id}" data-at-1000="{$photo.thumb_1000}" title="{$photo.name|escape}{if !empty($photo.groupe_name)} ({$photo.groupe_name|escape}){/if}">
        <img src="{$photo.thumb_320}" alt="{$photo.name|escape}{if !empty($photo.groupe_name)} ({$photo.groupe_name|escape}){/if}">
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
      <li>Titre : <strong>{$audio.name|escape}</strong><br>Groupe : <a href="http://www.adhocmusic.com/{$audio.groupe_alias}">{$audio.groupe_name}</a><br>Evénement : <a href="http://www.adhocmusic.com/events/show/{$audio.event_id}">{$audio.event_name}</a> ({$audio.event_date|date_format:'%d/%m/%Y'})<br><audio src="{$audio.id}"></audio></li>
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
  <div class="reset grid-3">
    {foreach $videos as $video}
    <div>
      <a href="{$video.url}"><img src="{$video.thumb_320}" alt="{$video.name|escape}{if !empty($video.groupe_name)} ({$video.groupe_name|escape}){/if}">{$video.name|truncate:15:"...":true:true|escape}</a>
      <a class="overlay-80 overlay-video-80" href="{$video.url}" title="{$video.name|escape}{if !empty($video.groupe_name)} ({$video.groupe_name|escape}){/if}"></a>
    </div>
    {/foreach}
  </div>
</div>
{/if}

{/if} {* test unknown lieu *}

{include file="common/footer.tpl"}
