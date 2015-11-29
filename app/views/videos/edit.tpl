{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Editer une vidéo"}

{if !empty($unknown_video)}

<p class="error">Cette vidéo est introuvable !</p>

{else}

<form id="form-video-edit" name="form-video-edit" method="post" action="/videos/edit" enctype="multipart/form-data">
  <ol>
    <li>
      <div class="error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez saisir un titre pour la vidéo</div>
      <input type="text" id="name" name="name" size="50" value="{$video->getName()|escape}" style="float: right;">
      <label for="name">Titre</label>
    </li>
    <li>
      <span id="host" style="float: right;">{$video->getHostName()|escape}</span>
      <label for="host">Hébergeur</label>
    </li>
    <li>
      <span id="reference" style="float: right;">{$video->getReference()|escape}</span>
      <label for="reference">Référence</label>
    </li>
    <li>
      <select id="id_groupe" name="id_groupe" style="float: right;">
        <option value="0">Sans</option>
        {foreach from=$groupes item=groupe}
        <option value="{$groupe.id}"{if $video->getIdGroupe() == $groupe.id} selected="selected"{/if}>{$groupe.name|escape}</option>
        {/foreach}
      </select>
      <label for="groupe">Groupe</label>
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
      <label for="id_lieu">Lieu</label>
    </li>
    <li>
      <select id="id_event" name="id_event" style="float: right;">
        <option value="0">Aucun</option>
      </select>
      <label for="event">Événement</label>
    </li>
    <li>
      <input id="online" type="checkbox" name="online"{if $video->getOnline()} checked="checked"{/if} style="float: right;">
      <label for="online">Afficher</label>
    </li>
  </ol>
  <input id="form-video-edit-submit" name="form-video-edit-submit" type="submit" class="button" value="Enregistrer">
  <input type="hidden" name="id" value="{$video->getId()|escape}">
</form>

<p align="center"><a href="/videos/delete/{$video->getId()|escape}" class="button">Supprimer</a></p>

<p align="center">{$video->getPlayer()}</p>

{/if} {* test unknown video *}

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}

