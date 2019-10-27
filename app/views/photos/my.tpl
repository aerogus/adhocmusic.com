{include file="common/header.tpl"}

<div class="box">
  <header>
    <h2>Mes photos</h2>
  </header>
  <div class="reset">

{if !empty($create)}<p class="infobulle success">Photo ajoutée</p>{/if}
{if !empty($edit)}<p class="infobulle success">Photo modifiée</p>{/if}
{if !empty($delete)}<p class="infobulle success">Photo supprimée</p>{/if}

<a href="/photos/create" class="button">Ajouter une photo</a>

{if $photos|@count == 0}

<p>Aucune photo</p>

{else}

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

<div class="gallery">
{foreach from=$photos item=photo}
  <div class="photo">
    <a href="/photos/edit/{$photo.id}?page={$page}" title="{$photo.name|escape}{if !empty($photo.groupe_name)} ({$photo.groupe_name|escape}){/if}">
      <img src="{$photo.thumb_320}" alt="{$photo.name|escape}{if !empty($photo.groupe_name)} ({$photo.groupe_name|escape}){/if}">
    </a>
  </div>
{/foreach}
</div>

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

{/if}

<a href="/photos/create" class="button">Ajouter une photo</a>

  </div>
</div>

{include file="common/footer.tpl"}
