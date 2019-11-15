{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Éditer une Musique</h1>
  </header>
  <div>

    {if !empty($unknown_audio)}

    <p class="infobulle error">Cet audio est introuvable !</p>

    {else}

    <form name="form-audio-edit" id="form-audio-edit" method="post" action="/audios/edit" enctype="multipart/form-data">
      <ul>
        <li>
          <label for="mp3">Écouter</label>
          <audio controls id="mp3" src="{$audio->getDirectMp3Url()}"></audio>
        </li>
        <li>
          <label for="file">Audio (*) (.mp3 16bits/44Khz/stéréo, &lt; 16 Mo)</label>
          <input type="file" id="file" name="file" value="">
        </li>
        <li>
          <label for="name">Titre (*) </label>
          <div class="infobulle error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez renseigner un titre</div>
          <input type="text" id="name" name="name" size="50" value="{$audio->getName()|escape}">
        </li>
        <li>
          <label for="id_groupe">Groupe</label>
          <div class="infobulle error" id="error_id_groupe"{if empty($error_id_groupe)} style="display: none"{/if}>Vous devez sélectionner un groupe</div>
          <select id="id_groupe" name="id_groupe">
            <option value="0">Sans</option>
            {foreach from=$groupes item=groupe}
            <option value="{$groupe->getId()}"{if $audio->getIdGroupe() === $groupe->getIdGroupe()} selected="selected"{/if}>{$groupe->getName()|escape}</option>
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
              {foreach from=$lieux.$dep_id item=lieu}
              <option value="{$lieu->getIdLieu()}"{if $audio->getIdLieu() === $lieu->getIdLieu()} selected="selected"{/if}>{$lieu->getCp()} {$lieu->getCity()|escape} : {$lieu->getName()|escape}</option>
              {/foreach}
            </optgroup>
            {/foreach}
          </select>
        </li>
        <li>
          <label for="id_event">Événement</label>
          <select id="id_event" name="id_event">
            <option value="0">Aucun</option>
          </select>
        </li>
        <li>
          <label for="online">Afficher publiquement</label>
          <input class="switch" type="checkbox" name="online"{if $audio->getOnline()} checked="checked"{/if}>
        </li>
        <li>
          <label for="created_on">Envoyé par</label>
          <span id="created_on"><a href="{$membre->getUrl()}">{$membre->getPseudo()|escape}</a>
          le {$audio->getCreatedOn()|date_format:"%d/%m/%Y à %H:%M"}</span>
        </li>
        <li>
          <label for="modified_on">Modifié le</label>
          <span id="modified_on">{$audio->getModifiedOn()|date_format:"%d/%m/%Y à %H:%M"}</span>
        </li>
        <li>
          <label for="delete">Supprimer</label>
          <span id="delete"><a href="/audios/delete/{$audio->getId()}">Supprimer</a></span>
        </li>
      </ul>
      <input id="form-audio-edit-submit" name="form-audio-edit-submit" class="button" type="submit" value="Enregistrer">
      <input type="hidden" name="id" value="{$audio->getId()}">
    </form>

{/if} {* test unknown audio *}

  </div>
</div>

{include file="common/footer.tpl"}
