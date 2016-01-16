{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Editer une photo"}

{if !empty($unknown_photo)}

<p class="error">Cette photo est introuvable !</p>

{else}

<form id="form-photo-edit" name="form-photo-edit" method="post" action="/photos/edit" enctype="multipart/form-data">
  <ol>
    <li>
      <input type="file" name="file" id="file" value="" style="float: right;" />
      <label for="file"><img src="{#STATIC_URL#}/img/icones/photo.png" alt="" /> Photo (.jpg)</label>
    </li>
    <li>
      <p style="text-align: center"><img src="{$photo->getThumb400Url()}" alt="" /></p>
    </li>
    <li>
      <span style="float: right;"><a href="/membre/show/{$photo->getIdContact()}">{$photo->getPseudo()|escape}</a> le {$photo->getCreatedOn()|date_format:'%d/%m/%Y %H:%M'}</span>
      <label for="id_contact">Ajouté par</label>
    </li>
    {if $photo->getModifiedOn()}
    <li>
      <span style="float: right;">{$photo->getModifiedOn()|date_format:'%d/%m/%Y %H:%M'}</span>
      <label for="modified_on">Modifié le</label>
    </li>
    {/if}
    <li>
      <div class="error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez saisir un titre pour la photo</div>
      <input type="text" id="name" name="name" size="50" value="{$photo->getName()|escape}" style="float: right" />
      <label for="name"><img src="{#STATIC_URL#}/img/icones/signature.png" alt="" /> Titre</label>
    </li>
    <li>
      <div class="error" id="error_credits"{if empty($error_credits)} style="display: none"{/if}>Vous devez saisir le nom du photographe</div>
      <input type="text" id="credits" name="credits" size="50" value="{$photo->getCredits()|escape}" style="float: right" />
      <label for="credits"><img src="{#STATIC_URL#}/img/icones/photo.png" alt="" /> Photographe</label>
    </li>
    <li>
      <select name="id_groupe" style="float: right">
        <option value="0">Aucun</option>
        {foreach from=$groupes item=groupe}
        <option value="{$groupe.id}"{if $photo->getIdGroupe() == $groupe.id} selected="selected"{/if}>{$groupe.name|escape}</option>
        {/foreach}
      </select>
      <label for="id_groupe"><img src="{#STATIC_URL#}/img/icones/groupe.png" alt="" /> Groupe</label>
    </li>
    <li>
      <select id="id_lieu" name="id_lieu" style="float: right">
        <optgroup label="Autre">
          <option value="0">aucun / non référencé</option>
        </optgroup>
        {foreach from=$dep item=dep_name key=dep_id}
        <optgroup label="{$dep_id} - {$dep_name|escape}">
          {foreach from=$lieux[$dep_id] item=lieu}
          <option value="{$lieu.id}"{if $photo->getIdLieu() == $lieu.id} selected="selected"{/if}>{$lieu.cp} {$lieu.city|escape} : {$lieu.name|escape}</option>
          {/foreach}
        </optgroup>
        {/foreach}
      </select>
      <label for="id_lieu"><img src="{#STATIC_URL#}/img/icones/lieu.png" alt="" /> Lieu</label>
    </li>
    <li>
      <select id="id_event" name="id_event" style="float: right">
        <option value="0">Aucun</option>
      </select>
      <label for="id_event"><img src="{#STATIC_URL#}/img/icones/event.png" alt="" /> Evénement</label>
    </li>
    <li>
      <input type="checkbox" name="online"{if $photo->getOnline()} checked="checked"{/if} style="float: right" />
      <label for="online"><img src="{#STATIC_URL#}/img/icones/eye.png" alt="" /> Afficher publiquement</label>
    </li>
  </ol>
  <input name="form-photo-edit-submit" id="form-photo-edit-submit" class="button" type="submit" value="Enregistrer" />
  <input type="hidden" name="id" value="{$photo->getId()|escape}" />
  <a class="button" href="/photos/delete/{$photo->getId()}">Supprimer la photo</a>
</form>

{/if} {* test unknown photo *}

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
