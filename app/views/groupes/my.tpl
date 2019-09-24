{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Mes Groupes</h1>
  </header>
  <div>

{if !empty($delete)}
<div class="infobulle success">Groupe supprimé</div>
{/if}

{if $groupes|@count > 0}
<table>
  <tr>
    <th>Groupe</th>
    <th>Poste</th>
    <th>Création</th>
    <th>Modification</th>
  </tr>
  {foreach $groupes as $groupe}
  <tr>
    <td><a href="/groupes/edit/{$groupe.id}" title="{$groupe.name|escape}"><img src="{$groupe.mini_photo|escape}" alt="{$groupe.name|escape}"><br>{$groupe.name|escape}</a></td>
    <td>{$groupe.nom_type_musicien}</td>
    <td>{$groupe.created_on|date_format:'%d/%m/%Y'}</td>
    <td>{$groupe.modified_on|date_format:'%d/%m/%Y'}</td>
  </tr>
  {/foreach}
</table>
{else}
<p>Vous n'administrez aucun groupe</p>
{/if}

<a href="/groupes/create">Inscrire un Groupe</a>

  </div>
</div>

{include file="common/footer.tpl"}
