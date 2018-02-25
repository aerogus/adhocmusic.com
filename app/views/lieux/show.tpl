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

{include file="common/boxstart.tpl" boxtitle=$lieu->getName()|escape}

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

{include file="comments/share.tpl" title="ce lieu" url=$lieu->getUrl()}

{if !empty($alerting_sub_url)}
<div class="alerting-sub"><a href="{$alerting_sub_url}">S'abonner à ce lieu</a></div>
{elseif !empty($alerting_unsub_url)}
<div class="alerting-unsub"><a href="{$alerting_unsub_url}">Se désabonner de ce lieu</a></div>
{elseif !empty($alerting_auth_url)}
<div class="alerting-auth"><a href="{$alerting_auth_url}">S'abonner à ce lieu</a></div>
{/if}

{include file="comments/box.tpl" type="l" id_content=$lieu->getId()}

<div class="blocinfo">
<h3>Agenda</h3>
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

{if !empty($events_p)}
<div class="blocinfo">
<h3>Evénements passés</h3>
<ul>
{foreach from=$events_p item=event}
<li>{if $event.structure_id}<img src="{$event.structure_picto}" alt="" title="Organisé par {$event.structure_name|escape}">{/if}<a href="{$event.url}">Le {$event.date|date_format:"%d/%m/%Y %H:%M"} - {$event.name|escape}</a></li>
{/foreach}
</ul>
</div>
{/if}

{if !empty($photos)}
<div class="blocinfo">
<h3>Photos</h3>
{foreach from=$photos item=photo}
<div class="thumb-80">
  <a href="{$photo.url|escape}?from=lieu"><img src="{$photo.thumb_80_80}" alt="{$photo.name|escape}{if !empty($photo.groupe_name)} ({$photo.groupe_name|escape}){/if}">{$photo.name|truncate:15:"...":true:true|escape}</a>
  <a class="overlay-80 overlay-photo-80" href="{$photo.url}" title="{$photo.name|escape}{if !empty($photo.groupe_name)} ({$photo.groupe_name|escape}){/if}"></a>
</div>
{/foreach}
</div>
{/if}

{if !empty($audios)}
<div class="blocinfo">
<h3>Sons</h3>
<ul>
{foreach $audios as $audio}
<li>Titre : <strong>{$audio.name|escape}</strong><br>Groupe : <a href="http://www.adhocmusic.com/{$audio.groupe_alias}">{$audio.groupe_name}</a><br>Evénement : <a href="http://www.adhocmusic.com/events/show/{$audio.event_id}">{$audio.event_name}</a> ({$audio.event_date|date_format:'%d/%m/%Y'})<br>{audio_player id=$audio.id}</li>
{/foreach}
</ul>
</div>
{/if}

{if !empty($videos)}
<div class="blocinfo">
<h3>Vidéos</h3>
{foreach $videos as $video}
<div class="thumb-80">
  <a href="{$video.url}"><img src="{$video.thumb_80_80}" alt="{$video.name|escape}{if !empty($video.groupe_name)} ({$video.groupe_name|escape}){/if}">{$video.name|truncate:15:"...":true:true|escape}</a>
  <a class="overlay-80 overlay-video-80" href="{$video.url}" title="{$video.name|escape}{if !empty($video.groupe_name)} ({$video.groupe_name|escape}){/if}"></a>
</div>
{/foreach}
</div>
{/if}

{include file="common/boxend.tpl"}

{/if} {* test unknown lieu *}

{include file="common/footer.tpl"}
