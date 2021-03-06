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
    {foreach from=$groupes item=groupe}
    <tr>
      <td><a href="/adm/groupe-de-style/{$groupe->getIdGroupe()|escape}">{$groupe->getName()|escape}</a></td>
      <td>{$groupe->getStyle()|escape}</td>
      <td>
      {if !empty($groupe->getStyles())}
      <ul>
      {foreach from=$groupe->getStyles() item=style}
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
