{include file="common/header.tpl"}

<div id="swipe" class="swipe clearfix mbs">
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
        <h2>Souvenez vous</h2>
      </header>
      <div class="reset grid-2-small-1 has-gutter">
        {foreach from=$videos item=video}
        <div class="video">
          <a href="{$video->getUrl()}">
            <img src="{$video->getThumbUrl(320)}" alt="{$video->getName()|escape}{if !empty($video->getGroupe())} ({$video->getGroupe()->getName()|escape}){/if}">
            <strong style="display:block">{$video->getName()}</strong>
          </a>
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
    <div class="reset">
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
    </div>
  </div>

  </div>

</div>

{include file="common/footer.tpl"}
