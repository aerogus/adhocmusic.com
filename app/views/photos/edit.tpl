{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Éditer une photo</h1>
  </header>
  <div>

{if !empty($unknown_photo)}

<p class="error">Cette photo est introuvable !</p>

{else}

<form id="form-photo-edit" name="form-photo-edit" method="post" action="/photos/edit" enctype="multipart/form-data">
  <ul>
    <li>
      <label for="file">Photo (.jpg)</label>
      <input type="file" name="file" id="file" value="">
    </li>
    <li>
      <p style="text-align: center"><img src="{$photo->getThumb400Url()}" alt=""></p>
    </li>
    <li>
      <label for="id_contact">Ajouté par</label>
      <span><a href="/membre/show/{$photo->getIdContact()}">{$photo->getPseudo()|escape}</a> le {$photo->getCreatedOn()|date_format:'%d/%m/%Y %H:%M'}</span>
    </li>
    {if $photo->getModifiedOn()}
    <li>
      <label for="modified_on">Modifié le</label>
      <span>{$photo->getModifiedOn()|date_format:'%d/%m/%Y %H:%M'}</span>
    </li>
    {/if}
    <li>
      <label for="name">Titre</label>
      <div class="error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez saisir un titre pour la photo</div>
      <input type="text" id="name" name="name" size="50" value="{$photo->getName()|escape}">
    </li>
    <li>
      <label for="credits">Photographe</label>
      <div class="error" id="error_credits"{if empty($error_credits)} style="display: none"{/if}>Vous devez saisir le nom du photographe</div>
      <input type="text" id="credits" name="credits" size="50" value="{$photo->getCredits()|escape}">
    </li>
    <li>
      <label for="id_groupe">Groupe</label>
      <select name="id_groupe" style="float: right">
        <option value="0">Aucun</option>
        {foreach from=$groupes item=groupe}
        <option value="{$groupe.id}"{if $photo->getIdGroupe() == $groupe.id} selected="selected"{/if}>{$groupe.name|escape}</option>
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
          <option value="{$lieu.id}"{if $photo->getIdLieu() == $lieu.id} selected="selected"{/if}>{$lieu.cp} {$lieu.city|escape} : {$lieu.name|escape}</option>
          {/foreach}
        </optgroup>
        {/foreach}
      </select>
    </li>
    <li>
      <label for="id_event">Evénement</label>
      <select id="id_event" name="id_event">
        <option value="0">Aucun</option>
      </select>
    </li>
    <li>
      <label for="online">Afficher publiquement</label>
      <input type="checkbox" name="online"{if $photo->getOnline()} checked="checked"{/if}>
    </li>
  </ul>
  <input name="form-photo-edit-submit" id="form-photo-edit-submit" class="button" type="submit" value="Enregistrer">
  <input type="hidden" name="id" value="{$photo->getId()|escape}">
  <a class="button" href="/photos/delete/{$photo->getId()}">Supprimer la photo</a>
</form>

{/if} {* test unknown photo *}

  </div>
</div>

{include file="common/footer.tpl"}
