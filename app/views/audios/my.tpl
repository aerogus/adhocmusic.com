{include file="common/header.tpl"}

<div class="box">
  <header>
    <h2>Mes musiques</h2>
  </header>
  <div>

<div class="mbs txtcenter">
  <a href="/audios/create" class="btn btn--primary">Ajouter une musique</a>
</div>

{if $audios|@sizeof == 0}

<p>Aucune musique</p>

{else}

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

{if !empty($delete)}
<div class="infobulle success">La suppression du son a été effectuée</div>
{/if}

<table class="table table--zebra">
  <thead>
    <tr>
      <th>Groupe</th>
      <th>Titre</th>
      <th>Créé le</th>
      <th>Modifié le</th>
    </tr>
  </thead>
  <tbody>
  {foreach $audios as $audio}
    <tr>
      <td>{if !empty($audio->getGroupe())}{$audio->getGroupe()->getName()|escape}{/if}</td>
      <td><a href="/audios/edit/{$audio->getIdAudio()|escape}">{$audio->getName()|escape}</a></td>
      <td>{$audio->getCreatedAt()}</td>
      <td>{$audio->getModifiedAt()}</td>
    </tr>
  {/foreach}
  </tbody>
</table>

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

{/if}

<div class="mts txtcenter">
  <a href="/audios/create" class="btn btn--primary">Ajouter une musique</a>
</div>

  </div>
</div>

{include file="common/footer.tpl"}
