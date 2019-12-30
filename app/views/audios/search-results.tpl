{foreach from=$search_audios item=audio}
<div class="search-box-result">
<div class="search-box-result-audio">
  <div class="thumb-80">
    <a href="{$audio.url}"><img src="{$audio.thumb_80_80}" style="width: 80px; height: 80px; float: left; margin-right: 2px;" alt="{$audio.name|escape}"></a>
    <a class="overlay-80 overlay-audio-80" href="{$audio.url}" title="{$audio.name|escape}"></a>
  </div>
  <a href="{$audio.url}"><strong>{$audio.name|escape}</strong></a>
  {if $audio.groupe_id}
  <br><a href="/{$audio.groupe_alias}">{$audio.groupe_name|escape}</a>
  {/if}
  {if $audio.lieu_id}
  <br>{$audio.lieu_name|escape} ({$audio.event_date|date_format:'%d/%m/%Y'})
  {/if}
  <br style="clear: both">
</div>
</div>
{/foreach}
