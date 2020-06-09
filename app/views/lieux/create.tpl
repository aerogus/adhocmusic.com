{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Ajouter un lieu</h1>
  </header>
  <div>

<form id="form-lieu-create" name="form-lieu-create" action="/lieux/create" method="post" enctype="multipart/form-data" accept="image/jpeg">
  <section class="grid-4">
    <div>
      <label for="name">Nom (*)</label>
    </div>
    <div class="col-3 mbs">
      <div class="infobulle error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez saisir le nom du lieu</div>
      <input id="name" name="name" type="text" class="w100" value="">
    </div>
    <div>
      <label for="id_type">Type (*)</label>
    </div>
    <div class="col-3 mbs">
      <div class="infobulle error" id="error_id_type"{if empty($error_id_type)} style="display: none"{/if}>Vous devez préciser le type de lieu</div>
      <select id="id_type" name="id_type" class="w100">
        <option value="0">--------</option>
        {foreach from=$lieu_types item=lieu_type}
        <option value="{$lieu_type->getId()|escape}">{$lieu_type->getName()|escape}</option>
        {/foreach}
      </select>
    </div>
    <div>
      <label for="text">Description (*)</label>
    </div>
    <div class="col-3 mbs">
      <div class="infobulle error" id="error_text"{if empty($error_text)} style="display: none"{/if}>Vous devez entrer une description pour le lieu</div>
      <textarea id="text" name="text" rows="5" class="w100"></textarea>
    </div>
    <div>
      <label for="photo">Photo (format .jpg)</label>
    </div>
    <div class="col-3 mbs">
      <input id="photo" name="photo" type="file">
    </div>
    <div>
      <label for="id_country">Pays (*)</label>
    </div>
    <div class="col-3 mbs">
      <div class="infobulle error" id="error_id_country"{if empty($error_id_country)} style="display: none"{/if}>Vous devez choisir un pays</div>
      <select id="id_country" name="id_country" class="w100">
        <option value="0">---</option>
      </select>
    </div>
    <div>
      <label for="id_region">Région (*)</label>
    </div>
    <div class="col-3 mbs">
      <div class="infobulle error" id="error_id_region"{if empty($error_id_region)} style="display: none"{/if}>Vous devez choisir une région</div>
      <select id="id_region" name="id_region" class="w100">
        <option value="0">---</option>
      </select>
    </div>
    <div>
      <label for="id_departement">Département (*)</label>
    </div>
    <div class="col-3 mbs">
      <div class="infobulle error" id="error_id_departement"{if empty($error_id_departement)} style="display: none"{/if}>Vous devez choisir un département</div>
      <select id="id_departement" name="id_departement" class="w100">
        <option value="0">---</option>
      </select>
    </div>
    <div>
      <label for="id_city">Ville (*)</label>
    </div>
    <div class="col-3 mbs">
      <div class="infobulle error" id="error_id_city"{if empty($error_id_city)} style="display: none"{/if}>Vous devez choisir une ville</div>
      <select id="id_city" name="id_city" class="w100">
        <option value="0">---</option>
      </select>
    </div>
    <div>
      <label for="address">Adresse (*)</label>
    </div>
    <div class="col-3 mbs">
      <div class="infobulle error" id="error_address"{if empty($error_address)} style="display: none"{/if}>Vous devez préciser l'adresse</div>
      <input id="address" name="address" type="text" class="w100" value="">
    </div>
    <div>
      <label for="site">Site</label>
    </div>
    <div class="col-3 mbs">
      <div class="infobulle error" id="error_site"{if empty($error_site)} style="display: none"{/if}>Vous devez saisir le site internet</div>
      <input id="site" name="site" type="text" class="w100" value="">
    </div>
    <div>
      <label for="lat">Latitude</label>
    </div>
    <div class="col-3 mbs">
      <div class="infobulle error" id="error_lat"{if empty($error_lat)} style="display: none"{/if}>Vous devez préciser la latitude</div>
      <input id="lat" name="lat" type="text" class="w100" value="">
    </div>
    <div>
      <label for="lng">Longitude</label>
    </div>
    <div class="col-3 mbs">
      <div class="infobulle error" id="error_lng"{if empty($error_lng)} style="display: none"{/if}>Vous devez préciser la longitude</div>
      <input id="lng" name="lng" type="text" class="w100" value="">
    </div>
    <div></div>
    <div class="col-3">
      <input id="form-lieu-create-submit" name="form-lieu-create-submit" class="btn btn--primary w100" type="submit" value="Ajouter">
    </div>
  </section>
</form>

  </div>
</div>

{include file="common/footer.tpl"}
