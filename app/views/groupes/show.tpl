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
        <ul class="social-share-box">
          {if $groupe->getSite()}
          <li><a href="{$groupe->getSite()}" class="website" title="Site"><span>Site</span></a></li>
          {/if}
          {if $groupe->getFacebookPageId()}
          <li><a href="{$groupe->getFacebookPageUrl()}" class="facebook" title="Facebook"><span>Facebook</span></a></li>
          {/if}
          {if $groupe->getTwitterId()}
          <li><a href="{$groupe->getTwitterUrl()}" class="twitter" title="Twitter"><span>Twitter</span></a></li>
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
      <div class="reset grid-2 has-gutter">
        {foreach $videos as $video}
        <div class="video">
          <div class="thumb" style="background-image: url({$video->getThumbUrl(320)})">
            <a class="playbtn" href="{$video->getUrl()}">▶</a>
          </div>
          <p class="title"><a href="{$video->getUrl()}">{$video->getName()|escape}</a></p>
          <p class="subtitle">
            {if !empty($video->getEvent())}{$video->getEvent()->getName()|escape}
            <br/>
            {$video->getEvent()->getDate()|date_format:"%a %e %B %Y"}{/if}
          </p>
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
        <p align="center">
          <img src="{$groupe->getPhoto()}" alt="{$groupe->getName()|escape}" title="{$groupe->getName()|escape}">
        </p>
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
