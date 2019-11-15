{include file="common/header.tpl"}

<div id="swipe" class="swipe clearfix mbs">
  <ul class="swipe-wrap">
    {foreach from=$featured key=idx item=f}
    <li data-index="{$idx}">
      <a href="{$f->getLink()}">
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
        <a href="{$f->getLink()}"></a>
      </li>
      {/foreach}
    </ul>
  </div>
</div>

<div class="grid-2-small-1 has-gutter">

  <div class="col-1">

  <div class="box">
    <header>
      <h2><a href="/events" title="Agenda">Agenda</a></h2>
    </header>
    <div class="reset">
      <ul>
      {foreach from=$evts key=month item=mevts}
        <li class="mbs">
          <strong>{$month|date_format:"%B %Y"|capitalize}</strong>
          <ul>
          {foreach from=$mevts key=month item=evt}
            <li><span style="font-weight: bold; color: #cc0000;" title="{$evt->getDate()|date_format:"%A %e %B à %H:%M"}">{$evt->getDate()|date_format:"%d"}</span> <a href="{$evt->getUrl()}" title="{$evt->getName()|escape}">{$evt->getName()|truncate:'40'|escape}</a></li>
          {/foreach}
          </ul>
        </li>
      {/foreach}
      </ul>
    </div>
  </div>

  </div>

  <div class="col-1">

    <div class="box">
      <header>
        <h2>Souvenez vous</h2>
      </header>
      <div class="reset">
        {foreach from=$videos item=video}
        <div class="thumb-80">
          <a href="{$video->getUrl()}"><img src="{$video->getThumb80Url()}" alt="{$video->getName()|escape}{if !empty($video->getGroupe())} ({$video->getGroupe->getName()|escape}){/if}"></a>
          <a class="overlay-80 overlay-video-80" href="{$video->getUrl()}" title="Regarder {$video->geName()|escape}{if !empty($video->getGroupe())} ({$video->getGroupe->getName()|escape}){/if}"></a>
        </div>
        {/foreach}
      </div>
    </div>

  </div>

</div>

{include file="common/footer.tpl"}
