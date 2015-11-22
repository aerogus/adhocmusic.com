{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Ajouter une Musique"}

<script>
$(function() {
  $('#id_lieu').keypress(function () {
    $('#id_lieu').trigger('change');
  });
  $('#id_lieu').change(function () {
    var id_lieu = $('#id_lieu').val();
    $('#id_event').empty();
    $('<option value="0">---</option>').appendTo('#id_event');
    $.getJSON('/events/get-events-by-lieu.json', { l:id_lieu }, function (data) {
      $.each(data, function(event_id, event) {
        $('<option value="'+event.id+'">'+event.date+' - '+event.name+'</option>').appendTo('#id_event');
      });
    });
  });
  $("#form-audio-create").submit(function () {
    var valid = true;
    if($("#file").val().length === 0) {
      $("#file").prev(".error").fadeIn();
      valid = false;
    } else {
      $("#file").prev(".error").fadeOut();
    }
    if($("#name").val().length === 0) {
      $("#name").prev(".error").fadeIn();
      valid = false;
    } else {
      $("#name").prev(".error").fadeOut();
    }
/*
    if($("#id_groupe").val() === "0") {
      $("#id_groupe").prev(".error").fadeIn();
      valid = false;
    } else {
      $("#id_groupe").prev(".error").fadeOut();
    }
*/
    return valid;
  });
});
</script>

<form name="form-audio-create" id="form-audio-create" method="post" action="/audios/create" enctype="multipart/form-data">
  <ol>
    <li>
      <div class="error" id="error_file"{if empty($error_file)} style="display: none"{/if}>Vous devez choisir un fichier .mp3 à uploader</div>
      <input type="file" name="file" value="" style="float: right;" />
      <label for="file"><img src="{#STATIC_URL#}/img/icones/audio.png" alt="" /> Audio (.mp3 16bits/44Khz/stéréo, &lt; 16 Mo)</label>
    </li>
    <li>
      <div class="error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez renseigner un titre</div>
      <input type="text" name="name" size="50" value="" style="float: right;" />
      <label for="name"><img src="{#STATIC_URL#}/img/icones/signature.png" alt="" /> Titre</label>
    </li>
    <li>
    {if !empty($groupe)}
      <input type="hidden" name="id_groupe" value="{$groupe->getId()}" />
      <span style="float: right">{$groupe->getName()}</span>
    {else}
      <div class="error" id="error_id_groupe"{if empty($error_id_groupe)} style="display: none"{/if}>Vous devez lier cette musique à soit un groupe, soit un lieu, soit un événement</div>
      <select id="id_groupe" name="id_groupe" style="float: right">
        <option value="0">Aucun</option>
        {foreach from=$groupes item=groupe}
        <option value="{$groupe.id}">{$groupe.name|escape}</option>
        {/foreach}
      </select>
    {/if}
      <label for="groupe"><img src="{#STATIC_URL#}/img/icones/groupe.png" alt="" /> Groupe</label>
    </li>
    <li>
    {if !empty($lieu)}
      <input type="hidden" name="id_lieu" value="{$lieu->getId()}" />
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
      <label for="id_lieu"><img src="{#STATIC_URL#}/img/icones/lieu.png" alt="" /> Lieu</label>
    </li>
    <li>
    {if !empty($event)}
      <input type="hidden" name="id_event" value="{$event->getId()}" />
      <span style="float: right;">{$event->getDate()} - {$event->getName()}</span>
    {else}
      <select id="id_event" name="id_event" style="float: right">
        <option value="0">Aucun</option>
      </select>
    {/if}
      <label for="id_event"><img src="{#STATIC_URL#}/img/icones/event.png" alt="" /> Evénement</label>
    </li>
  </ol>
  <input id="form-audio-create-submit" name="form-audio-create-submit" class="button" type="submit" value="Enregistrer" />
</form>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
