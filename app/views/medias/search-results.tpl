{if !$search_video|@count}
<p class="infobulle error">Aucun résultat</p>
{else}
<div class="grid-3-small-2 has-gutter">
{foreach from=$search_video item=video}
  <div class="video">
    <div class="thumb" style="background-image: url({$video->getThumbUrl(320)})">
      <a class="playbtn" href="{$video->getUrl()}">▶</a>
    </div>
    <p class="title"><a href="{$video->getUrl()}">{$video->getName()|escape}</a></p>
    <p class="subtitle">{if !empty($video->getGroupe())}{$video->getGroupe()->getName()|escape}{/if}<br/>{if !empty($video->getEvent())}{$video->getEvent()->getDate()|date_format:"d/m/Y"}{/if}</p>
  </div>
{/foreach}
</div>
{/if}
