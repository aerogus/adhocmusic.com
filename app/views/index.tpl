{include file="common/header.tpl"}

<div class="txtcenter italic mas">Association œuvrant pour le développement des musiques actuelles à Épinay-sur-Orge (Essonne) depuis 1998</div>

<div id="swipe" class="swipe clearfix">
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

<div class="txtcenter infobulle info">À venir : <a href="/events/6837">Vendredi 16 mars 2018 - AfterWork S03E06</a></div>

<div class="grid-3-tiny-2-small-1 has-gutter-l">

  <div class="box">
    <header>
      <h2>Actualité</h2>
    </header>
    <div class="pa0" style="padding: 0">
      <div class="fb-page" data-href="https://www.facebook.com/adhocmusic" data-tabs="timeline" data-width="320" data-height="320" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/adhocmusic"><a href="https://www.facebook.com/adhocmusic">AD’HOC</a></blockquote></div></div>
    </div>
  </div>

<div class="box">
  <header>
    <h2><a href="/events/" title="Agenda">Agenda</a></h2>
  </header>
  <div>
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

{include file="common/footer.tpl"}
