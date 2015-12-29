{if !$search_media|@sizeof}
<p class="error">Aucun résultat</p>
{else}
{foreach from=$search_media item=media}
<div class="search-box-result">
  <div class="search-box-result-{$media.type}">
    <div class="thumb-80">
      <a href="{$media.url}"><img src="{$media.thumb_80_80}" style="width: 80px; height: 80px; float: left; margin-right: 2px;" alt="{$media.name|escape}" />{$media.name|truncate:15:"...":true:true|escape}</a>
      <a class="overlay-80 overlay-{$media.type}-80" href="{$media.url}" title="{$media.name|escape}"></a>
    </div>
  </div>
</div>
{/foreach}
{/if}
