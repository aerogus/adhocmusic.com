{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Mes photos</h1>
  </header>
  <div class="reset">

{if !empty($create)}<p class="infobulle success">Photo ajoutée</p>{/if}
{if !empty($edit)}<p class="infobulle success">Photo modifiée</p>{/if}
{if !empty($delete)}<p class="infobulle success">Photo supprimée</p>{/if}

<div class="txtcenter mbs">
<a href="/photos/create" class="btn btn--primary">Ajouter une photo</a>
</div>

{if $photos|@count == 0}

<p>Aucune photo</p>

{else}

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

<div class="gallery">
{foreach from=$photos item=photo}
  <div class="photo">
    <a href="/photos/edit/{$photo->getIdPhoto()}?page={$page}" title="{$photo->getName()|escape}{if !empty($photo->getGroupe())} ({$photo->getGroupe()->getName()|escape}){/if}">
      <img src="{$photo->getThumbUrl(320)}" alt="{$photo->getName()|escape}{if !empty($photo->getGroupe())} ({$photo->getGroupe()->getName()|escape}){/if}">
    </a>
  </div>
{/foreach}
</div>

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

{/if}

<div class="txtcenter mbs">
  <a href="/photos/create" class="btn btn--primary">Ajouter une photo</a>
</div>

  </div>
</div>

{include file="common/footer.tpl"}
