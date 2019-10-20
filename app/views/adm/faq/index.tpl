{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Foire aux questions</h1>
  </header>
  <div>
  {if !empty($create)}<p class="infobulle success">Question ajoutée</p>{/if}
  {if !empty($edit)}<p class="infobulle success">Question modifiée</p>{/if}
  {if !empty($delete)}<p class="infobulle success">Question supprimée</p>{/if}
  <table class="table">
  <tr>
    <th>Id</th>
    <th>Catégorie</th>
    <th>Question</th>
    <th>En ligne</th>
  </tr>
  {foreach from=$faq key=cpt item=f}
  <tr class="{if $cpt is odd}odd{else}even{/if}">
    <td>{$f.id_faq}</td>
    <td>{$f.category}</td>
    <td><a href="/adm/faq/edit/{$f.id_faq|escape}">{$f.question|escape}</a></td>
    <td>{$f.online}</td>
  </tr>
  {/foreach}
  </table>
  <a class="button" href="/adm/faq/create">Ajouter une question</a>
  </div>
</div>

{include file="common/footer.tpl"}
