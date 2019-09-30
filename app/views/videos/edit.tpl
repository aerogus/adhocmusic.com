{include file="common/header.tpl"}

<div class="box">
  <header>
    <h2>Éditer une vidéo</h2>
  </header>
  <div>

{if !empty($unknown_video)}

<p class="infobulle error">Cette vidéo est introuvable !</p>

{else}

<form id="form-video-edit" name="form-video-edit" method="post" action="/videos/edit">
  <ul>
    <li>
      <div class="infobulle error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez saisir un titre pour la vidéo</div>
      <label for="name">Titre</label>
      <input type="text" id="name" name="name" size="50" value="{$video->getName()|escape}" style="float: right;">
    </li>
    <li>
      <label for="host">Hébergeur</label>
      <span id="host">{$video->getHostName()|escape}</span>
    </li>
    <li>
      <label for="reference">Référence</label>
      <span id="reference">{$video->getReference()|escape}</span>
    </li>
    <li>
      <label for="groupe">Groupe</label>
      <select id="id_groupe" name="id_groupe">
        <option value="0">Sans</option>
        {foreach $groupes as $groupe}
        <option value="{$groupe.id}"{if $video->getIdGroupe() == $groupe.id} selected="selected"{/if}>{$groupe.name|escape}</option>
        {/foreach}
      </select>
    </li>
    <li>
      <label for="id_lieu">Lieu</label>
      <select id="id_lieu" name="id_lieu">
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
    </li>
    <li>
      <label for="event">Événement</label>
      <select id="id_event" name="id_event">
        <option value="0">Aucun</option>
      </select>
    </li>
    <li>
      <input id="online" class="switch" type="checkbox" name="online"{if $video->getOnline()} checked="checked"{/if}>
      <label for="online">Afficher</label>
    </li>
  </ul>
  <input id="form-video-edit-submit" name="form-video-edit-submit" type="submit" class="button" value="Enregistrer">
  <input type="hidden" name="id" value="{$video->getId()|escape}">
</form>

<p align="center"><a href="/videos/delete/{$video->getId()|escape}" class="button">Supprimer</a></p>

<p align="center">{$video->getPlayer()}</p>

{/if} {* test unknown video *}

  </div>
</div>

{include file="common/footer.tpl"}
