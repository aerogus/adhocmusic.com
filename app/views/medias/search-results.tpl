{if !$search_video|@count}
<p class="infobulle error">Aucun résultat</p>
{else}
{foreach from=$search_video item=video}
<div class="search-box-result">
  <div class="search-box-result-video">
    <div class="thumb-80">
      <a href="{$video->getUrl()}"><img src="{$video->getThumbUrl(80)}" style="width: 80px; height: 80px; float: left; margin-right: 2px;" alt="{$video->getName()|escape}" />{$video->getName()|truncate:15:"...":true:true|escape}</a>
      <a class="overlay-80 overlay-video-80" href="{$video->getUrl()}" title="{$video->getName()|escape}"></a>
    </div>
  </div>
</div>
{/foreach}
{/if}
