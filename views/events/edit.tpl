{include file="common/header.tpl" js_jquery_ui=true css_jquery_ui=true js_jquery_ui_datepicker=true}

{include file="common/boxstart.tpl" boxtitle="Modifier une date"}

<script>
$(function() {

  $("#date").datepicker({
    dateFormat: 'dd/mm/yy',
    showAnim: 'slideDown'
  });

  $("#form-event-edit").submit(function() {
    var valid = true;
    if($("#name").val() == "") {
      $("#error_name").fadeIn();
      valid = false;
    } else {
      $("#error_name").fadeOut();
    }
    if($("#id_lieu").val() == "0") {
      $("#error_id_lieu").fadeIn();
      valid = false;
    } else {
      $("#error_id_lieu").fadeOut();
    }
    if($("#text").val() == "") {
      $("#error_text").fadeIn();
      valid = false;
    } else {
      $("#error_text").fadeOut();
    }
    if($("#price").val() == "" || $("#price").val() == "0") {
      $("#error_price").fadeIn();
      valid = false;
    } else {
      $("#error_price").fadeOut();
    }
    return valid;
  });

  $.ajaxSetup( { "async": false } );

  $('#id_country').keypress(function() {
    $('#id_country').trigger('change');
  });

  $('#id_region').keypress(function() {
    $('#id_region').trigger('change');
  });

  $('#id_departement').keypress(function() {
    $('#id_departement').trigger('change');
  });

  $('#id_city').keypress(function() {
    $('#id_city').trigger('change');
  });

  $('#id_country').change(function() {
    var id_country = $('#id_country').val();
    var lieu_id_region = '{$lieu->getIdRegion()}';
    $('#id_region').empty();
    $('#id_departement').empty();
    $('#id_city').empty();
    $('<option value="0">---</option>').appendTo('#id_region');
    $.getJSON('/geo/getregion.json', { c:id_country }, function(data) {
      var selected = '';
      $.each(data, function(region_id, region_name) {
        if(lieu_id_region == region_id) { selected = ' selected="selected"'; } else { selected = ''; }
        $('<option value="'+region_id+'"'+selected+'>'+region_name+'</option>').appendTo('#id_region');
      });
    });
    if(id_country != 'FR') {
        $('#id_departement').hide();
        $('#id_city').hide();
    } else {
        $('#id_departement').show();
        $('#id_city').show();
    }
  });

  $('#id_region').change(function() {
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

  $('#id_departement').change(function() {
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

  $('#id_city').change(function() {
    var id_city = $('#id_city').val();
    var lieu_id_lieu = {$lieu->getId()};
    $('#id_lieu').empty();
    $('<option value="0">---</option>').appendTo('#id_lieu');
    $.getJSON('/geo/getlieu.json', { v:id_city }, function(data) {
      var selected = '';
      $.each(data, function(lieu_id, lieu_name) {
        if(lieu_id_lieu == lieu_id) { selected = ' selected="selected"'; } else { selected = ''; }
        $('<option value="'+lieu_id+'"'+selected+'>'+lieu_name+'</option>').appendTo('#id_lieu');
      });
    });
  });

  $('#id_country').trigger('change');
  $('#id_region').trigger('change');
  $('#id_departement').trigger('change');
  $('#id_city').trigger('change');
  $('#id_lieu').trigger('change');

});
</script>

<form name="form-event-edit" id="form-event-edit" action="/events/edit" enctype="multipart/form-data" method="post">
  <fieldset>
    <legend>Infos sur le lieu</legend>
    <ol>
      <li>
        <div class="error" id="error_id_lieu"{if empty($error_id_lieu)} style="display: none"{/if}>Vous devez indiquer un lieu pour l'événement ou le saisir s'il n'est pas encore référencé.</div>
        <select id="id_country" name="id_country" style="float: right;">
          <option value="0">---</option>
          {foreach from=$countries key=id item=name}
          <option value="{$id}"{if $id == $lieu->getIdCountry()} selected="selected"{/if}>{$name.fr|escape}</option>
          {/foreach}
        </select>
        <label for="id_country">Pays</label>
      </li>
      <li>
        <select id="id_region" name="id_region" style="float: right;">
          <option value="0"></option>
        </select>
        <label for="id_region">Région</label>
      </li>
      <li>
        <select id="id_departement" name="id_departement" style="float: right;">
          <option value="0"></option>
        </select>
        <label for="id_departement">Département</label>
      </li>
      <li>
        <select id="id_city" name="id_city" style="float: right;">
          <option value="0"></option>
        </select>
        <label for="id_city">Ville</label>
      </li>
      <li>
        <select id="id_lieu" name="id_lieu" style="float: right;">
          <option value="0"></option>
        </select>
        <label for="id_lieu">Lieu</label>
      </li>
    </ol>
  </fieldset>
  <fieldset>
    <legend>Infos sur l'événement</legend>
    <ol>
      <li>
        <div class="error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez indiquer un titre pour l'événement.</div>
        <input id="name" name="name" style="float: right; width: 360px;" value="{$event->getName()|escape}" />
        <label for="name">Titre</label>
      </li>
      <li>
        <span style="float: right;">
          <input type="text" id="date" name="date" value="{$event->getDate()|date_format:'%d/%m/%Y'}" style="width: 100px; background: url({#STATIC_URL#}/img/icones/event.png) no-repeat right top" />
          <select id="hourminute" name="hourminute">{html_input_date_hourminute hour=$event->getHour() minute=$event->getMinute()}</select>
        </span>
        <label for="date">Date</label>
      </li>
      <li>
        <div class="error" id="error_text"{if empty($error_text)} style="display: none"{/if}>Vous devez mettre une description pour cet événement.</div>
        <textarea id="text" name="text" cols="40" rows="10" style="float: right;">{$event->getText()|escape}</textarea>
        <label for="text">Description</label>
      </li>
      <li>
        <div class="error" id="error_price"{if empty($error_price)} style="display: none"{/if}>Vous devez écrire les tarifs de l'entrée.</div>
        <textarea id="price" name="price" cols="40" rows="2" style="float: right;">{$event->getPrice()|escape}</textarea>
        <label for="price">Tarifs (Entrée, Bar, Vestiaire ...)</label>
      </li>
      <li>
        <span style="float: right;">
        <input type="file" id="flyer" name="flyer" value="{$data.file|escape}" />
        {if $event->getFullFlyerUrl()}
        <br /><img src="{$event->getFlyer400Url()}" alt="" />
        {/if}
        </span>
        <label for="flyer">Flyer (.jpg)</label>
      </li>
      <li>
        <input type="text" id="flyer_url" name="flyer_url" style="float: right;" value="{$data.flyer_url|escape}" />
        <label for="flyer_url">ou Flyer (url)</label>
      </li>
      {*
      <li>
        <span style="float: right;">
        <ul>
          {section name=cpt_style loop=3}
          <li>
            <select id="style" name="style[{$smarty.section.cpt_style.index}]" style="float: right;">
              <option value="0">-- Choix d'un style --</option>
              {foreach from=$styles key=style_id item=style_name}
              <option value="{$style_id|escape}"{if $event->getStyle(cpt_style) == $style_id} selected="selected"{/if}>{$style_name|escape}</option>
              {/foreach}
            </select>
          </li>
          {/section}
        </ul>
        </span>
        <label for="style">Style(s)</label>
      </li>
      *}
      <li>
        <span style="float: right;">
        <ul>
          {section name=cpt_groupe loop=5}
          <li>
            <select id="groupe" name="groupe[{$smarty.section.cpt_groupe.index}]" style="float: right;">
              <option value="0">-- Choix d'un groupe --</option>
              {foreach from=$groupes item=groupe}
              <option value="{$groupe.id|escape}"{if $event->getGroupeId($smarty.section.cpt_groupe.index) == $groupe.id} selected="selected"{/if}>{$groupe.name|escape}</option>
              {/foreach}
            </select>
          </li>
          {/section}
        </ul>
        </span>
        <label for="groupe">Groupe(s) AD'HOC</label>
      </li>
      <li>
        <span style="float: right;">
          <ul>
            {section name=cpt_structure loop=3}
            <li>
              <select id="structure" name="structure[{$smarty.section.cpt_structure.index}]">
                <option value="0">-- Choix d'une structure --</option>
                {foreach from=$structures item=structure}
                <option value="{$structure.id|escape}"{if $event->getStructureId($smarty.section.cpt_structure.index) == $structure.id} selected="selected"{/if}>{$structure.name|escape}</option>
                {/foreach}
              </select>
            </li>
            {/section}
          </ul>
        </span>
        <label for="structure">Organisateur(s)</label>
      </li>
      <li>
        <input type="checkbox" id="online" name="online" {if $event->getOnline()}checked="checked"{/if} style="float: right;" />
        <label for="online">Afficher</label>
      </li>
    </ol>
  </fieldset>
  <div class="success">Nouveau: liez cet événement à un événement Facebook existant ou bien créez directement un événement Facebook !</div>
  <fieldset>
    <legend>Facebook</legend>
    <ol>
      <li>
        <span style="float: right;">
          http://www.facebook.com/events/<input id="facebook_event_id" name="facebook_event_id" style="width: 360px;" value="{$event->getFacebookEventId()|escape}" />/
        </span>
        <label for="facebook_event_id">n° Evénement (si déjà existant sur Facebook)</label>
      </li>
{*
      <li>
        <input type="checkbox" id="facebook_event_create" name="facebook_event_create" disabled="disabled" style="float: right;" />
        <label for="facebook_event_create">Créer l'événement sur Facebook (si non existant)</label>
      </li>
*}
    </ol>
  </fieldset>
  <input id="form-event-edit-submit" name="form-event-edit-submit" class="button" type="submit" value="Modifier" />
  <input type="hidden" name="id" value="{$data.id|escape}" />
</form>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
