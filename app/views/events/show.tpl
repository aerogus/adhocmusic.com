{include file="common/header.tpl"}

{if !empty($unknown_event)}

<p class="infobulle error">Cet événement est introuvable</p>

{else}

<div class="box">
  <header>
    <h1>{$event->getName()}</h1>
  </header>
  <div>

    {if $event->getThumbUrl()}
    <img src="{$event->getThumbUrl(320)}" alt="{$event->getName()|escape}" style="display: block; margin: 0 auto 10px;">
    {/if}

    {if !empty($event->getGroupes())}
    <p>Avec :</p>
    <ul class="grid-3">
    {foreach from=$event->getGroupes() item=groupe}
      <li><a href="{$groupe->getUrl()}"><img src="{$groupe->getMiniPhoto()}" style="float: left; margin: 2px; border: 1px solid #777" alt=""></a><a href="{$groupe->getUrl()}"><strong>{$groupe->getName()|escape}</strong></a><br>({$groupe->getStyle()|escape})</li>
    {/foreach}
    </ul>
    {/if}

    <div id="event-box-info">
      <p><strong>Le {$jour} à {$heure}</strong></p>
      <a href="/lieux/{$event->getLieu()->getIdLieu()}" title="{$event->getLieu()->getName()|escape}">
        <strong>{$event->getLieu()->getName()|escape}</strong><br>
        {$event->getLieu()->getAddress()}<br>
        {$event->getLieu()->getCity()->getCp()} - {$event->getLieu()->getCity()->getName()|escape}
      </a>
      <p>Entrée : <strong>{$event->getPrice()|escape}</strong></p>
    </div>

    {if $event->getFacebookEventId()}
    <p class="event_facebook" align="center">
      <a style="padding: 1rem; color: #fff; background-color: #3b5998" href="{$event->getFacebookEventUrl()}">Événement Facebook</a>
    </p>
    {/if}
  
    <p align="justify">{$event->getText()|escape|@nl2br}</p>

    {if !empty($structures)}
    <p>Organisateur :</p>
    <ul>
    {foreach from=$structures item=structure}
      <li><img src="{$structure->getPicto()}" alt="" title="{$structure->getName()}"><strong>{$structure->getName()|escape}</strong></li>
    {/foreach}
    </ul>
    {/if}

  </div>
</div>{* .box *}

{if !empty($audios)}
<div class="box">
  <header>
    <h2>Sons</h2>
  </header>
  <div>
    <ul>
    {foreach from=$audios item=audio}
      <li><strong>{$audio->getName()|escape}</strong>{if !empty($audio->getGroupe())} (<a href="{$audio->getGroupe()->getUrl()}">{$audio->getGroupe()->getName()|escape}</a>){/if}<br><audio controls src="{$audio->getDirectMp3Url()}"></audio></li>
    {/foreach}
    </ul>
  </div>
</div>
{/if}

{if !empty($videos)}
<div class="box">
  <header>
    <h2>Vidéos</h2>
  </header>
  <div class="reset grid-3-small-2 has-gutter">
    {foreach from=$videos item=video}
    <div class="video">
      <div class="thumb" style="background-image: url({$video->getThumbUrl(320)})">
        <a class="playbtn" href="{$video->getUrl()}">▶</a>
      </div>
      <p class="title"><a href="{$video->getUrl()}">{$video->getName()|escape}</a></p>
      <p class="subtitle">{if !empty($video->getGroupe())}{$video->getGroupe()->getName()|escape}{/if}</p>
    </div>
    {/foreach}
  </div>
</div>
{/if}

{if !empty($photos)}
<div class="box">
  <header>
    <h2>Photos</h2>
  </header>
  <div class="reset gallery">
  {foreach from=$photos item=photo}
    <div class="photo">
      <a href="{$photo->getThumbUrl(1000)}" data-at-1000="{$photo->getThumbUrl(1000)}" title="{$photo->getName()|escape}{if !empty($photo->getGroupe())} ({$photo->getGroupe()->getName()|escape}){/if}">
        <img data-id="{$photo->getIdPhoto()}" src="{$photo->getThumbUrl(320)}" alt="{$photo->getName()|escape}{if !empty($photo->getGroupe())} ({$photo->getGroupe()->getName()|escape}){/if}">
      </a>
    </div>
  {/foreach}
  </div>
</div>
{/if}

{/if} {* test unknown event *}

{include file="common/footer.tpl"}
