{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Lieux</h1>
  </header>
  <div>
  {foreach from=$regions item=region}
    <h2>{$region->getName()}</h2>
    {foreach from=$departements[$region->getIdRegion()] item=departement}
    <h3>{$departement->getIdDepartement()} - {$departement->getName()}</h3>
    {if $lieux[$region->getIdRegion()][$departement->getIdDepartement()]|@count > 0}
    <table class="table table--zebra">
      <thead>
        <tr>
          <th>Nom</th>
          <th>Code Postal</th>
          <th>Ville</th>
          <th>Adresse</th>
        </tr>
      </thead>
      <tbody>
        {foreach from=$lieux[$region->getIdRegion()][$departement->getIdDepartement()] item=lieu}
        <tr>
          <td><a href="{$lieu->getUrl()}">{$lieu->getName()}</a></td>
          <td>{$lieu->getCity()->getCp()}</td>
          <td>{$lieu->getCity()->getName()}</td>
          <td>{$lieu->getAddress()}</td>
        </tr>
        {/foreach}
      </tbody>
    </table>
    {else}
    <p>Pas de lieu référencé dans ce département</p>
    {/if}
    {/foreach}
  {/foreach}
  </div>
</div>

{include file="common/footer.tpl"}
