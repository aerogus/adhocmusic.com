{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Mes lieux</h1>
  </header>
  <div>

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

<table>
  <thead>
    <tr>
      <th>Pays</th>
      <th>Région</th>
      <th>Département</th>
      <th>Id Ville (cp - nom)</th>
      <th>Old CP</th>
      <th>Old City</th>
      <th>Nom</th>
      <th>E</th>
    </tr>
  </thead>
  <tbody>
    {foreach $lieux as $lieu}
    <tr>
      <td><a href="#" title="{$lieu.country|escape}">{$lieu.id_country}</a></td>
      <td><a href="#" title="{$lieu.region|escape}">{$lieu.id_region}</a></td>
      <td><a href="#" title="{$lieu.departement|escape}">{$lieu.id_departement}</a></td>
      <td>{$lieu.id_city} ({$lieu.cp2|escape} - {$lieu.city2|escape})</td>
      <td>{$lieu.cp|escape}</td>
      <td>{$lieu.city|escape}</td>
      <td><a href="/lieux/{$lieu.id|escape}">{$lieu.name|escape}</a></td>
      <td>{$lieu.nb_events}</td>
    </tr>
    {/foreach}
  </tbody>
</table>

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

  </div>
</div>

{include file="common/footer.tpl"}
