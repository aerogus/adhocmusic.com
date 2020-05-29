{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Éditer un lieu</h1>
  </header>
  <div>

{if !empty($unknown_lieu)}

<p class="infobulle error">Ce lieu est introuvable !</p>

{else}

<form id="form-lieu-edit" name="form-lieu-edit" action="/lieux/edit" method="post" enctype="multipart/form-data">
  <ul>
    <li>
      <label for="name">Nom (*)</label>
      <div class="infobulle error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez saisir le nom du lieu</div>
      <input id="name" name="name" type="text" size="50" value="{$lieu->getName()|escape}">
    </li>
    <li>
      <label for="id_type">Type (*)</label>
      <div class="infobulle error" id="error_id_type"{if empty($error_id_type)} style="display: none"{/if}>Vous devez préciser le type de lieu</div>
      <select id="id_type" name="id_type">
        <option value="0">--------</option>
        {foreach from=$lieu_types item=lieu_type}
        <option value="{$lieu_type->getId()}"{if $lieu_type->getId() == $lieu->getIdType()} selected="selected"{/if}>{$lieu_type->getName()|escape}</option>
        {/foreach}
      </select>
    </li>
    <li>
      <label for="text">Description (*)</label>
      <div class="infobulle error" id="error_text"{if empty($error_text)} style="display: none"{/if}>Vous devez entrer une description pour le lieu</div>
      <textarea id="text" name="text" rows="5" cols="20">{$lieu->getText()|escape}</textarea>
    </li>
    <li>
      <label for="photo">Photo (format .jpg)</label>
      <img src="{$lieu->getPhotoUrl()}" alt="">
      <input id="photo" name="photo" type="file">
    </li>
    <li>
      <label for="id_country">Pays (*)</label>
      <div class="infobulle error" id="error_id_country"{if empty($error_id_country)} style="display: none"{/if}>Vous devez choisir un pays</div>
      <select id="id_country" name="id_country">
        <option value="0">---</option>
      </select>
    </li>
    <li>
      <label for="id_region">Région (*)</label>
      <div class="infobulle error" id="error_id_region"{if empty($error_id_region)} style="display: none"{/if}>Vous devez choisir une région</div>
      <select id="id_region" name="id_region">
        <option value="0">---</option>
      </select>
    </li>
    <li>
      <label for="id_departement">Département (*)</label>
      <div class="infobulle error" id="error_id_departement"{if empty($error_id_departement)} style="display: none"{/if}>Vous devez choisir un département</div>
      <select id="id_departement" name="id_departement">
        <option value="0">---</option>
      </select>
    </li>
    <li>
      <label for="id_city">Ville (*)</label>
      <div class="infobulle error" id="error_id_city"{if empty($error_id_city)} style="display: none"{/if}>Vous devez choisir une ville</div>
      <select id="id_city" name="id_city">
        <option value="0">---</option>
      </select>
    </li>
    <li>
      <label for="address">Adresse (*)</label>
      <div class="infobulle error" id="error_address"{if empty($error_address)} style="display: none"{/if}>Vous devez préciser l'adresse</div>
      <input id="address" name="address" type="text" size="50" value="{$lieu->getAddress()|escape}">
    </li>
    <li>
      <label for="site">Site</label>
      <div class="infobulle error" id="error_site"{if empty($error_site)} style="display: none"{/if}>Vous devez saisir le site internet</div>
      <input id="site" name="site" type="text" size="50" value="{$lieu->getSite()|escape}">
    </li>
    <li>
      <label for="lat">Latitude</label>
      <div class="infobulle error" id="error_lat"{if empty($error_lat)} style="display: none"{/if}>Vous devez préciser la latitude</div>
      <input id="lat" name="lat" type="text" size="50" value="{$lieu->getLat()|escape}">
    </li>
    <li>
      <label for="lng">Longitude</label>
      <div class="infobulle error" id="error_lng"{if empty($error_lng)} style="display: none"{/if}>Vous devez préciser la longitude</div>
      <input id="lng" name="lng" type="text" size="50" value="{$lieu->getLng()|escape}">
    </li>
  </ul>
  <input id="form-lieu-edit-submit" name="form-lieu-edit-submit" class="btn btn--primary" type="submit" value="Modifier">
  <input type="hidden" name="id" value="{$lieu->getId()|escape}">
</form>

{/if}

  </div>
</div>

{include file="common/footer.tpl"}
