{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Éditer une photo</h1>
  </header>
  <div>

{if !empty($unknown_photo)}

<p class="infobulle error">Cette photo est introuvable !</p>

{else}

<form id="form-photo-edit" name="form-photo-edit" method="post" action="/photos/edit" enctype="multipart/form-data">
  <section class="grid-4">

    <div>
      <label for="photo">Photo</label>
    </div>
    <div class="col-3 mbs">
      <img id="photo" src="{$photo->getThumbUrl(320)}" alt=""/>
    </div>

    <div>
      <p>Pivoter la photo</p>
    </div>
    <div class="col-3 mbs">
      <div>
        <input type="radio" class="radio" name="rotation" id="rotation-0" value="0" checked>
        <label for="rotation-0" class="inline">∅ Aucune rotation</label>
      </div>
      <div>
        <input type="radio" class="radio" name="rotation" id="rotation-90cw" value="-90">
        <label for="rotation-90cw" class="inline">⤶ Rotation 90° horaire</label>
      </div>
      <div>
        <input type="radio" class="radio" name="rotation" id="rotation-90acw" value="90">
        <label for="rotation-90acw" class="inline">⤷ Rotation 90° anti-horaire</label>
      </div>
      <div>
        <input type="radio" class="radio" name="rotation" id="rotation-180" value="180">
        <label for="rotation-180" class="inline">↶ Rotation 180°</label>
      </div>
    </div>

    <div>
      <label for="id_contact">Ajouté le</label>
    </div>
    <div class="col-3 mbs">
      {$photo->getCreatedAt()|date_format:'%d/%m/%Y %H:%M'} par <a href="/membres/{$photo->getIdContact()}">{$photo->getPseudo()|escape}</a>
    </div>

    {if $photo->getModifiedAt()}
    <div>
      <label for="modified_at">Modifié le</label>
    </div>
    <div class="col-3 mbs">
      <span>{$photo->getModifiedAt()|date_format:'%d/%m/%Y %H:%M'}</span>
    </div>
    {/if}

    <div>
      <label for="name">Titre (*)</label>
    </div>
    <div class="col-3 mbs">
      <div class="infobulle error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez saisir un titre pour la photo</div>
      <input type="text" id="name" name="name" placeholder="Titre" class="w100" value="{$photo->getName()|escape}">
    </div>

    <div>
      <label for="credits">Crédits (*)</label>
    </div>
    <div class="col-3 mbs">
      <div class="infobulle error" id="error_credits"{if empty($error_credits)} style="display: none"{/if}>Vous devez saisir le nom du photographe</div>
      <input type="text" id="credits" name="credits" placeholder="Nom du photographe" class="w100" value="{$photo->getCredits()|escape}">
    </div>

    <div>
      <label for="id_groupe">Groupe</label>
    </div>
    <div class="col-3 mbs">
      <select name="id_groupe" class="w100">
        <option value="0">Aucun</option>
        {foreach $groupes as $groupe}
        <option value="{$groupe->getIdGroupe()}"{if $photo->getIdGroupe() == $groupe->getIdGroupe()} selected="selected"{/if}>{$groupe->getName()|escape}</option>
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
          <option value="{$lieu->getIdLieu()}"{if $photo->getIdLieu() === $lieu->getIdLieu()} selected="selected"{/if}>{$lieu->getCity()->getCp()} {$lieu->getCity()->getName()|escape} : {$lieu->getName()|escape}</option>
          {/foreach}
        </optgroup>
        {/foreach}
      </select>
    </div>

    <div>
      <label for="id_event">Evénement</label>
    </div>
    <div class="col-3 mbs">
      <select id="id_event" name="id_event" class="w100">
        <option value="0">Aucun</option>
      </select>
    </div>

    <div>
      <label for="online">Rendre public</label>
    </div>
    <div class="col-3 mbs">
      <input class="checkbox" type="checkbox" name="online"{if $photo->getOnline()} checked="checked"{/if}>
    </div>

    <div></div>
    <div class="col-2">
      <input name="form-photo-edit-submit" id="form-photo-edit-submit" class="btn btn--primary" type="submit" value="Enregistrer">
      <input type="hidden" name="id" id="id_photo" value="{$photo->getId()|escape}">
      <input type="hidden" name="photo_id_event" id="photo_id_event" value="{$photo->getIdEvent()|escape}">
    </div>
    <div class="txtright">
      <a class="btn btn--primary" href="/photos/delete/{$photo->getId()}">Supprimer la photo</a>
    </div>

  </section>



</form>

{/if} {* test unknown photo *}

  </div>
</div>

{include file="common/footer.tpl"}
