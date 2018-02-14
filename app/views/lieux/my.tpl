{include file="common/header.tpl" js_jquery_tablesorter=true}

<script>
$(function () {
  $("#meslieux").tablesorter();
});
</script>

{include file="common/boxstart.tpl" boxtitle="Mes lieux"}

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

<table id="meslieux" class="tablesorter" style="font-size: 0.8em">
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

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
