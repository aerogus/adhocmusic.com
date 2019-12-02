{include file="common/header.tpl"}

<div class="box">
  <header>
    <h2>Mes musiques</h2>
  </header>
  <div>

<a href="/audios/create" class="button">Ajouter une musique</a>

{if $audios|@sizeof == 0}

<p>Aucune musique</p>

{else}

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

{if !empty($delete)}
<div class="infobulle success">La suppression du son a été effectuée</div>
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
      <td>{if !empty($audio->getGroupe())}{$audio->getGroupe()->getName()|escape}{/if}</td>
      <td><a href="/audios/edit/{$audio->getIdAudio()|escape}">{$audio->getName()|escape}</a></td>
      <td>{$audio->getCreatedAt()}</td>
      <td>{$audio->getModifiedAt()}</td>
    </tr>
  </tbody>
  {/foreach}
</table>

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

{/if}

<a href="/audios/create" class="button">Ajouter une musique</a>

  </div>
</div>

{include file="common/footer.tpl"}
