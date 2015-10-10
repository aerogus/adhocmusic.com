{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Modération Forums"}

{if !empty($show_results)}
<table>
<tr>
<th>Id</th>
<th>Sujet</th>
<th>Texte</th>
</tr>
{foreach from=$results item=res}
<tr>
<td><a href="edit.php?id={$res.id">{$res.id}</a></td>
<td>{$res.sujet|escape}</td>
<td>{$res.texte|escape}</td>
</tr>
{/foreach}
</table>
{/if}

<form method="post" action="search.php">
Recherche : <input type="text" name="chaine" value="" />
<input type="submit" value="Rechercher" />
</form>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}