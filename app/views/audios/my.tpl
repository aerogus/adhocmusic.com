{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Gestion de mes musiques"}

<a href="/audios/create" class="button">Ajouter une Musique</a>

{if $audios|@sizeof == 0}

<p>Aucune musique</p>

{else}

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

{if !empty($delete)}
<div class="success">La suppression du son a été effectuée</div>
{/if}

<table>
  <thead>
    <tr>
      <th>Groupe</th>
      <th>Titre</th>
      <th>Créé le</th>
      <th>Modifié le</th>
    </tr>
  </thead>
  {foreach $audios as $audio}
  <tbody>    
    <tr>
      <td>{$audio.groupe_name|escape}</td>
      <td><a href="/audios/edit/{$audio.id|escape}">{$audio.name|escape}</a></td>
      <td>{$audio.created_on}</td>
      <td>{$audio.modified_on}</td>
    </tr>
  </tbody>
  {/foreach}
</table>

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

{/if}

<a href="/audios/create" class="button">Ajouter une Musique</a>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
