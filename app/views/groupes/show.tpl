{include file="common/header.tpl"}

{if !empty($unknown_group)}

<p class="infobulle error">Ce groupe est introuvable !</p>

{else}

<div class="grid-2-small-1-tiny-1 has-gutter-l">

  <div>{* colonne 1 *}

    <div class="box">
      <header>
        <h1>{$groupe->getName()}</h1>
      </header>
      <div>
        {if $groupe->getLogo()}
        <p align="center"><img src="{$groupe->getLogo()}" alt="{$groupe->getName()|escape}"></p>
        {/if}
        {if $groupe->getStyle()}
        <p><strong>Style</strong><br>{$groupe->getStyle()|escape}</p>
        {/if}
        {if $groupe->getInfluences()}
        <p><strong>Influences</strong><br>{$groupe->getInfluences()|escape}</p>
        {/if}
        {if $groupe->getLineup()}
        <p><strong>Membres</strong><br>{$groupe->getLineup()|escape|@nl2br}</p>
        {/if}
        <p><strong>Dont membres AD'HOC</strong></p>
        {if $membres|@count > 0}
        <ul>
          {foreach $membres as $membre}
          <li><a href="{$membre.url}">{$membre.pseudo|escape}</a> ({$membre.nom_type_musicien|escape})</li>
          {/foreach}
        </ul>
        {else}
        <p class="infobulle warning">Aucun! Vous faites partie de ce groupe ? <a href="/contact">contactez nous</a></p>
        {/if}
        <p><strong>Liens</strong></p>
        <ul class="grplinks">
          {if $groupe->getSite()}
          <li><a href="{$groupe->getSite()}" title="Site"><img src="/img/icones/lien.png" alt="">Site</a></li>
          {/if}
          {if $groupe->getFacebookPageId()}
          <li><a href="{$groupe->getFacebookPageUrl()}" title="Facebook"><img src="/img/facebook.gif" alt="">Facebook</a></li>
          {/if}
          {if $groupe->getTwitterId()}
          <li><a href="{$groupe->getTwitterUrl()}" title="Twitter"><img src="/img/icones/twitter.png" alt="">Twitter</a></li>
          {/if}
        </ul>
        {if $groupe->getCreatedOn()}
        <p><strong>Fiche créée le</strong><br>{$groupe->getCreatedOn()|date_format:"%d/%m/%Y %H:%M"}</p>
        {/if}
        {if $groupe->getModifiedOn()}
        <p><strong>Mise à jour le</strong><br>{$groupe->getModifiedOn()|date_format:"%d/%m/%Y %H:%M"}</p>
        {/if}
      </div>
    </div>

    {if $videos|@count > 0}
    <div class="box">
      <header>
        <h2>Vidéos</h2>
      </header>
      <div>
        {foreach $videos as $video}
        <div class="thumb-80">
          <a href="{$video.url}" title="{$video.name|escape}"><img src="{$video.thumb_80_80}" alt="{$video.name|escape}">{$video.name|truncate:15:"...":true:true|escape}</a>
          <a class="overlay-80 overlay-video-80" href="{$video.url}" title="{$video.name|escape}"></a>
        </div>
        {/foreach}
      </div>
    </div>
    {/if}

    {if $audios|@count > 0}
    <div class="box">
      <header>
        <h2>En Écoute</h2>
      </header>
      <div>  
      <ul>
        {foreach $audios as $audio}
	    <li><a href="{$audio.url}">{$audio.name}</a><br><audio controls="controls" src="{$audio.direct_url}" style="background-color:#000"></audio></li>
        {/foreach}
      </ul>
      </div>
    </div>
    {/if}

  </div>
  <div>{* colonne 2 *}

    <div class="box">
      <header>
        <h1>Présentation</h1>
      </header>
      <div>
        {if $groupe->getPhoto()}
        <img src="{$groupe->getPhoto()}" alt="{$groupe->getName()|escape}" title="{$groupe->getName()|escape}">
        {/if}
        <p align="justify">{$groupe->getText()|nl2br}</p>
        {include file="comments/share.tpl" title="ce groupe" url=$groupe->getUrl()}
        {if !empty($alerting_sub_url)}
        <div class="alerting-sub"><a href="{$alerting_sub_url}">S'abonner à ce groupe</a></div>
        {elseif !empty($alerting_unsub_url)}
        <div class="alerting-unsub"><a href="{$alerting_unsub_url}">Se désabonner de ce groupe</a></div>
        {elseif !empty($alerting_auth_url)}
        <div class="alerting-auth"><a href="{$alerting_auth_url}">S'abonner à ce groupe</a></div>
        {/if}
      </div>
    </div>

    {if $photos|@count > 0}
    <div class="box">
      <header>
        <h2>Photos</h2>
      </header>
      <div>
        {foreach $photos as $photo}
        <div class="thumb-80">
          <a href="{$photo.url}" title="{$photo.name|escape}"><img src="{$photo.thumb_80_80}" alt="{$photo.name|escape}" style="display:block"></a>
          <a class="overlay-80 overlay-photo-80" href="{$photo.url}" title="{$photo.name|escape}"></a>
        </div>
        {/foreach}
      </div>
    </div>
    {/if}

    {if $f_events|@count > 0}
    <div class="box">
      <header>
        <h2>Concerts à venir</h2>
      </header>
      <div>
        <ul>
          {foreach $f_events as $event}
          <li><a href="/events/{$event.id|escape}">{$event.date|date_format:'%d/%m/%Y %H:%M'} - {$event.lieu_name|escape}</a></li>
          {/foreach}
        </ul>
      </div>
    </div>
    {/if}

    {if $p_events|@count > 0}
    <div class="box">
      <header>
        <h2>Concerts passés</h2>
      </header>
      <div>
        <ul>
          {foreach $p_events as $event}
          <li><a href="/events/{$event.id|escape}">{$event.date|date_format:'%d/%m/%Y %H:%M'} - {$event.lieu_name|escape}</a></li>
          {/foreach}
        </ul>
      </div>
    </div>
    {/if}

  </div>

</div>

{/if} {* test unknown group *}

{include file="common/footer.tpl"}
