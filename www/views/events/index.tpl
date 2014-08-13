{include file="common/header.tpl" js_jquery_ui=true css_jquery_ui=true js_jquery_ui_datepicker=true}

<script>
$(function() {

  $('.event_title').hover(
    function() { $(this).children('.edit-event').show(); },
    function() { $(this).children('.edit-event').hide(); }
  );

  $('.fb-event-attending').click(function() {
    rsvp($(this).parent().attr('id').replace('fb-event-', ''), 'attending');
  });

  $('.fb-event-maybe').click(function() {
    rsvp($(this).parent().attr('id').replace('fb-event-', ''), 'maybe');
  });

  $('.fb-event-declined').click(function() {
    rsvp($(this).parent().attr('id').replace('fb-event-', ''), 'declined');
  });

  function rsvp(id_event, action)
  {
    $.ajax( {
      type: 'POST',
      url: 'https://graph.facebook.com/' + id_event + '/' + action,
      data: { access_token: $('#fb-access-token').val() }
    });
  }
});
</script>

<style>
.fb-event-button, .fb-event-button:hover {
    border: 1px solid #29447e;
    padding: 4px;
    background-color: #5c75a9;
    color: #ffffff !important;
    font-weight: bold;
    text-decoration: none;
}
</style>

<div id="right">

{calendar year=$year month=$month day=$day}

</div>

<div id="left-center">

{include file="common/boxstart.tpl" boxtitle="Agenda"}

{if !sizeof($events)}
<p>Aucune date annoncée pour cette période. <a href="/events/create">Inscrire une date</a></p>
{/if}

{if !empty($create)}<p class="success">Evénement ajouté</p>{/if}
{if !empty($edit)}<p class="success">Evénement modifié</p>{/if}
{if !empty($delete)}<p class="success">Evénement supprimé</p>{/if}

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
    <div class="event_lieu"><a href="/lieux/show/{$tab.lieu_id}" title="{$tab.lieu_name|escape}"><strong>{$tab.lieu_name|escape}</strong></a><br />({$tab.lieu_id_departement} - {$tab.lieu_city})<br />à {$tab.lieu_distance} km</div>
  </div>
  <div class="event_content">
    <span class="event_title" style="position: relative;">
      <div class="edit-event" style="display: none; position: absolute; right: 5px; top: 0;">
        <ul style="text-align: right;">
          <li style="margin-bottom: 2px; padding-right: 3px;"><a href="/events/edit/{$obj->getId()}"><img src="{#STATIC_URL#}/img/icones/gear.png" alt="" /></a></li>
          <li style="border: 1px solid #fff; margin-bottom: 2px; background-color: #333; padding: 3px;"><a href="/events/edit/{$obj->getId()}">Editer <img src="{#STATIC_URL#}/img/icones/event_edit.png" alt="" /></a></li>
          <li style="border: 1px solid #fff; margin-bottom: 2px; background-color: #333; padding: 3px;"><a href="/photos/create?id_event={$obj->getId()}">Ajout photo <img src="{#STATIC_URL#}/img/icones/photo_add.png" alt="" /></a></li>
          <li style="border: 1px solid #fff; margin-bottom: 2px; background-color: #333; padding: 3px;"><a href="/videos/create?id_event={$obj->getId()}">Ajout vidéo <img src="{#STATIC_URL#}/img/icones/video_add.png" alt="" /></a></li>
          <li style="border: 1px solid #fff; margin-bottom: 2px; background-color: #333; padding: 3px;"><a href="/audios/create?id_event={$obj->getId()}">Ajout audio <img src="{#STATIC_URL#}/img/icones/audio_add.png" alt="" /></a></li>
        </ul>
      </div>
      <a href="{$obj->getUrl()|escape}"><strong>{$obj->getName()|upper|escape}</strong></a>
    </span>
    <div class="event_body">
      {if $obj->getFlyer100Url()}
      <a href="{$obj->getUrl()}"><img src="{$obj->getFlyer100Url()}" style="float: right;" alt="{$obj->getName()|escape}" /></a>
      {/if}
      {$obj->getText()|@nl2br}
      <ul>
      {foreach from=$obj->getGroupes() item=groupe}
        <li><a href="{$groupe.url|escape}"><strong>{$groupe.name|escape}</strong></a> ({$groupe.style|escape})</li>
      {/foreach}
      </ul>
      <p class="event_price">{$obj->getPrice()|escape|@nl2br}</p>
      {if $obj->getFacebookEventId()}
      <p class="event_facebook" id="fb-event-{$obj->getFacebookEventId()}">
        <a href="{$obj->getFacebookEventUrl()}">{$obj->getFacebookEventAttending()} participants</a>
        <a href="#" class="fb-event-button fb-event-attending">J'y vais</a>
        <a href="#" class="fb-event-button fb-event-maybe">Peut-être</a>
        <a href="#" class="fb-event-button fb-event-declined">Non merci</a>
      </p>
      {/if}
      <br class="clear" style="clear: both;" />
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
</div>
{/foreach}
</div>
{/foreach}

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

{include file="common/boxend.tpl"}

</div>

{include file="common/footer.tpl"}
