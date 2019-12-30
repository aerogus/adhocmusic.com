{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Pages Statiques</h1>
  </header>
  <div>

{if !empty($create)}<p class="infobulle success">Page ajoutée</p>{/if}
{if !empty($edit)}<p class="infobulle success">Page modifiée</p>{/if}
{if !empty($delete)}<p class="infobulle success">Page supprimée</p>{/if}

<table>
  <tr>
    <th>Id</th>
    <th>Alias</th>
    <th>Titre</th>
    <th>En Ligne</th>
  </tr>
  {foreach from=$cmss item=cms}
  <tr>
    <td>{$cms->getIdCMS()|escape}</td>
    <td><a href="/adm/cms/edit/{$cms->getIdCMS()|escape}">{$cms->getAlias()|escape}</a></td>
    <td>{$cms->getTitle()|escape}</td>
    <td>{$cms->getOnline()|display_on_off_icon}</td>
  </tr>
  {/foreach}
</table>

<a class="button" href="/adm/cms/create">Ajouter une page</a>

  </div>
</div>

{include file="common/footer.tpl"}
