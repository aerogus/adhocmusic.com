{include file="fb/adhocmusic/canvas/common/header.tpl"}

<p>Liste des lieux de concerts en Essonne</p>

<table>
  <tr>
    <th>Ville</th>
    <th>Code Postal</th>
    <th>Nom</th>
    <th>Adresse</th>
  </tr>
  {foreach from=$lieux item=lieu}
  <tr>
    <td>{$lieu.city|escape}</td>
    <td>{$lieu.cp|escape}</td>
    <td><a href="lieu/{$lieu.id|escape}.html">{$lieu.name|escape}</a></td>
    <td>{$lieu.address|escape}</td>
  </tr>
  {/foreach}
</table>

{include file="fb/adhocmusic/canvas/common/footer.tpl"}
