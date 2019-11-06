{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Mes vidéos</h1>
  </header>
  <div>

<a href="/videos/create" class="button">Ajouter une vidéo</a>

{if $nb_items > 0}

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

{foreach $videos as $video}
<div class="video-list" style="margin: 10px; background-color: #ececec;">
<a href="/videos/edit/{$video.id}"><img src="{$video.thumb_80_80}" style="float: left; margin-right: 10px;"/></a>
<img src="/img/icones/signature.png"> <a href="/videos/edit/{$video.id}"><strong>{$video.name|escape}</strong></a><br>
{if $video.groupe_id}
 <img src="/img/icones/groupe.png"> {$video.groupe_name|escape}
{/if}
{if $video.event_id}
 <img src="/img/icones/event.png"> {$video.event_name|escape}
{/if}
{if $video.lieu_id}
 <img src="/img/icones/lieu.png"> {$video.lieu_name|escape}
{/if}
<br><img src="/img/icones/eye.png"> {if $video.online}<span style="color: #00ff00;">En Ligne</span>{else}<span style="color: #ff0000">Hors Ligne</span>{/if}
<br style="clear: both">
</div>
{/foreach}

<br style="clear: both">

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

{else}

<p>Aucune vidéo</p>

{/if}

<a href="/videos/create" class="button">Ajouter une vidéo</a>

  </div>
</div>

{include file="common/footer.tpl"}
