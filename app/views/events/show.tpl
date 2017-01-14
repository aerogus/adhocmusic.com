{include file="common/header.tpl"}

{if !empty($unknown_event)}

<p class="error">Cet événement est introuvable !</p>

{else}

<div class="grid-3-tiny-2-small-1 has-gutter-l">

  <div class="box two-thirds">
    <header>
      <h3>{$event->getName()}</h3>
    </header>
    <div>

  {if $event->getFullFlyerUrl()}
  <img src="{$event->getFlyer400Url()}" alt="{$event->getName()|escape}" style="float: right; padding: 0 0 10px 10px;">
  {/if}

  <p style="padding: 10px;" align="justify">{$event->getText()|escape|@nl2br}</p>

  <div id="event-box-info">
    <p><strong>Le {$jour} à {$heure}</strong></p>
    <a href="/lieux/show/{$lieu->getId()}" title="{$lieu->getName()|escape}">
      <img id="event-box-map" src="{$lieu->getMapUrl('64x64')}" alt="">
      <strong>{$lieu->getName()|escape}</strong><br>
      {$lieu->getAddress()}<br>
      {$lieu->getCp()} - {$lieu->getCity()|escape}
    </a>
    <p>Entrée : <strong>{$event->getPrice()|escape}</strong></p>
  </div>

  {if !empty($alerting_sub_url)}
  <div class="alerting-sub"><a href="{$alerting_sub_url}">Ajouter à mon agenda</a></div>
  {elseif !empty($alerting_unsub_url)}
  <div class="alerting-unsub"><a href="{$alerting_unsub_url}">Enlever de mon agenda</a></div>
  {elseif !empty($alerting_auth_url)}
  <div class="alerting-auth"><a href="{$alerting_auth_url}">Ajouter à mon agenda</a></div>
  {/if}

  {if $event->getFacebookEventId()}
  <p class="event_facebook" id="fb-event-{$event->getFacebookEventId()}">
    <a href="{$event->getFacebookEventUrl()}">{$event->getFacebookEventAttending()} participants</a>
    <a href="#" class="fb-event-button fb-event-attending">J'y vais</a>
    <a href="#" class="fb-event-button fb-event-maybe">Peut-être</a>
    <a href="#" class="fb-event-button fb-event-declined">Non merci</a>
  </p>
  {/if}

  {if !empty($groupes)}
  <p>Avec :</p>
  <ul>
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

  {include file="comments/share.tpl" title="cet événement" url=$event->getUrl()}

  {include file="comments/box.tpl" type="e" id_content=$event->getId()}

  {if !empty($videos)}
  <div class="blocinfo">
    <h3>Vidéos</h3>
    {foreach from=$videos item=video}
    <div class="thumb-80">
      <a href="{$video.url}"><img src="{$video.thumb_80_80}" alt="{$video.name|escape}{if !empty($video.groupe_name)} ({$video.groupe_name|escape}){/if}">{$video.name|truncate:15:"...":true:true|escape}</a>
      <a class="overlay-80 overlay-video-80" href="{$video.url}" title="{$video.name|escape}{if !empty($video.groupe_name)} ({$video.groupe_name|escape}){/if}"></a>
    </div>
    {/foreach}
  </div>
  {/if}

  {if !empty($photos)}
  <div class="blocinfo">
    <h3>Photos</h3>
    {foreach from=$photos item=photo}
    <div class="thumb-80">
      <a href="{$photo.url|escape}?from=event"><img src="{$photo.thumb_80_80}" alt="{$photo.name|escape}{if !empty($photo.groupe_name)} ({$photo.groupe_name|escape}){/if}">{$photo.name|truncate:15:"...":true:true|escape}</a>
      <a class="overlay-80 overlay-photo-80" href="{$photo.url}" title="{$photo.name|escape}{if !empty($photo.groupe_name)} ({$photo.groupe_name|escape}){/if}"></a>
    </div>
    {/foreach}
  </div>
  {/if}

  {if !empty($audios)}
  <div class="blocinfo">
    <h3>Sons</h3>
    <ul>
    {foreach from=$audios item=audio}
      <li><strong>{$audio.name|escape}</strong> (<a href="{$audio.groupe_url}">{$audio.groupe_name|escape}</a>)<br>{audio_player id=$audio.id}</li>
    {/foreach}
    </ul>
  </div>
  {/if}

  </div>

</div>{* .box *}

<div class="one-third">
  {calendar year=$year month=$month day=$day}
</div>

{/if} {* test unknown event *}

{include file="common/footer.tpl"}
