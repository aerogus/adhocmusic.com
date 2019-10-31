{include file="common/header.tpl"}

{if !empty($unknown_event)}

<p class="infobulle error">Cet événement est introuvable !</p>

{else}

<div class="box">
  <header>
    <h1>{$event->getName()}</h1>
  </header>
  <div>

    {if $event->getFullFlyerUrl()}
    <img src="{$event->getFlyer320Url()}" alt="{$event->getName()|escape}" style="display: block; margin: 0 auto 10px;">
    {/if}

    <p align="justify">{$event->getText()|escape|@nl2br}</p>

    <div id="event-box-info">
      <p><strong>Le {$jour} à {$heure}</strong></p>
      <a href="/lieux/{$lieu->getId()}" title="{$lieu->getName()|escape}">
        <!-- map à debugguer -->
        <!--<img id="event-box-map" src="{$lieu->getMapUrl('64x64')}" alt="">-->
        <strong>{$lieu->getName()|escape}</strong><br>
        {$lieu->getAddress()}<br>
        {$lieu->getCp()} - {$lieu->getCity()|escape}
      </a>
      <p>Entrée : <strong>{$event->getPrice()|escape}</strong></p>
    </div>

    {if $event->getFacebookEventId()}
    <p class="event_facebook">
      <a href="{$event->getFacebookEventUrl()}">Événement Facebook</a>
    </p>
    {/if}

    {if !empty($groupes)}
    <p>Avec :</p>
    <ul class="grid-3">
    {foreach from=$groupes item=groupe}
      <li><a href="{$groupe.url}"><img src="{$groupe.mini_photo}" style="float: left; margin: 2px; border: 1px solid #000000;" alt=""></a><a href="{$groupe.url}"><strong>{$groupe.name|escape}</strong></a><br>({$groupe.style|escape})</li>
    {/foreach}
    </ul>
    {/if}

    {if !empty($structures)}
    <p>Organisateur :</p>
    <ul>
    {foreach from=$structures item=structure}
      <li><img src="{$structure.picto}" alt="" title="{$structure.name}"><strong>{$structure.name|escape}</strong></li>
    {/foreach}
    </ul>
    {/if}

  </div>
</div>{* .box *}

{if !empty($audios)}
<div class="box">
  <header>
    <h2>Sons</h2>
  </header>
  <div>
    <ul>
    {foreach from=$audios item=audio}
      <li><strong>{$audio.name|escape}</strong> (<a href="{$audio.groupe_url}">{$audio.groupe_name|escape}</a>)<br>{audio_player id=$audio.id}</li>
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
  <div class="reset grid-6">
    {foreach from=$videos item=video}
    <div class="thumb-80">
      <a href="{$video.url}"><img src="{$video.thumb_80_80}" alt="{$video.name|escape}{if !empty($video.groupe_name)} ({$video.groupe_name|escape}){/if}">{$video.name|truncate:15:"...":true:true|escape}</a>
      <a class="overlay-80 overlay-video-80" href="{$video.url}" title="{$video.name|escape}{if !empty($video.groupe_name)} ({$video.groupe_name|escape}){/if}"></a>
    </div>
    {/foreach}
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
      <a href="{$photo.thumb_1000}" data-at-1000="{$photo.thumb_1000}" title="{$photo.name|escape}{if !empty($photo.groupe_name)} ({$photo.groupe_name|escape}){/if}">
        <img src="{$photo.thumb_320}" alt="{$photo.name|escape}{if !empty($photo.groupe_name)} ({$photo.groupe_name|escape}){/if}">
      </a>
    </div>
  {/foreach}
  </div>
</div>
{/if}

{/if} {* test unknown event *}

{include file="common/footer.tpl"}
