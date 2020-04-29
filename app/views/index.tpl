{include file="common/header.tpl"}

<div id="swipe" class="swipe clearfix mts mbs">
  <ul class="swipe-wrap">
    {foreach from=$featured key=idx item=f}
    <li data-index="{$idx}">
      <a href="{$f->getUrl()}">
        <h2>{$f->getTitle()}<br><span>{$f->getDescription()}</span></h2>
        <img src="{$f->getImage()}" title="{$f->getDescription()}" alt="">
      </a>
    </li>
    {/foreach}
  </ul>
  <div class="swipe-pagination-wrapper">
    <ul class="swipe-pagination">
      {foreach from=$featured key=idx item=f}
      <li data-index="{$idx}">
        <a href="{$f->getUrl()}"></a>
      </li>
      {/foreach}
    </ul>
  </div>
</div>

<div class="grid-3-small-1 has-gutter">

  <div class="col-2">

    <div class="box">
      <header>
        <h2>Ils sont passés par AD'HOC</h2>
      </header>
      <div class="reset grid-3-small-2 has-gutter">
        {foreach from=$videos item=video}
        <div class="video">
          <div class="thumb" style="background-image: url({$video->getThumbUrl(320)})">
            <a class="playbtn" href="{$video->getUrl()}" title="Lire la vidéo {$video->getName()|escape}">▶</a>
          </div>
          <p class="title"><a href="{$video->getUrl()}" title="Lire la vidéo {$video->getName()|escape}">{$video->getName()}</a></p>
          <p class="subtitle">
            {if !empty($video->getGroupe())}<a href="{$video->getGroupe()->getUrl()}" title="Aller à la page du groupe {$video->getGroupe()->getName()|escape}">{$video->getGroupe()->getName()}</a>{/if}
            {if !empty($video->getGroupe()) && !empty($video->getEvent())}<br/>{/if}
            {if !empty($video->getEvent())}<a href="{$video->getEvent()->getUrl()}" title="Aller à la page de l'événement {$video->getEvent()->getName()|escape}">{$video->getEvent()->getDate()|date_format:"%a %e %B %Y"}</a>{/if}
          </p>
        </div>
        {/foreach}
      </div>
    </div>

  </div>

  <div class="col-1">

  <div class="box">
    <header>
      <h2><a href="/events" title="Agenda">Agenda</a></h2>
    </header>
    <div>
      {if $events|@count > 0}
      <ul>
      {foreach from=$events key=month item=month_events}
        <li class="mbs">
          <strong>{$month|date_format:"%B %Y"|capitalize}</strong>
          <ul>
          {foreach from=$month_events key=month item=event}
            <li><span style="font-weight: bold; color: #cc0000;" title="{$event->getDate()|date_format:"%A %e %B à %H:%M"}">{$event->getDate()|date_format:"%d"}</span> <a href="{$event->getUrl()}" title="{$event->getName()|escape}">{$event->getName()|truncate:'40'|escape}</a></li>
          {/foreach}
          </ul>
        </li>
      {/foreach}
      </ul>
      {else}
      aucun événement annoncé
      {/if}
    </div>
  </div>

  </div>

</div>

{include file="common/footer.tpl"}
