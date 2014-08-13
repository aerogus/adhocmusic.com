{include file="fb/adhocbandpage/tab/common/header.tpl"}

{include file="fb/adhocbandpage/tab/common/boxstart.tpl" title=$groupe->getName()|escape}

{if $groupe->getLogo()}
<p align="center"><img src="{$groupe->getLogo()}" alt="{$groupe->getName()}" /></p>
{/if}

{if $groupe->getStyle()}
<p><strong>Style</strong><br />{$groupe->getStyle()|escape}</p>
{/if}

{if $groupe->getInfluences()}
<p><strong>Influences</strong><br />{$groupe->getInfluences()|escape}</p>
{/if}

{if $groupe->getLineup()}
<p><strong>Membres</strong><br />{$groupe->getLineup()|escape|@nl2br}</p>
{/if}

<p><strong>Dont membres Facebook</strong></p>
{foreach from=$groupe->getMembers() item=membre}
  {if $membre.facebook_profile_id > 0}
  <div style="float: left; margin: 3px">
    <a href="http://www.facebook.com/profile.php?id={$membre.facebook_profile_id}"><img src="http://graph.facebook.com/{$membre.facebook_profile_id}/picture" alt="" /><br />{$membre.pseudo|escape}</a><br />({$membre.nom_type_musicien|escape})
  </div>
  {/if}
{/foreach}
<br style="clear: both" />

<p>
<img src="{#STATIC_URL#}/media/structure/1.png" width="16" height="16" alt="" />
<a href="{$groupe->getUrl()}" title="Fiche AD'HOC"><strong>{$groupe->getUrl()}</strong></a>
</p>

{if $groupe->getSite()}
<p>
<img src="{#STATIC_URL#}/img/icones/lien.png" width="16" height="16" alt="" />
<a href="{$groupe->getSite()}" title="Site Officiel" class="extlink"><strong>{$groupe->getSite()|escape}</strong></a>
</p>
{/if}

{if $groupe->getCreatedOn()}
<p><strong>Fiche créée le</strong> : {$groupe->getCreatedOn()|date_format:"%d/%m/%Y %H:%M"}</p>
{/if}

{if $groupe->getModifiedOn()}
<p><strong>Mise à jour le</strong> : {$groupe->getModifiedOn()|date_format:"%d/%m/%Y %H:%M"}</p>
{/if}

<p>{$groupe->getText()}</p>

{include file="fb/adhocbandpage/tab/common/boxend.tpl"}

{if $audios|@count > 0}
{include file="fb/adhocbandpage/tab/common/boxstart.tpl" title="En Ecoute"}
<div style="background: url({#STATIC_URL#}/img/player_adhoc.png); width: 360px; height: 218px; position: relative; margin: 0 auto;">
  <img src="{$groupe->getMiniPhoto()}" alt="" style="position: absolute; top: 28px; left: 14px;" />
  <div style="position: absolute; top: 27px; left: 90px;">{audio_player id=$groupe->getId() type='player_mp3_multi'}</div>
</div>
{include file="fb/adhocbandpage/tab/common/boxend.tpl"}
{/if}

{include file="fb/adhocbandpage/tab/common/boxstart.tpl" title="Vidéos"}
<div id="videos"></div>
{include file="fb/adhocbandpage/tab/common/boxend.tpl"}

<script>
$(function() {
  // fetch photos
  $.getJSON('http://api.adhocmusic.com/get-photos.json?groupe={$groupe->getId()}&limit=25', function(data) {
    var items = [];
    $.each(data, function(idx, photo) {
      items.push('<div class="thumb-80 thumb-photo-80">');
      items.push('<a href="' + photo.url +'"><img src="' + photo.thumb_80_80 + '" alt="' + photo.name + '" /></a>');
      items.push('<a class="overlay-80 overlay-photo-80" href="' + photo.url + '" title="' + photo.name + '"></a>');
      items.push('</div>');
    });
    $('#photos').html(items.join(''));
    FB.Canvas.setSize();

  });
  // fetch videos
  $.getJSON('http://api.adhocmusic.com/get-videos.json?groupe={$groupe->getId()}&limit=25', function(data) {
    var items = [];
    $.each(data, function(idx, video) {
      items.push('<div class="thumb-80 thumb-video-80">');
      items.push('<a href="' + video.url +'"><img src="' + video.thumb_80_80 + '" alt="' + video.name + '" /></a>');
      items.push('<a class="overlay-80 overlay-video-80" href="' + video.url + '" title="' + video.name + '"></a>');
      items.push('</div>');
    });
    $('#videos').html(items.join(''));
    FB.Canvas.setSize();
  });
  // todo: fetch audios
  // todo: fetch events futurs
  // todo: fetch events passés
});
</script>

{include file="fb/adhocbandpage/tab/common/boxstart.tpl" title="Photos"}
<div id="photos"></div>
{include file="fb/adhocbandpage/tab/common/boxend.tpl"}

{if $f_events|@count > 0}
{include file="fb/adhocbandpage/tab/common/boxstart.tpl" title="Agenda"}
<ul>
  {foreach from=$f_events item=event}
  <li><a href="http://www.adhocmusic.com/events/show/{$event.id|escape}">{$event.date|date_format:'%d/%m/%Y %H:%M'}</a> - <a href="http://www.adhocmusic.com/lieux/show/{$event.lieu_id|escape}">{$event.lieu_name|escape}</a></li>
  {/foreach}
</ul>
{include file="fb/adhocbandpage/tab/common/boxend.tpl"}
{/if}

{if $p_events|@count > 0}
{include file="fb/adhocbandpage/tab/common/boxstart.tpl" title="Concerts passés"}
<ul>
  {foreach from=$p_events item=event}
  <li><a href="http://www.adhocmusic.com/events/show/{$event.id|escape}">{$event.date|date_format:'%d/%m/%Y %H:%M'}</a> - <a href="http://www.adhocmusic.com/lieux/show/{$event.lieu_id|escape}">{$event.lieu_name|escape}</a></li>
  {/foreach}
</ul>
{include file="fb/adhocbandpage/tab/common/boxend.tpl"}
{/if}

{include file="fb/adhocbandpage/tab/common/footer.tpl"}
