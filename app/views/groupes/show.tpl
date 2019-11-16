{include file="common/header.tpl"}

{if !empty($unknown_group)}

<p class="infobulle error">Ce groupe est introuvable</p>

{else}

<div class="grid-2-small-1 has-gutter">

  <div class="col-1">

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
        {if $groupe->getSite() || $groupe->getFacebookPageId() || $groupe->getTwitterId()}
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
          <a href="{$video->getUrl()}" title="{$video->getName()|escape}"><img src="{$video->getThumbUrl(80)}" alt="{$video->getName()|escape}">{$video->getName()|truncate:15:"...":true:true|escape}</a>
          <a class="overlay-80 overlay-video-80" href="{$video->getUrl()}" title="{$video->getName()|escape}"></a>
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
        <li><a href="{$audio->getUrl()}">{$audio->getName()}</a><br><audio controls="controls" src="{$audio->getDirectMp3Url()}" style="background-color:#000"></audio></li>
        {/foreach}
      </ul>
      </div>
    </div>
    {/if}

  </div>
  <div class="col-1">{* colonne 2 *}

    <div class="box">
      <header>
        <h2>Présentation</h2>
      </header>
      <div>
        {if $groupe->getPhoto()}
        <img src="{$groupe->getPhoto()}" alt="{$groupe->getName()|escape}" title="{$groupe->getName()|escape}">
        {/if}
        <p align="justify">{$groupe->getText()|nl2br}</p>
      </div>
    </div>

    {if $f_events|@count > 0}
    <div class="box">
      <header>
        <h2>Évènements à venir</h2>
      </header>
      <div>
        <ul>
          {foreach $f_events as $event}
          <li><a href="{$event->getUrl()|escape}">{$event->getDate()|date_format:'%d/%m/%Y %H:%M'} - {$event->getLieu()->getName()|escape}</a></li>
          {/foreach}
        </ul>
      </div>
    </div>
    {/if}

    {if $p_events|@count > 0}
    <div class="box">
      <header>
        <h2>Évènements passés</h2>
      </header>
      <div>
        <ul>
          {foreach $p_events as $event}
          <li><a href="{$event->getUrl()|escape}">{$event->getDate()|date_format:'%d/%m/%Y %H:%M'} - {$event->getLieu()->getName()|escape}</a></li>
          {/foreach}
        </ul>
      </div>
    </div>
    {/if}

  </div>

</div>

{if !empty($photos)}
<div class="box">
  <header>
    <h2>Photos</h2>
  </header>
  <div class="reset gallery">
  {foreach from=$photos item=photo}
    <div class="photo">
      <a href="{$photo->getThumbUrl(1000)}" data-at-1000="{$photo->getThumbUrl(1000)}" title="{$photo->getName()|escape}{if !empty($photo->getGroupe())} ({$photo->getGroupe()->getName()|escape}){/if}">
        <img src="{$photo->getThumbUrl(320)}" alt="{$photo->getName()|escape}{if !empty($photo->getGroupe())} ({$photo->getGroupe()->getName()|escape}){/if}">
      </a>
    </div>
  {/foreach}
  </div>
</div>
{/if}

{/if} {* test unknown group *}

{include file="common/footer.tpl"}
