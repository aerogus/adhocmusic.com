{include file="common/header.tpl"}

{include file="common/boxstart.tpl"}
<p>Ce script permet d'importer plusieurs photos d'un coup. Elle doivent être de format .jpg et empaquetées dans une archive .zip déposé dans le répertoire suivant du serveur : /var/www/adhocmusic.com/import . Ensuite saisissez le nom de l'archive (le nom du fichier), renseignez les données communes à toutes les photos, puis cliquez sur importer. Astuce : après un concert, faites une archive par groupe ! Vous n'aurez juste plus qu'à ajuster le titre de chaque photo manuellement par la suite. Gain de temps !</p>
{include file="common/boxend.tpl"}

{include file="common/boxstart.tpl" boxtitle="Importer plusieurs photos"}

<script>
$(function() {
  $('#id_lieu').keypress(function() {
    $('#id_lieu').trigger('change');
  });
  $('#id_lieu').change(function() {
    var id_lieu = $('#id_lieu').val();
    $('#id_event').empty();
    $('<option value="0">---</option>').appendTo('#id_event');
    $.getJSON('/events/get-events-by-lieu.json', { l:id_lieu }, function(data) {
      $.each(data, function(event_id, event) {
        $('<option value="'+event.id+'">'+event.date+' - '+event.name+'</option>').appendTo('#id_event');
      });
    });
  });
  $("#form-photo-import").submit(function() {
    var valid = true;
    if($("#file").val() == "") {
      $("#error_file").fadeIn();
      valid = false;
    } else {
      $("#error_file").fadeOut();
    }
    if($("#name").val() == "") {
      $("#error_name").fadeIn();
      valid = false;
    } else {
      $("#error_name").fadeOut();
    }
    if($("#credits").val() == "") {
      $("#error_credits").fadeIn();
      valid = false;
    } else {
      $("#error_credits").fadeOut();
    }
    if($("#id_groupe").val() == "0" && $("#id_lieu").val() == "0" && $("#id_event").val() == "0") {
      $("#error_id_groupe").fadeIn();
      valid = false;
    } else {
      $("#error_id_groupe").fadeOut();
    }
    return valid;
  });
});
</script>

<form id="form-photo-import" name="form-photo-import" method="post" action="/photos/import" enctype="multipart/form-data">
  <ol>
    <li>
      <div class="error" id="error_file"{if empty($error_file)} style="display: none"{/if}>Vous devez renseigner le nom de l'archive .zip</div>
      <input type="text" name="file" id="file" size="50" value="Archive.zip" style="float: right;">
      <label for="file"><img src="/img/icones/photo.png" alt=""> Nom du fichier .zip</label>
    </li>
    <li>
      <div class="error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez saisir un titre pour ces photos</div>
      <input type="text" id="name" name="name" size="50" value="" style="float: right">
      <label for="name"><img src="/img/icones/signature.png" alt=""> Titre</label>
    </li>
    <li>
      <div class="error" id="error_credits"{if empty($error_credits)} style="display: none"{/if}>Vous devez saisir le nom du photographe</div>
      <input type="text" id="credits" name="credits" size="50" value="" style="float: right">
      <label for="credits"><img src="/img/icones/photo.png" alt=""> Photographe</label>
    </li>
    <li>
    {if !empty($groupe)}
      <input type="hidden" name="id_groupe" value="{$groupe->getId()}">
      <span style="float: right">{$groupe->getName()}</span>
    {else}
      <div class="error" id="error_id_groupe"{if empty($error_id_groupe)} style="display: none"{/if}>Vous devez lier ces photos à soit un groupe, soit un lieu, soit un événement</div>
      <select id="id_groupe" name="id_groupe" style="float: right">
        <option value="0">Aucun</option>
        {foreach $groupes as $groupe}
        <option value="{$groupe.id}">{$groupe.name|escape}</option>
        {/foreach}
      </select>
    {/if}
      <label for="id_groupe"><img src="/img/icones/groupe.png" alt=""> Groupe</label>
    </li>
    <li>
    {if !empty($lieu)}
      <input type="hidden" name="id_lieu" value="{$lieu->getId()}">
      <span style="float: right;">{$lieu->getName()}</span>
    {else}
      <select id="id_lieu" name="id_lieu" style="float: right">
        <optgroup label="Autre">
          <option value="0">aucun / non référencé</option>
        </optgroup>
        {foreach from=$dep item=dep_name key=dep_id}
        <optgroup label="{$dep_id} - {$dep_name|escape}">
          {foreach from=$lieux[$dep_id] item=lieu}
          <option value="{$lieu.id}">{$lieu.cp} {$lieu.city|escape} : {$lieu.name|escape}</option>
          {/foreach}
        </optgroup>
        {/foreach}
      </select>
    {/if}
      <label for="id_lieu"><img src="/img/icones/lieu.png" alt=""> Lieu</label>
    </li>
    <li>
    {if !empty($event)}
      <input type="hidden" name="id_event" value="{$event->getId()}">
      <span style="float: right;">{$event->getDate()} - {$event->getName()}</span>
    {else}
      <select id="id_event" name="id_event" style="float: right">
        <option value="0">Aucun</option>
      </select>
    {/if}
      <label for="id_event"><img src="/img/icones/event.png" alt=""> Evénement</label>
    </li>
  </ol>
  <input id="form-photo-import-submit" name="form-photo-import-submit" class="button" type="submit" value="Importer">
</form>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
