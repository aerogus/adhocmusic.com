{include file="common/header.tpl"}

{if !empty($create)}<p class="infobulle success">Evénement ajouté</p>{/if}
{if !empty($edit)}<p class="infobulle success">Evénement modifié</p>{/if}
{if !empty($delete)}<p class="infobulle success">Evénement supprimé</p>{/if}

<div class="grid-3-small-1 has-gutter">

  <div class="box col-2-small-1">
    <header>
      <h1>Agenda</h1>
    </header>

    {if !count($events)}
    <div>
      <p>Aucune date annoncée pour cette période. <a href="/events/create">Inscrire un évènement</a></p>
    </div>
    {else}
    <div>

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

{foreach from=$events key=day item=events_of_the_day}
<div id="day-{$day|date_format:"%Y-%m-%d"}" class="events_of_the_day">
<h3>{$day|date_format:"%A %d %B %Y"}</h3>
{foreach from=$events_of_the_day item=event}
<div class="event grid-3-small-1">
  <div class="event_header col-1">
    <div class="event_date">{$event->getDate()|date_format:"%H:%M"}</div>
    <div class="event_lieu"><a href="/lieux/{$event->lieu->getId()}" title="{$event->lieu->getName()|escape}"><strong>{$event->lieu->getName()|escape}</strong></a><br>{$event->lieu->getIdDepartement()} {$event->lieu->getCity()}</div>
  </div>
  <div class="event_content col-2">
    <span class="event_title">
      <a href="{$event->getUrl()|escape}"><strong>{$event->getName()|upper|escape}</strong></a>
    </span>
    <div class="event_body">
      {if $event->getFlyer320Url()}
      <a href="{$event->getUrl()}"><img src="{$event->getFlyer320Url()}" style="float: right; margin: 0 0 5px 5px" alt="{$event->getName()|escape}"></a>
      {/if}
      {$event->getText()|@nl2br}
      <ul>
      {foreach from=$event->groupes item=groupe}
        <li><a href="{$groupe->getUrl()|escape}"><strong>{$groupe->getName()|escape}</strong></a> ({$groupe->getStyle()|escape})</li>
      {/foreach}
      </ul>
      <p class="event_price">{$event->getPrice()|escape|@nl2br}</p>
      <a style="margin: 10px 0; padding: 5px; border: 1px solid #999" href="/events/ical/{$event->getId()}.ics"><img src="/img/icones/cal.svg" width="16" height="16">Ajout au calendrier</a>
      <br class="clear" style="clear: both;">
    </div>
  </div>
</div>{* event *}
{/foreach}
</div>{* events_of_the_day *}
{/foreach}

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

  </div>
{/if}
</div>{* .box *}

<div class="col-1">
{calendar year=$year month=$month day=$day}
</div>

</div>{* .grid-3-small-1 *}

{include file="common/footer.tpl"}
