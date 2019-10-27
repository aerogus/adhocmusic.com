{include file="common/header.tpl"}

<div id="swipe" class="swipe clearfix mbs">
  <ul class="swipe-wrap">
    {foreach from=$featured key=idx item=f}
    <li data-index="{$idx}">
      <a href="{$f.link}">
        <h2>{$f.title}<br><span>{$f.description}</span></h2>
        <img src="{$f.image}" title="{$f.description}" alt="">
      </a>
    </li>
    {/foreach}
  </ul>
  <div class="swipe-pagination-wrapper">
    <ul class="swipe-pagination">
      {foreach from=$featured key=idx item=f}
      <li data-index="{$idx}">
        <a href="{$f.link}"></a>
      </li>
      {/foreach}
    </ul>
  </div>
</div>

<div class="grid-2-small-1 has-gutter-l">

  <div class="col-1">

  <div class="box">
    <header>
      <h2><a href="/events/" title="Agenda">Agenda</a></h2>
    </header>
    <div class="reset">
      <ul>
      {foreach from=$evts key=month item=mevts}
        <li class="mbs">
          <strong>{$month|date_format:"%B %Y"|capitalize}</strong>
          <ul>
          {foreach from=$mevts key=month item=evt}
            <li><span style="font-weight: bold; color: #cc0000;" title="{$evt.date|date_format:"%A %e %B à %H:%M"}">{$evt.date|date_format:"%d"}</span> <a href="/events/{$evt.id}" title="{$evt.name|escape}">{$evt.name|truncate:'40'|escape}</a></li>
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
          <a href="{$video.url}"><img src="{$video.thumb_80_80}" alt="{$video.name|escape}{if !empty($video.groupe_name)} ({$video.groupe_name|escape}){/if}"></a>
          <a class="overlay-80 overlay-video-80" href="{$video.url}" title="Regarder {$video.name|escape}{if !empty($video.groupe_name)} ({$video.groupe_name|escape}){/if}"></a>
        </div>
        {/foreach}
      </div>
    </div>

  </div>

</div>

{include file="common/footer.tpl"}
