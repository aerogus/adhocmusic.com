{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Modifier un lieu"}

{if !empty($unknown_lieu)}

<p class="infobulle error">Ce lieu est introuvable !</p>

{else}

<div class="infobulle info">Un lieu est indépendant de tout événement ou groupe.</div>

<style>
#form-lieu-edit li {
    display: block;
    clear: both;
}
</style>

<form id="form-lieu-edit" name="form-lieu-edit" action="/lieux/edit" method="post" enctype="multipart/form-data">
  <ol>
    <li>
      <div class="infobulle error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez saisir le nom du lieu</div>
      <input id="name" name="name" type="text" size="50" value="{$lieu->getName()|escape}" style="float: right;">
      <label for="name">Nom (*)</label>
    </li>
    <li>
      <div class="infobulle error" id="error_id_type"{if empty($error_id_type)} style="display: none"{/if}>Vous devez préciser le type de lieu</div>
      <select id="id_type" name="id_type" style="float: right;">
        <option value="0">--------</option>
        {foreach from=$types_lieu key=type_lieu_id item=type_lieu_name}
        <option value="{$type_lieu_id}"{if $type_lieu_id == $lieu->getIdType()} selected="selected"{/if}>{$type_lieu_name|escape}</option>
        {/foreach}
      </select>
      <label for="id_type">Type (*)</label>
    </li>
    <li>
      <div class="infobulle error" id="error_text"{if empty($error_text)} style="display: none"{/if}>Vous devez entrer une description pour le lieu</div>
      <textarea id="text" name="text" rows="5" cols="20" style="float: right;">{$lieu->getText()|escape}</textarea>
      <label for="text">Description (*)</label>
    </li>
    <li>
      <img src="{$lieu->getPhotoUrl()}" alt="" style="float: right;">
      <input id="photo" name="photo" type="file" style="float: right;">
      <label for="photo">Photo (format .jpg)</label>
    </li>
    <li>
      <div class="infobulle error" id="error_id_country"{if empty($error_id_country)} style="display: none"{/if}>Vous devez choisir un pays</div>
      <select id="id_country" name="id_country" style="float: right;">
        <option value="0">---</option>
      </select>
      <label for="id_country">Pays (*)</label>
    </li>
    <li>
      <div class="infobulle error" id="error_id_region"{if empty($error_id_region)} style="display: none"{/if}>Vous devez choisir une région</div>
      <select id="id_region" name="id_region" style="float: right;">
        <option value="0">---</option>
      </select>
      <label for="id_region">Région (*)</label>
    </li>
    <li>
      <div class="infobulle error" id="error_id_departement"{if empty($error_id_departement)} style="display: none"{/if}>Vous devez choisir un département</div>
      <select id="id_departement" name="id_departement" style="float: right;">
        <option value="0">---</option>
      </select>
      <label for="id_departement">Département (*)</label>
    </li>
    <li>
      <div class="infobulle error" id="error_id_city"{if empty($error_id_city)} style="display: none"{/if}>Vous devez choisir une ville</div>
      <select id="id_city" name="id_city" style="float: right;">
        <option value="0">---</option>
      </select>
      <label for="id_city">Ville (*)</label>
    </li>
    <li>
      <div class="infobulle error" id="error_address"{if empty($error_address)} style="display: none"{/if}>Vous devez préciser l'adresse</div>
      <input id="address" name="address" type="text" size="50" value="{$lieu->getAddress()|escape}" style="float: right;">
      <label for="address">Adresse (*)</label>
    </li>
    <li>
      <div class="infobulle error" id="error_tel"{if empty($error_tel)} style="display: none"{/if}>Vous devez saisir le numéro de téléphone</div>
      <input id="tel" name="tel" type="text" size="50" value="{$lieu->getTel()|escape}" style="float: right;">
      <label for="tel">Téléphone</label>
    </li>
    <li>
      <div class="infobulle error" id="error_fax"{if empty($error_fax)} style="display: none"{/if}>Vous devez saisir le numéro de fax</div>
      <input id="fax" name="fax" type="text" size="50" value="{$lieu->getFax()|escape}" style="float: right;">
      <label for="fax">Fax</label>
    </li>
    <li>
      <div class="infobulle error" id="error_email"{if empty($error_email)} style="display: none"{/if}>Vous devez saisir l'email de contact</div>
      <input id="email" name="email" type="email" size="50" value="{$lieu->getEmail()|escape}" style="float: right;">
      <label for="email">Email</label>
    </li>
    <li>
      <div class="infobulle error" id="error_site"{if empty($error_site)} style="display: none"{/if}>Vous devez saisir le site internet</div>
      <input id="site" name="site" type="text" size="50" value="{$lieu->getSite()|escape}" style="float: right;">
      <label for="site">Site</label>
    </li>
    <li>
      <div class="infobulle error" id="error_lat"{if empty($error_lat)} style="display: none"{/if}>Vous devez préciser la latitude</div>
      <input id="lat" name="lat" type="text" size="50" value="{$lieu->getLat()|escape}" style="float: right;">
      <label for="lat">Latitude</label>
    </li>
    <li>
      <div class="infobulle error" id="error_lng"{if empty($error_lng)} style="display: none"{/if}>Vous devez préciser la longitude</div>
      <input id="lng" name="lng" type="text" size="50" value="{$lieu->getLng()|escape}" style="float: right;">
      <label for="lng">Longitude</label>
    </li>
  </ol>
  <input id="form-lieu-edit-submit" name="form-lieu-edit-submit" class="button" type="submit" value="Modifier">
  <input type="hidden" name="id" value="{$lieu->getId()|escape}">
</form>

{/if}

{include file="common/boxend.tpl"}

<script>
var lieu = {
    id: {$lieu->getId()},
    id_country: '{$lieu->getIdCountry()}',
    id_region: '{$lieu->getIdRegion()}',
    id_departement: '{$lieu->getIdDepartement()}',
    id_city: {$lieu->getIdCity()}
};
</script>

{include file="common/footer.tpl"}
