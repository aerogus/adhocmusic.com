{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Pages Statiques</h1>
  </header>
  <div>

{if !empty($create)}<p class="infobulle success">Page ajoutée</p>{/if}
{if !empty($edit)}<p class="infobulle success">Page modifiée</p>{/if}
{if !empty($delete)}<p class="infobulle success">Page supprimée</p>{/if}

<table class="table table--zebra">
  <thead>
    <tr>
      <th scope="col" class="w10">Id</th>
      <th scope="col" class="w20">Alias</th>
      <th scope="col">Titre</th>
      <th scope="col" class="w10">En Ligne</th>
    </tr>
  </thead>
  <tbody>
    {foreach from=$cmss item=cms}
    <tr>
      <td>{$cms->getIdCms()|escape}</td>
      <td><a href="/adm/cms/edit/{$cms->getIdCms()|escape}">{$cms->getAlias()|escape}</a></td>
      <td>{$cms->getTitle()|escape}</td>
      <td>{$cms->getOnline()|display_on_off_icon}</td>
    </tr>
    {/foreach}
  </tbody>
</table>

<a class="btn btn--primary" href="/adm/cms/create">Ajouter une page</a>

  </div>
</div>

{include file="common/footer.tpl"}
