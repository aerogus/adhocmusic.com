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
  <section class="grid-4">
    <div>
      <label for="name">Titre (*)</label>
    </div>
    <div class="col-3 mbs">
      <div class="infobulle error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez saisir un titre pour la vidéo</div>
      <input type="text" id="name" name="name" class="w100" value="{$video->getName()|escape}">
    </div>
    <div>
      <label for="host">Hébergeur</label>
    </div>
    <div class="col-3 mbs">
      <span id="host">{$video->getHost()->getName()|escape}</span>
    </div>
    <div>
      <label for="reference">Référence</label>
    </div>
    <div class="col-3 mbs">
      <span id="reference">{$video->getReference()|escape}</span>
    </div>
    <div>
      <label for="player">Visualiser</label>
    </div>
    <div class="col-3 mbs">
      {$video->getPlayer()}
    </div>
    <div>
      <label for="groupe">Groupe</label>
    </div>
    <div class="col-3 mbs">
      <select id="id_groupe" name="id_groupe" class="w100">
        <option value="0">Sans</option>
        {foreach $groupes as $groupe}
        <option value="{$groupe->getIdGroupe()}"{if $video->getIdGroupe() == $groupe->getIdGroupe()} selected="selected"{/if}>{$groupe->getName()|escape}</option>
        {/foreach}
      </select>
    </div>
    <div>
      <label for="id_lieu">Lieu</label>
    </div>
    <div class="col-3 mbs">
      <select id="id_lieu" name="id_lieu" class="w100">
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
    <div>
      <label for="event">Événement</label>
    </div>
    <div class="col-3 mbs">
      <select id="id_event" name="id_event" class="w100">
        <option value="0">Aucun</option>
      </select>
    </div>
    <div>
      <label for="online">Afficher publiquement</label>
    </div>
    <div class="col-3 mbs">
      <input class="checkbox" type="checkbox" name="online"{if $video->getOnline()} checked="checked"{/if}>
    </div>
    <div></div>
    <div class="col-2">
      <input id="form-video-edit-submit" name="form-video-edit-submit" type="submit" class="btn btn--primary" value="Enregistrer">
      <input type="hidden" name="id" value="{$video->getIdVideo()|escape}">
      <input type="hidden" name="video_id_event" id="video_id_event" value="{$video->getIdEvent()|escape}">
    </div>
    <div class="txtright">
      <a href="/videos/delete/{$video->getIdVideo()|escape}" class="btn btn--primary">Supprimer</a>
    </div>
  </section>
</form>


{/if} {* test unknown video *}

  </div>
</div>

{include file="common/footer.tpl"}
