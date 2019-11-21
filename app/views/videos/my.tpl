{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Mes vidéos</h1>
  </header>
  <div class="reset">

<a href="/videos/create" class="button">Ajouter une vidéo</a>

{if $nb_items > 0}

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

<div class="gallery">
{foreach $videos as $video}
  <div class="photo">
    <a href="/videos/edit/{$video->getIdVideo()}?page={$page}" title="{$video->getName()|escape}{if !empty($video->getGroupe())} ({$video->getGroupe()->getName()|escape}){/if}">
      <img src="{$video->getThumbUrl(320)}" alt="{$video->getName()|escape}{if !empty($video->getGroupe())} ({$video->getGroupe()->getName()|escape}){/if}">
    </a>
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
