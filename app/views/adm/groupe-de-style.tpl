{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Liaisons groupe / styles</h1>
  </header>
  <div>

<table class="table table--zebra">
  <thead>
    <tr>
      <th>Nom</th>
      <th>Style libre</th>
      <th>Styles prédéfinis</th>
    </tr>
  </thead>
  <tbody>
    {foreach from=$groupes key=id_grp item=groupe}
    <tr>
      <td><a href="/adm/groupe-de-style/{$groupe.id|escape}">{$groupe.name|escape}</a></td>
      <td>{$groupe.style|escape}</td>
      <td>
      {if !empty($groupe.styles)}
      <ul>
      {foreach from=$groupe.styles item=style}
      <li>{$style->getName()|escape}</li>
      {/foreach}
      </ul>
      {/if}
      </td>
    </tr>
    {/foreach}
  </tbody>
</table>

  </div>
</div>

{include file="common/footer.tpl"}
