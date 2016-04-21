{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Ajouter un lieu"}

<div class="info">Un lieu est indépendant de tout événement ou groupe.</div>

<style>
#form-lieu-create li {
    display: block;
    clear: both;
}
</style>

<form id="form-lieu-create" name="form-lieu-create" action="/lieux/create" method="post" enctype="multipart/form-data" accept="image/jpeg">
  <ol>
    <li>
      <div class="error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez saisir le nom du lieu</div>
      <input id="name" name="name" type="text" size="50" value="" style="float: right;">
      <label for="name">Nom (*)</label>
    </li>
    <li>
      <div class="error" id="error_id_type"{if empty($error_id_type)} style="display: none"{/if}>Vous devez préciser le type de lieu</div>
      <select id="id_type" name="id_type" style="float: right;">
        <option value="0">--------</option>
        {foreach from=$types_lieu key=type_lieu_id item=type_lieu_name}
        <option value="{$type_lieu_id|escape}">{$type_lieu_name|escape}</option>
        {/foreach}
      </select>
      <label for="id_type">Type (*)</label>
    </li>
    <li>
      <div class="error" id="error_text"{if empty($error_text)} style="display: none"{/if}>Vous devez entrer une description pour le lieu</div>
      <textarea id="text" name="text" rows="5" cols="20" style="float: right;"></textarea>
      <label for="text">Description (*)</label>
    </li>
    <li>
      <input id="photo" name="photo" type="file" style="float: right;">
      <label for="photo">Photo (format .jpg)</label>
    </li>
    <li>
      <div class="error" id="error_id_country"{if empty($error_id_country)} style="display: none"{/if}>Vous devez choisir un pays</div>
      <select id="id_country" name="id_country" style="float: right;">
        <option value="0">---</option>
      </select>
      <label for="id_country">Pays (*)</label>
    </li>
    <li>
      <div class="error" id="error_id_region"{if empty($error_id_region)} style="display: none"{/if}>Vous devez choisir une région</div>
      <select id="id_region" name="id_region" style="float: right;">
        <option value="0">---</option>
      </select>
      <label for="id_region">Région (*)</label>
    </li>
    <li>
      <div class="error" id="error_id_departement"{if empty($error_id_departement)} style="display: none"{/if}>Vous devez choisir un département</div>
      <select id="id_departement" name="id_departement" style="float: right;">
        <option value="0">---</option>
      </select>
      <label for="id_departement">Département (*)</label>
    </li>
    <li>
      <div class="error" id="error_id_city"{if empty($error_id_city)} style="display: none"{/if}>Vous devez choisir une ville</div>
      <select id="id_city" name="id_city" style="float: right;">
        <option value="0">---</option>
      </select>
      <label for="id_city">Ville (*)</label>
    </li>
    <li>
      <div class="error" id="error_address"{if empty($error_address)} style="display: none"{/if}>Vous devez préciser l'adresse</div>
      <input id="address" name="address" type="text" size="50" value="" style="float: right;">
      <label for="address">Adresse (*)</label>
    </li>
    <li>
      <div class="error" id="error_tel"{if empty($error_tel)} style="display: none"{/if}>Vous devez saisir le numéro de téléphone</div>
      <input id="tel" name="tel" type="text" size="50" value="" style="float: right;">
      <label for="tel">Téléphone</label>
    </li>
    <li>
      <div class="error" id="error_fax"{if empty($error_fax)} style="display: none"{/if}>Vous devez saisir le numéro de fax</div>
      <input id="fax" name="fax" type="text" size="50" value="" style="float: right;">
      <label for="fax">Fax</label>
    </li>
    <li>
      <div class="error" id="error_email"{if empty($error_email)} style="display: none"{/if}>Vous devez saisir l'email de contact</div>
      <input id="email" name="email" type="email" size="50" value="" style="float: right;">
      <label for="email">Email</label>
    </li>
    <li>
      <div class="error" id="error_site"{if empty($error_site)} style="display: none"{/if}>Vous devez saisir le site internet</div>
      <input id="site" name="site" type="text" size="50" value="" style="float: right;">
      <label for="site">Site</label>
    </li>
  </ol>
  <input type="hidden" name="lat" value="0">
  <input type="hidden" name="lng" value="0">
  <input id="form-lieu-create-submit" name="form-lieu-create-submit" class="button" type="submit" value="Ajouter">
</form>

{include file="common/boxend.tpl"}

<script>
var lieu = {
    id: 0,
    id_country: 'FR',
    id_region: 'A8',
    id_departement: '91',
    id_city: 91216
};
</script>

{include file="common/footer.tpl"}
