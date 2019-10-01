{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Ajouter un lieu</h1>
  </header>
  <div>

<style>
#form-lieu-create li {
    display: block;
    clear: both;
}
</style>

<form id="form-lieu-create" name="form-lieu-create" action="/lieux/create" method="post" enctype="multipart/form-data" accept="image/jpeg">
  <ol>
    <li>
      <div class="infobulle error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez saisir le nom du lieu</div>
      <label for="name">Nom (*)</label>
      <input id="name" name="name" type="text" size="50" value="">
    </li>
    <li>
      <div class="infobulle error" id="error_id_type"{if empty($error_id_type)} style="display: none"{/if}>Vous devez préciser le type de lieu</div>
      <label for="id_type">Type (*)</label>
      <select id="id_type" name="id_type">
        <option value="0">--------</option>
        {foreach from=$types_lieu key=type_lieu_id item=type_lieu_name}
        <option value="{$type_lieu_id|escape}">{$type_lieu_name|escape}</option>
        {/foreach}
      </select>
    </li>
    <li>
      <div class="infobulle error" id="error_text"{if empty($error_text)} style="display: none"{/if}>Vous devez entrer une description pour le lieu</div>
      <label for="text">Description (*)</label>
      <textarea id="text" name="text" rows="5" cols="20"></textarea>
    </li>
    <li>
      <label for="photo">Photo (format .jpg)</label>
      <input id="photo" name="photo" type="file">
    </li>
    <li>
      <div class="infobulle error" id="error_id_country"{if empty($error_id_country)} style="display: none"{/if}>Vous devez choisir un pays</div>
      <label for="id_country">Pays (*)</label>
      <select id="id_country" name="id_country">
        <option value="0">---</option>
      </select>
    </li>
    <li>
      <div class="infobulle error" id="error_id_region"{if empty($error_id_region)} style="display: none"{/if}>Vous devez choisir une région</div>
      <label for="id_region">Région (*)</label>
      <select id="id_region" name="id_region">
        <option value="0">---</option>
      </select>
    </li>
    <li>
      <div class="infobulle error" id="error_id_departement"{if empty($error_id_departement)} style="display: none"{/if}>Vous devez choisir un département</div>
      <label for="id_departement">Département (*)</label>
      <select id="id_departement" name="id_departement">
        <option value="0">---</option>
      </select>
    </li>
    <li>
      <div class="infobulle error" id="error_id_city"{if empty($error_id_city)} style="display: none"{/if}>Vous devez choisir une ville</div>
      <label for="id_city">Ville (*)</label>
      <select id="id_city" name="id_city">
        <option value="0">---</option>
      </select>
    </li>
    <li>
      <div class="infobulle error" id="error_address"{if empty($error_address)} style="display: none"{/if}>Vous devez préciser l'adresse</div>
      <label for="address">Adresse (*)</label>
      <input id="address" name="address" type="text" size="50" value="">
    </li>
    <li>
      <div class="infobulle error" id="error_tel"{if empty($error_tel)} style="display: none"{/if}>Vous devez saisir le numéro de téléphone</div>
      <label for="tel">Téléphone</label>
      <input id="tel" name="tel" type="text" size="50" value="">
    </li>
    <li>
      <div class="infobulle error" id="error_fax"{if empty($error_fax)} style="display: none"{/if}>Vous devez saisir le numéro de fax</div>
      <label for="fax">Fax</label>
      <input id="fax" name="fax" type="text" size="50" value="">
    </li>
    <li>
      <div class="infobulle error" id="error_email"{if empty($error_email)} style="display: none"{/if}>Vous devez saisir l'email de contact</div>
      <label for="email">Email</label>
      <input id="email" name="email" type="email" size="50" value="">
    </li>
    <li>
      <div class="infobulle error" id="error_site"{if empty($error_site)} style="display: none"{/if}>Vous devez saisir le site internet</div>
      <label for="site">Site</label>
      <input id="site" name="site" type="text" size="50" value="">
    </li>
  </ol>
  <input id="form-lieu-create-submit" name="form-lieu-create-submit" class="button" type="submit" value="Ajouter">
</form>

  </div>
</div>

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
