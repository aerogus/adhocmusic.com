{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Mes photos"}

{if !empty($create)}<p class="success">Photo ajoutée</p>{/if}
{if !empty($edit)}<p class="success">Photo modifiée</p>{/if}
{if !empty($delete)}<p class="success">Photo supprimée</p>{/if}

<a href="/photos/create" class="button">Proposer une Photo</a>

{if $photos|@count == 0}

<p>Aucune photo</p>

{else}

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

{foreach from=$photos item=photo}
<div class="thumb-80">
  <a href="/photos/edit/{$photo.id}?page={$page}"><img src="{$photo.thumb_80_80}" alt="{$photo.name|escape}" /><br />{$photo.name|truncate:15:"...":true:true|escape}</a>
  <a class="overlay-80 overlay-photo-80" href="/photos/edit/{$photo.id}" title="{$photo.name|escape}"></a>
</div>
{/foreach}

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

{/if}

<a href="/photos/create" class="button">Proposer une Photo</a>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
