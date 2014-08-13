<script>
$(function() {
  // thumbnail photo et video et audio
  $(".thumb-80").hover(function() {
    $(this).css( {
      '-webkit-transform': 'rotate(0deg) scale(1.2)',
      '-moz-transform': 'rotate(0deg) scale(1.2)',
      '-o-transform': 'rotate(0deg) scale(1.2)',
      '-ms-transform': 'rotate(0deg) scale(1.2)',
      'z-index': 50
    });
  } , function() {
    $(this).css( {
      '-webkit-transform': 'rotate(0deg) scale(1.0)',
      '-moz-transform': 'rotate(0deg) scale(1.0)',
      '-o-transform': 'rotate(0deg) scale(1.0)',
      '-ms-transform': 'rotate(0deg) scale(1.0)',
      'z-index': 1
    });
  });
});
</script>

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
