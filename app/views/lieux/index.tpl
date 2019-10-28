{include file="common/header.tpl"}

<div>

{include file="common/boxstart.tpl" boxtitle="Proche de chez vous"}
{foreach from=$lieux item=lieu}
<div style="margin 5px; padding: 5px">
  <a href="/lieux/show/{$lieu.id_lieu}"><strong>{$lieu.name|escape}</strong></a><br>
  <em>{$lieu.city|escape}</em><br>
  (à {$lieu.distance} km)
</div>
{/foreach}
</table>
{include file="common/boxend.tpl"}

</div>

<div id="center-right">

{include file="common/boxstart.tpl" boxtitle="Lieux de diffusion"}

<form id="form-lieu-search" name="form-lieu-search">
  <legend>Chercher un lieu</legend>
   <fieldset>
    <ol>
      <li>
        <select id="id_region" name="id_region" style="float: right;">
          <option value="0">--------</option>
        </select>
        <label for="id_region">Région</label>
      </li>
      <li>
        <select id="id_departement" name="id_departement" style="float: right;">
          <option value="0">--------</option>
        </select>
        <label for="id_departement">Département</label>
      </li>
    </ol>
  </fieldset>
</form>

<div id="map_canvas" style="width: 690px; height: 320px;"></div>

<table id="search-results" style=" width: 690px; display: none">
  <thead>
    <tr>
      <th>Nom</th>
      <th>Adresse</th>
      <th>Ville</th>
      <th>Distance</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>

{include file="common/boxend.tpl"}

</div>

{include file="common/footer.tpl"}
