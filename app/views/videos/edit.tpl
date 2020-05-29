{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Éditer une vidéo</h1>
  </header>
  <div>

{if !empty($unknown_video)}

<p class="infobulle error">Cette vidéo est introuvable !</p>

{else}

<form id="form-video-edit" name="form-video-edit" method="post" action="/videos/edit">
  <section class="grid-6">
    <div class="col-1">
      <label for="name">Titre (*)</label>
    </div>
    <div class="col-5">
      <div class="infobulle error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez saisir un titre pour la vidéo</div>
      <input type="text" id="name" name="name" size="50" value="{$video->getName()|escape}">
    </div>
    <div class="col-1">
      <label for="host">Hébergeur</label>
    </div>
    <div class="col-5">
      <span id="host">{$video->getHost()->getName()|escape}</span>
    </div>
    <div class="col-1">
      <label for="reference">Référence</label>
    </div>
    <div class="col-5">
      <span id="reference">{$video->getReference()|escape}</span>
    </div>
    <div class="col-1">
      <label for="groupe">Groupe</label>
    </div>
    <div class="col-5">
      <select id="id_groupe" name="id_groupe">
        <option value="0">Sans</option>
        {foreach $groupes as $groupe}
        <option value="{$groupe->getIdGroupe()}"{if $video->getIdGroupe() == $groupe->getIdGroupe()} selected="selected"{/if}>{$groupe->getName()|escape}</option>
        {/foreach}
      </select>
    </div>
    <div class="col-1">
      <label for="id_lieu">Lieu</label>
    </div>
    <div class="col-5">
      <select id="id_lieu" name="id_lieu">
        <optgroup label="Autre">
          <option value="0">aucun / non référencé</option>
        </optgroup>
        {foreach from=$deps item=dep}
        <optgroup label="{$dep->getId()} - {$dep->getName()|escape}">
          {foreach from=$lieux[$dep->getId()] item=lieu}
          <option value="{$lieu->getIdLieu()}"{if $video->getIdLieu() === $lieu->getIdLieu()} selected="selected"{/if}>{$lieu->getCity()->getCp()} {$lieu->getCity()->getName()|escape} : {$lieu->getName()|escape}</option>
          {/foreach}
        </optgroup>
        {/foreach}
      </select>
    </div>
    <div class="col-1">
      <label for="event">Événement</label>
    </div>
    <div class="col-5">
      <select id="id_event" name="id_event">
        <option value="0">Aucun</option>
      </select>
    </div>
    <div class="col-1">
      <label for="online">Afficher publiquement</label>
    </div>
    <div class="col-5">
      <input class="switch" type="checkbox" name="online"{if $video->getOnline()} checked="checked"{/if}>
    </div>
    <div class="col-1"></div>
    <div class="col-5">
      <input id="form-video-edit-submit" name="form-video-edit-submit" type="submit" class="btn btn--primary" value="Enregistrer">
      <input type="hidden" name="id" value="{$video->getIdVideo()|escape}">
      <input type="hidden" name="video_id_event" id="video_id_event" value="{$video->getIdEvent()|escape}">
    </div>
  </section>
</form>

<p align="center"><a href="/videos/delete/{$video->getIdVideo()|escape}" class="btn btn--primary">Supprimer</a></p>

<p align="center">{$video->getPlayer()}</p>

{/if} {* test unknown video *}

  </div>
</div>

{include file="common/footer.tpl"}
