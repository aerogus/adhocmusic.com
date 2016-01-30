{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Modifier un lieu"}

{if !empty($unknown_lieu)}

<p class="error">Ce lieu est introuvable !</p>

{else}

<script>
$(function() {
  $("#form-lieu-edit").submit(function () {
    var valid = true;
    if($("#name").val() == "") {
      $("#name").prev(".error").fadeIn();
      valid = false;
    } else {
      $("#name").prev(".error").fadeOut();
    }
    if($("#id_type").val() == "0") {
      $("#id_type").prev(".error").fadeIn();
      valid = false;
    } else {
      $("#id_type").prev(".error").fadeOut();
    }
    if($("#address").val() == "") {
      $("#address").prev(".error").fadeIn();
      valid = false;
    } else {
      $("#address").prev(".error").fadeOut();
    }
    if($("#text").val() == "") {
      $("#text").prev(".error").fadeIn();
      valid = false;
    } else {
      $("#text").prev(".error").fadeOut();
    }
    if($("#id_country").val() == 'FR' && $("#id_departement").val() == "0") {
      $("#id_departement").prev(".error").fadeIn();
      valid = false;
    } else {
      $("#id_departement").prev(".error").fadeOut();
    }
    if($("#id_country").val() == 'FR' && $("#id_city").val() == "0") {
      $("#id_city").prev(".error").fadeIn();
      valid = false;
    } else {
      $("#id_city").prev(".error").fadeOut();
    }
    if($("#id_country").val() == "0") {
      $("#id_country").prev(".error").fadeIn();
      valid = false;
    } else {
      $("#id_country").prev(".error").fadeOut();
    }
    return valid;
  });

  $.ajaxSetup( { "async": false } );

  $('#id_country, #id_region, #id_departement').keypress(function() {
    $(this).trigger('change');
  });

  $('#id_country').change(function () {
    var id_country = $('#id_country').val();
    var lieu_id_region = '{$lieu->getIdRegion()}';
    $('#id_region').empty();
    $('<option value="0">---</option>').appendTo('#id_region');
    $.getJSON('/geo/getregion.json', { c:id_country }, function(data) {
      var selected = '';
      $.each(data, function(region_id, region_name) {
        if(lieu_id_region == region_id) { selected = ' selected="selected"'; } else { selected = ''; }
        $('<option value="'+region_id+'"'+selected+'>'+region_name+'</option>').appendTo('#id_region');
      });
      if(id_country != 'FR') {
          $('#id_departement').hide();
          $('#id_city').hide();
      } else {
        $('#id_departement').show();
        $('#id_city').show();
      }
    });
  });

  $('#id_region').change(function () {
    var id_country = $('#id_country').val();
    var lieu_id_region = '{$lieu->getIdRegion()}';
    var id_region = $('#id_region').val();
    var lieu_id_departement = '{$lieu->getIdDepartement()}';
    $('#id_departement').empty();
    $('#id_city').empty();
    if(id_country == 'FR') {
      $('<option value="0">---</option>').appendTo('#id_departement');
      $.getJSON('/geo/getdepartement.json', { r:id_region }, function(data) {
        var selected = '';
        $.each(data, function(departement_id, departement_name) {
          if(lieu_id_departement == departement_id) { selected = ' selected="selected"'; } else { selected = ''; }
          $('<option value="'+departement_id+'"'+selected+'>'+departement_id+' - '+departement_name+'</option>').appendTo('#id_departement');
        });
      });
    }
  });

  $('#id_departement').change(function () {
    var id_country = $('#id_country').val();
    var id_departement = $('#id_departement').val();
    var lieu_id_city = '{$lieu->getIdCity()}';
    $('#id_city').empty();
    if(id_country == 'FR') {
      $('<option value="0">---</option>').appendTo('#id_city');
      $.getJSON('/geo/getcity.json', { d:id_departement }, function(data) {
        var selected = '';
        $.each(data, function(city_id, city_name) {
          if(lieu_id_city == city_id) { selected = ' selected="selected"'; } else { selected = ''; }
          $('<option value="'+city_id+'"'+selected+'>'+city_name+'</option>').appendTo('#id_city');
        });
      });
    }
  });

  $('#id_country').trigger('change');
  $('#id_region').trigger('change');
  $('#id_departement').trigger('change');

});
</script>

<div class="info">Un lieu est indépendant de tout événement ou groupe.</div>

<style>
#form-lieu-edit li {
    display: block;
    clear: both;
}
</style>

<form id="form-lieu-edit" name="form-lieu-edit" action="/lieux/edit" method="post" enctype="multipart/form-data">
  <ol>
    <li>
      <div class="error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez saisir le nom du lieu</div>
      <input id="name" name="name" type="text" size="50" value="{$lieu->getName()|escape}" style="float: right;">
      <label for="name">Nom (*)</label>
    </li>
    <li>
      <div class="error" id="error_id_type"{if empty($error_id_type)} style="display: none"{/if}>Vous devez préciser le type de lieu</div>
      <select id="id_type" name="id_type" style="float: right;">
        <option value="0">--------</option>
        {foreach from=$types_lieu key=type_lieu_id item=type_lieu_name}
        <option value="{$type_lieu_id}"{if $type_lieu_id == $lieu->getIdType()} selected="selected"{/if}>{$type_lieu_name|escape}</option>
        {/foreach}
      </select>
      <label for="id_type">Type (*)</label>
    </li>
    <li>
      <div class="error" id="error_text"{if empty($error_text)} style="display: none"{/if}>Vous devez entrer une description pour le lieu</div>
      <textarea id="text" name="text" rows="5" cols="20" style="float: right;">{$lieu->getText()|escape}</textarea>
      <label for="text">Description (*)</label>
    </li>
    <li>
      <img src="{$lieu->getPhoto()}" alt="" style="float: right;">
      <input id="photo" name="photo" type="file" style="float: right;">
      <label for="photo">Photo (format .jpg)</label>
    </li>
    <li>
      <div class="error" id="error_id_country"{if empty($error_id_country)} style="display: none"{/if}>Vous devez choisir un pays</div>
      <select id="id_country" name="id_country" style="float: right;">
        <option value="0">---</option>
        {foreach from=$countries key=country_id item=country_name}
        <option value="{$country_id}"{if $lieu->getIdCountry() == $country_id} selected="selected"{/if}>{$country_name.fr|escape}</option>
        {/foreach}
      </select>
      <label for="id_country">Pays (*)</label>
    </li>
    <li>
      <div class="error" id="error_id_region"{if empty($error_id_region)} style="display: none"{/if}>Vous devez choisir une région</div>
      <select id="id_region" name="id_region" style="float: right;">
        <option value="0"></option>
      </select>
      <label for="id_region">Région (*)</label>
    </li>
    <li>
      <div class="error" id="error_id_departement"{if empty($error_id_departement)} style="display: none"{/if}>Vous devez choisir un département</div>
      <select id="id_departement" name="id_departement" style="float: right;">
        <option value="0"></option>
      </select>
      <label for="id_departement">Département (*)</label>
    </li>
    <li>
      <div class="error" id="error_id_city"{if empty($error_id_city)} style="display: none"{/if}>Vous devez choisir une ville</div>
      <select id="id_city" name="id_city" style="float: right;">
        <option value="0"></option>
      </select>
      <label for="id_city">Ville (*)</label>
    </li>
    <li>
      <div class="error" id="error_address"{if empty($error_address)} style="display: none"{/if}>Vous devez préciser l'adresse</div>
      <input id="address" name="address" type="text" size="50" value="{$lieu->getAddress()|escape}" style="float: right;">
      <label for="address">Adresse (*)</label>
    </li>
    <li>
      <div class="error" id="error_tel"{if empty($error_tel)} style="display: none"{/if}>Vous devez saisir le numéro de téléphone</div>
      <input id="tel" name="tel" type="text" size="50" value="{$lieu->getTel()|escape}" style="float: right;">
      <label for="tel">Téléphone</label>
    </li>
    <li>
      <div class="error" id="error_fax"{if empty($error_fax)} style="display: none"{/if}>Vous devez saisir le numéro de fax</div>
      <input id="fax" name="fax" type="text" size="50" value="{$lieu->getFax()|escape}" style="float: right;">
      <label for="fax">Fax</label>
    </li>
    <li>
      <div class="error" id="error_email"{if empty($error_email)} style="display: none"{/if}>Vous devez saisir l'email de contact</div>
      <input id="email" name="email" type="email" size="50" value="{$lieu->getEmail()|escape}" style="float: right;">
      <label for="email">Email</label>
    </li>
    <li>
      <div class="error" id="error_site"{if empty($error_site)} style="display: none"{/if}>Vous devez saisir le site internet</div>
      <input id="site" name="site" type="text" size="50" value="{$lieu->getSite()|escape}" style="float: right;">
      <label for="site">Site</label>
    </li>
    <li>
      <div class="error" id="error_lat"{if empty($error_lat)} style="display: none"{/if}>Vous devez préciser la latitude</div>
      <input id="lat" name="lat" type="text" size="50" value="{$lieu->getLat()|escape}" style="float: right;">
      <label for="lat">Latitude</label>
    </li>
    <li>
      <div class="error" id="error_lng"{if empty($error_lng)} style="display: none"{/if}>Vous devez préciser la longitude</div>
      <input id="lng" name="lng" type="text" size="50" value="{$lieu->getLng()|escape}" style="float: right;">
      <label for="lng">Longitude</label>
    </li>
  </ol>
  <input id="form-lieu-edit-submit" name="form-lieu-edit-submit" class="button" type="submit" value="Modifier">
  <input type="hidden" name="id" value="{$lieu->getId()|escape}">
</form>

{/if}

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
