{include file="common/header.tpl" js_jquery_tablesorter=true}

{include file="common/boxstart.tpl" boxtitle="Mes Articles"}

{if !empty($create)}<p class="success">Article ajouté (hors ligne)</p>{/if}
{if !empty($edit)}<p class="success">Article modifié</p>{/if}
{if !empty($delete)}<p class="success">Article supprimé</p>{/if}

<a href="/articles/create" class="button">Ecrire un article</a>

{if $nb_items == 0}

<p>Aucun article</p>

{else}

<script>
$(function() {
  $("#mesarticles").tablesorter();
});
</script>

<table id="mesarticles" class="tablesorter">
  <thead>
    <tr>
      {if $me->isAdmin()}<th>Pseudo</th>{/if}
      <th>Titre</th>
      <th>Création</th>
      <th>Modification</th>
      <th>Rubrique</th>
      <th>En Ligne</th>
    </tr>
  </thead>
  <tbody>
    {foreach from=$articles key=cpt item=article}
    <tr class="{if $cpt is odd}odd{else}even{/if}">
      {if $me->isAdmin()}<td><a href="/membres/show/{$article.id_contact|escape}">{$article.pseudo|escape}</a></td>{/if}
      <td><a href="/articles/edit/{$article.id}" title="{$article.title|escape}">{$article.title|escape}</a></td>
      <td>{$article.created_on|date_format:"%d/%m/%Y"}</td>
      <td>{$article.modified_on|date_format:"%d/%m/%Y"}</td>
      <td>{$article.rubrique|escape}</td>
      <td><span id="toggle-art-{$article.id}">{$article.online|display_on_off_icon}<span></td>
    </tr>
    {/foreach}
  </tbody>
</table>

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

{/if}

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
