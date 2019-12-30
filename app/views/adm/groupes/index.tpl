{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Groupes</h1>
  </header>
  <div class="reset">

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

<table class="table table--zebra" id="tab-groupes">
  <thead>
    <tr>
      <th>Id</th>
      <th>Nom</th>
      <th>Style</th>
      <th>Créa</th>
      <th>Modif</th>
    </tr>
  </thead>
  <tbody>
  {foreach from=$groupes item=groupe}
    <tr>
      <td>{$groupe->getIdGroupe()|escape}</td>
      <td><a href="/adm/groupes/{$groupe->getIdGroupe()}">{$groupe->getName()|truncate:'30'|escape}</a></td>
      <td>{$groupe->getStyle()|truncate:'30'|escape}</td>
      <td>{$groupe->getCreatedAt()|date_format:'%d/%m/%y'}</td>
      <td>{$groupe->getModifiedAt()|date_format:'%d/%m/%y'}</td>
    </tr>
  {/foreach}
  </tbody>
</table>

  </div>
</div>

{include file="common/footer.tpl"}
