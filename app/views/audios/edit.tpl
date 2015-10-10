{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Editer un Son"}

{if !empty($unknown_audio)}

<p class="error">Cet audio est introuvable !</p>

{else}

<script>
$(function() {
  $('#id_lieu').keypress(function() {
    $('#id_lieu').trigger('change');
  });
  $('#id_lieu').change(function() {
    var id_lieu = $('#id_lieu').val();
    var audio_id_event = {$audio->getIdEvent()};
    $('#id_event').empty();
    $('<option value="0">---</option>').appendTo('#id_event');
    $.getJSON('/events/get-events-by-lieu.json', { l:id_lieu }, function(data) {
      var selected = '';
      $.each(data, function(event_id, event) {
        if(audio_id_event == event.id) { selected = ' selected="selected"'; } else { selected = ''; }
        $('<option value="'+event.id+'"'+selected+'>'+event.date+' - '+event.name+'</option>').appendTo('#id_event');
      });
    });
  });
  $("#form-audio-edit").submit(function() {
    var valid = true;
    if($("#name").val() == "") {
      $("#name").prev(".error").fadeIn();
      valid = false;
    } else {
      $("#name").prev(".error").fadeOut();
    }
    if($("#id_groupe").val() == "0") {
      $("#id_groupe").prev(".error").fadeIn();
      valid = false;
    } else {
      $("#id_groupe").prev(".error").fadeOut();
    }
    return valid;
  });
  $('#id_lieu').trigger('change');
});
</script>

<form name="form-audio-edit" id="form-audio-edit" method="post" action="/audios/edit" enctype="multipart/form-data">
  <ol>
    <li>
       <span id="mp3" style="float: right;">{audio_player id=$audio->getId()}</span>
       <label for="mp3"><img src="{#STATIC_URL#}/img/icones/audio.png" alt="" /> Ecouter</label>
    </li>
    <li>
      <input type="file" name="file" value="" style="float: right;" />
      <label for="file"><img src="{#STATIC_URL#}/img/icones/audio.png" alt="" /> Audio (.mp3 16bits/44Khz/stéréo, &lt; 16 Mo)</label>
    </li>
    <li>
      <div class="error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez renseigner un titre</div>
      <input type="text" id="name" name="name" size="50" value="{$audio->getName()|escape}" style="float: right;" />
      <label for="name"><img src="{#STATIC_URL#}/img/icones/signature.png" alt="" /> Titre</label>
    </li>
    <li>
      <div class="error" id="error_id_groupe"{if empty($error_id_groupe)} style="display: none"{/if}>Vous devez sélectionner un groupe</div>
      <select id="id_groupe" name="id_groupe" style="float: right;">
        <option value="0">Sans</option>
        {foreach from=$groupes item=groupe}
        <option value="{$groupe.id}"{if $audio->getIdGroupe() == $groupe.id} selected="selected"{/if}>{$groupe.name|escape}</option>
        {/foreach}
      </select>
      <label for="id_groupe"><img src="{#STATIC_URL#}/img/icones/groupe.png" alt="" /> Groupe</label>
    </li>
    <li>
      <select id="id_lieu" name="id_lieu" style="float: right;">
        <optgroup label="Autre">
          <option value="0">aucun / non référencé</option>
        </optgroup>
        {foreach from=$dep item=dep_name key=dep_id}
        <optgroup label="{$dep_id} - {$dep_name|escape}">
          {foreach from=$lieux.$dep_id item=lieu}
          <option value="{$lieu.id}"{if $audio->getIdLieu() == $lieu.id} selected="selected"{/if}>{$lieu.cp} {$lieu.city|escape} : {$lieu.name|escape}</option>
          {/foreach}
        </optgroup>
        {/foreach}
      </select>
      <label for="id_lieu"><img src="{#STATIC_URL#}/img/icones/lieu.png" alt="" /> Lieu</label>
    </li>
    <li>
      <select id="id_event" name="id_event" style="float: right;">
        <option value="0">Aucun</option>
      </select>
      <label for="id_event"><img src="{#STATIC_URL#}/img/icones/event.png" alt="" /> Evénement</label>
    </li>
    <li>
      <span id="online" style="float: right;">{$audio->getOnline()}</span>
      <label for="online"><img src="{#STATIC_URL#}/img/icones/eye.png" alt="" /> Afficher</label>
    </li>
    <li>
      <span id="created_on" style="float: right;"><a href="{$membre->getUrl()}">{$membre->getPseudo()|escape}</a>
      le {$audio->getCreatedOn()|date_format:"%d/%m/%Y à %H:%M"}</span>
      <label for="created_on"><img src="{#STATIC_URL#}/img/icones/upload.png" alt="" /> Envoyé par</label>
    </li>
    <li>
      <span id="modified_on" style="float: right;">{$audio->getModifiedOn()|date_format:"%d/%m/%Y à %H:%M"}</span>
      <label for="modified_on"><img src="{#STATIC_URL#}/img/icones/eye.png" alt="" /> Modifié le</label>
    </li>
    <li>
      <span id="delete" style="float: right;"><a href="/audios/delete/{$audio->getId()}"><img src="{#STATIC_URL#}/img/icones/delete.png" alt="" /></a></span>
      <label for="delete"><img src="{#STATIC_URL#}/img/icones/delete.png" alt="" /> Supprimer</label>
    </li>
  </ol>
  <input id="form-audio-edit-submit" name="form-audio-edit-submit" class="button" type="submit" value="Enregistrer" />
  <input type="hidden" name="id" value="{$audio->getId()}" />
  <input type="hidden" name="online" value="{$audio->getOnline()}" />
  <input type="hidden" name="id_structure" value="{$audio->getIdStructure()}" />
</form>

{/if} {* test unknown audio *}

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}