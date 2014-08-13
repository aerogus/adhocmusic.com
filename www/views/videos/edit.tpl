{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Editer une vidéo"}

{if !empty($unknown_video)}

<p class="error">Cette vidéo est introuvable !</p>

{else}

<script>
$(function() {

  $('#id_lieu').keypress(function() {
    $('#id_lieu').trigger('change');
  });

  $('#id_lieu').change(function() {
    var id_lieu = $('#id_lieu').val();
    var video_id_event = {$video->getIdEvent()};
    $('#id_event').empty();
    $('<option value="0">---</option>').appendTo('#id_event');
    $.getJSON('/events/get-events-by-lieu.json', { l:id_lieu }, function(data) {
      var selected = '';
      $.each(data, function(event_id, event) {
        if(video_id_event == event.id) { selected = ' selected="selected"'; } else { selected = ''; }
        $('<option value="'+event.id+'"'+selected+'>'+event.date+' - '+event.name+'</option>').appendTo('#id_event');
      });
    });
  });

  $("#form-video-edit").submit(function() {
    var valid = true;
    if($("#name").val() == "") {
      $("#name").prev(".error").fadeIn();
      valid = false;
    } else {
      $("#name").prev(".error").fadeOut();
    }
    return valid;
  });

  $('#id_lieu').trigger('change');

});
</script>

<form id="form-video-edit" name="form-video-edit" method="post" action="/videos/edit" enctype="multipart/form-data">
  <ol>
    <li>
      <div class="error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez saisir un titre pour la vidéo</div>
      <input type="text" id="name" name="name" size="50" value="{$video->getName()|escape}" style="float: right;" />
      <label for="name"><img src="{#STATIC_URL#}/img/icones/signature.png" alt="" /> Titre</label>
    </li>
    <li>
      <span id="host" style="float: right;">{$video->getHostName()|escape}</span>
      <label for="host"><img src="{#STATIC_URL#}/img/icones/photo.png" alt="" /> Hébergeur</label>
    </li>
    <li>
      <span id="reference" style="float: right;">{$video->getReference()|escape}</span>
      <label for="reference"><img src="{#STATIC_URL#}/img/icones/photo.png" alt="" /> Référence</label>
    </li>
    <li>
      <select id="id_groupe" name="id_groupe" style="float: right;">
        <option value="0">Sans</option>
        {foreach from=$groupes item=groupe}
        <option value="{$groupe.id}"{if $video->getIdGroupe() == $groupe.id} selected="selected"{/if}>{$groupe.name|escape}</option>
        {/foreach}
      </select>
      <label for="groupe"><img src="{#STATIC_URL#}/img/icones/groupe.png" alt="" /> Groupe</label>
    </li>
    <li>
      <select id="id_lieu" name="id_lieu" style="float: right">
        <optgroup label="Autre">
          <option value="0">aucun / non référencé</option>
        </optgroup>
        {foreach from=$dep item=dep_name key=dep_id}
        <optgroup label="{$dep_id} - {$dep_name|escape}">
          {foreach from=$lieux[$dep_id] item=lieu}
          <option value="{$lieu.id}"{if $video->getIdLieu() == $lieu.id} selected="selected"{/if}>{$lieu.cp} {$lieu.city|escape} : {$lieu.name|escape}</option>
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
      <label for="event"><img src="{#STATIC_URL#}/img/icones/event.png" alt="" /> Evénement</label>
    </li>
    <li>
      <input id="online" type="checkbox" name="online"{if $video->getOnline()} checked="checked"{/if} style="float: right;" />
      <label for="online"><img src="{#STATIC_URL#}/img/icones/eye.png" alt="" /> Afficher</label>
    </li>
  </ol>
  <input id="form-video-edit-submit" name="form-video-edit-submit" type="submit" class="button" value="Enregistrer" />
  <input type="hidden" name="id" value="{$video->getId()|escape}" />
</form>

<p align="center"><a href="/videos/delete/{$video->getId()|escape}" class="button">Supprimer</a></p>

<p align="center">{$video->getPlayer()}</p>

{/if} {* test unknown video *}

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
