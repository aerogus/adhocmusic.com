{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Liste des exposants"}

<a class="button" href="/adm/exposants/create">Ajouter un exposant</a>

<table>
  <tr>
    <th>Nom</th>
    <th>Email</th>
    <th>Téléphone</th>
    <th>Site</th>
    <th>Type</th>
    <th>Ville</th>
    <th>Etat</th>
  </tr>
  {foreach from=$exposants item=exposant}
  <tr>
    <td><a href="/adm/exposants/edit/{$exposant.id|escape}">{$exposant.name|escape}</a></td>
    <td><a href="mailto:{$exposant.email|escape}">{$exposant.email|escape}</a></td>
    <td>{$exposant.phone|escape}</a></td>
    <td><a href="{$exposant.site|escape}">{$exposant.site|escape}</a></td>
    <td>{$exposant.type|escape}</td>
    <td>{$exposant.city|escape}</td>
    <td>{$exposant.state|escape}</td>
  </tr>
{/foreach}
</table>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
