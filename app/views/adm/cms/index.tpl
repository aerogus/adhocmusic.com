{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Pages Statiques"}

{if !empty($create)}<p class="success">Page ajoutée</p>{/if}
{if !empty($edit)}<p class="success">Page modifiée</p>{/if}
{if !empty($delete)}<p class="success">Page supprimée</p>{/if}

<table>
  <tr>
    <th>Id</th>
    <th>Alias</th>
    <th>Titre</th>
    <th>En Ligne</th>
  </tr>
  {foreach from=$cmss key=cpt item=cms}
  <tr class="{if $cpt is odd}odd{else}even{/if}">
    <td>{$cms.id|escape}</td>
    <td><a href="/adm/cms/edit/{$cms.id|escape}">{$cms.alias|escape}</a></td>
    <td>{$cms.title|escape}</td>
    <td>{$cms.online|display_on_off_icon}</td>
  </tr>
  {/foreach}
</table>

<a class="button" href="/adm/cms/create">Ajouter une page</a>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
