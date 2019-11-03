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
      <th><a href="/adm/groupes/?sort=id&amp;sens={$sensinv}&amp;page={$page}">Id</a></th>
      <th><a href="/adm/groupes/?sort=name&amp;sens={$sensinv}&amp;page={$page}">Nom</a></th>
      <th><a href="/adm/groupes/?sort=style&amp;sens={$sensinv}&amp;page={$page}">Style</a></th>
      <th><a href="/adm/groupes/?sort=created_on&amp;sens={$sensinv}&amp;page={$page}">Créa</a></th>
      <th><a href="/adm/groupes/?sort=modified_on&amp;sens={$sensinv}&amp;page={$page}">Modif</a></th>
    </tr>
  </thead>
  <tbody>
  {foreach from=$groupes key=cpt item=groupe}
    <tr>
      <td>{$groupe.id|escape}</td>
      <td><a href="/adm/groupes/{$groupe.id}">{$groupe.name|truncate:'30'|escape}</a></td>
      <td>{$groupe.style|truncate:'30'|escape}</td>
      <td>{$groupe.created_on|date_format:'%d/%m/%y'}</td>
      <td>{$groupe.modified_on|date_format:'%d/%m/%y'}</td>
    </tr>
  {/foreach}
  </tbody>
</table>

  </div>
</div>

{include file="common/footer.tpl"}
