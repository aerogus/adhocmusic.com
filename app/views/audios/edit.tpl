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
      <section class="grid-4">
        <div>
          <label for="mp3">Écouter</label>
        </div>
        <div class="col-3 mbs">
          <audio controls id="mp3" src="{$audio->getDirectMp3Url()}"></audio>
        </div>
        <div>
          <label for="name">Titre (*) </label>
        </div>
        <div class="col-3 mbs">
          <div class="infobulle error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez renseigner un titre</div>
          <input type="text" id="name" name="name" class="w100" value="{$audio->getName()|escape}">
        </div>
        <div>
          <label for="id_groupe">Groupe</label>
        </div>
        <div class="col-3 mbs">
          <div class="infobulle error" id="error_id_groupe"{if empty($error_id_groupe)} style="display: none"{/if}>Vous devez sélectionner un groupe</div>
          <select id="id_groupe" name="id_groupe" class="w100">
            <option value="0">Sans</option>
            {foreach from=$groupes item=groupe}
            <option value="{$groupe->getId()}"{if $audio->getIdGroupe() === $groupe->getIdGroupe()} selected="selected"{/if}>{$groupe->getName()|escape}</option>
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
            {foreach from=$dep item=dep_name key=dep_id}
            <optgroup label="{$dep_id} - {$dep_name|escape}">
              {foreach from=$lieux.$dep_id item=lieu}
              <option value="{$lieu->getIdLieu()}"{if $audio->getIdLieu() === $lieu->getIdLieu()} selected="selected"{/if}>{$lieu->getCity()->getCp()} {$lieu->getCity()->getName()|escape} : {$lieu->getName()|escape}</option>
              {/foreach}
            </optgroup>
            {/foreach}
          </select>
        </div>
        <div>
          <label for="id_event">Événement</label>
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
          <input class="checkbox" type="checkbox" name="online"{if $audio->getOnline()} checked="checked"{/if}>
        </div>
        <div>
          <label for="created_at">Envoyé le</label>
        </div>
        <div class="col-3 mbs">
          <span id="created_at">{$audio->getCreatedAt()|date_format:"%d/%m/%Y à %H:%M"} par <a href="{$membre->getUrl()}">{$membre->getPseudo()|escape}</a></span>
        </div>
        {if $audio->getModifiedAt()}
        <div>
          <label for="modified_at">Modifié le</label>
        </div>
        <div class="col-3 mbs">
          <span id="modified_at">{$audio->getModifiedAt()|date_format:"%d/%m/%Y à %H:%M"}</span>
        </div>
        {/if}
        <div></div>
        <div class="col-2">
          <input id="form-audio-edit-submit" name="form-audio-edit-submit" class="btn btn--primary w100" type="submit" value="Enregistrer">
          <input type="hidden" name="id" value="{$audio->getId()}">
          <input type="hidden" name="audio_id_event" id="audio_id_event" value="{$audio->getIdEvent()|escape}">
        </div>
        <div class="txtright">
          <span id="delete"><a href="/audios/delete/{$audio->getId()}" class="btn btn--primary">Supprimer</a></span>
        </div>
      </section>
    </form>

{/if} {* test unknown audio *}

  </div>
</div>

{include file="common/footer.tpl"}
