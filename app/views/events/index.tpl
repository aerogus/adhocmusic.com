{include file="common/header.tpl"}

<div class="grid-3-small-1 has-gutter-l">

  <div class="box col-2-small-1">
    <header>
      <h3>Agenda</h3>
    </header>
    <div>

{if !count($events)}
<p>Aucune date annoncée pour cette période. <a href="/events/create">Inscrire une date</a></p>
{/if}

{if !empty($create)}<p class="infobulle success">Evénement ajouté</p>{/if}
{if !empty($edit)}<p class="infobulle success">Evénement modifié</p>{/if}
{if !empty($delete)}<p class="infobulle success">Evénement supprimé</p>{/if}

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

{foreach from=$events item=events_of_the_day key=day}
<div class="events_of_the_day">
<h3>{$day|date_format:"%A %d %B %Y"}</h3>
{foreach from=$events_of_the_day item=event}
{assign var='obj' value=$event.obj}
{assign var='tab' value=$event.tab}
<div class="event">
  <div class="event_header">
    <div class="event_date">{$obj->getDate()|date_format:"%H:%M"}</div>
    <div class="event_lieu"><a href="/lieux/{$tab.lieu_id}" title="{$tab.lieu_name|escape}"><strong>{$tab.lieu_name|escape}</strong></a><br>{$tab.lieu_id_departement} {$tab.lieu_city}</div>
  </div>
  <div class="event_content">
    <span class="event_title" style="position: relative;">
      <div class="edit-event" style="display: none; position: absolute; right: 5px; top: 0;">
        <ul style="text-align: right;">
          <li style="margin-bottom: 2px; padding-right: 3px;"><a href="/events/edit/{$obj->getId()}"><img src="/img/icones/gear.png" alt=""></a></li>
          <li style="border: 1px solid #fff; margin-bottom: 2px; background-color: #333; padding: 3px;"><a href="/events/edit/{$obj->getId()}">Editer <img src="/img/icones/event_edit.png" alt=""></a></li>
          <li style="border: 1px solid #fff; margin-bottom: 2px; background-color: #333; padding: 3px;"><a href="/photos/create?id_event={$obj->getId()}">Ajout photo <img src="/img/icones/photo_add.png" alt=""></a></li>
          <li style="border: 1px solid #fff; margin-bottom: 2px; background-color: #333; padding: 3px;"><a href="/videos/create?id_event={$obj->getId()}">Ajout vidéo <img src="/img/icones/video_add.png" alt=""></a></li>
          <li style="border: 1px solid #fff; margin-bottom: 2px; background-color: #333; padding: 3px;"><a href="/audios/create?id_event={$obj->getId()}">Ajout audio <img src="/img/icones/audio_add.png" alt=""></a></li>
        </ul>
      </div>
      <a href="{$obj->getUrl()|escape}"><strong>{$obj->getName()|upper|escape}</strong></a>
    </span>
    <div class="event_body">
      {if $obj->getFlyer100Url()}
      <a href="{$obj->getUrl()}"><img src="{$obj->getFlyer100Url()}" style="float: right;" alt="{$obj->getName()|escape}"></a>
      {/if}
      {$obj->getText()|@nl2br}
      <ul>
      {foreach from=$obj->getGroupes() item=groupe}
        <li><a href="{$groupe.url|escape}"><strong>{$groupe.name|escape}</strong></a> ({$groupe.style|escape})</li>
      {/foreach}
      </ul>
      <p class="event_price">{$obj->getPrice()|escape|@nl2br}</p>
      <a style="margin: 10px 0; padding: 5px; border: 1px solid #999" href="/events/ical/{$obj->getId()}.ics"><img src="/img/icones/cal.svg" width="16" height="16">Ajout au calendrier</a>
      <br class="clear" style="clear: both;">
    </div>
  </div>
  {if $obj->getNbVideos() || $obj->getNbPhotos() || $obj->getNbAudios()}
  <div class="event_footer">
    <div class="event_media">
      <span class="event_media_video"><a href="{$obj->getUrl()}">({$obj->getNbVideos()})</a></span>
      <span class="event_media_photo"><a href="{$obj->getUrl()}">({$obj->getNbPhotos()})</a></span>
      <span class="event_media_audio"><a href="{$obj->getUrl()}">({$obj->getNbAudios()})</a></span>
    </div>
  </div>
  {/if}
</div>{* event *}
{/foreach}
</div>{* events_of_the_day *}
{/foreach}

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

</div>{* .box-content *}
</div>{* .box *}

<div class="col-1">
{calendar year=$year month=$month day=$day}
</div>

</div>{* .grid-3-small-1 *}

{include file="common/footer.tpl"}
