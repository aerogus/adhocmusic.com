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
    <th>Création</th>
    <th>Modification</th>
  </tr>
  {foreach $groupes as $groupe}
  <tr>
    <td><a href="/groupes/edit/{$groupe->getIdGroupe()}" title="{$groupe->getName()|escape}"><img src="{$groupe->getMiniPhoto()|escape}" alt="{$groupe->getName()|escape}"><br>{$groupe->getName()|escape}</a></td>
    <td>{$groupe->getCreatedAt()|date_format:'%d/%m/%Y'}</td>
    <td>{$groupe->getModifiedAt()|date_format:'%d/%m/%Y'}</td>
  </tr>
  {/foreach}
</table>
{else}
<p>Vous n'administrez aucun groupe</p>
{/if}

<a href="/groupes/create">Inscrire un groupe</a>

  </div>
</div>

{include file="common/footer.tpl"}
