{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Mes vidéos</h1>
  </header>
  <div class="reset">

<a href="/videos/create" class="button">Ajouter une vidéo</a>

{if $nb_items > 0}

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

<div class="grid-6-small-2 has-gutter">
  {foreach $videos as $video}
  <div class="video">
    <div class="thumb" style="background-image: url({$video->getThumbUrl(320)})">
      <a class="playbtn" href="{$video->getUrl()}">▶</a>
    </div>
    <p class="title"><a href="{$video->getUrl()}">{$video->getName()|escape}</a></p>
    <p class="subtitle">{if !empty($video->getGroupe())}{$video->getGroupe()->getName()|escape}{/if}</p>
  </div>
  {/foreach}
</div>

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

{else}

<p>Aucune vidéo</p>

{/if}

<a href="/videos/create" class="button">Ajouter une vidéo</a>

  </div>
</div>

{include file="common/footer.tpl"}
