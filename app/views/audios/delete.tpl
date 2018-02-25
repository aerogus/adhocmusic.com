{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Supprimer un Son"}

{if !empty($unknown_audio)}

<p class="infobulle error">Cet audio est introuvable !</p>

{else}

<form id="form-audio-delete" name="form-audio-delete" method="post" action="/audios/delete">
  <fieldset style="width: 75%;">
    <ol>
      <li>
        <span id="name" style="float: right;">{$audio->getName()|escape}</span>
        <label for="name">Nom</label>
      </li>
      {if !empty($groupe)}
      <li>
        <span id="groupe" style="float: right;">{$groupe->getName()|escape}</span>
        <label for="groupe">Groupe</label>
      </li>
      {/if}
      {if !empty($event)}
      <li>
        <span id="event" style="float: right;">{$event->getDate()|date_format:"%d/%m/%Y %h:%i"} - {$event->getName()|escape}</span>
        <label for="event">Evénement</label>
      </li>
      {/if}
      {if !empty($lieu)}
        <li>
          <span id="lieu" style="float: right;">{$lieu->getIdDepartement()} - {$lieu->getName()|escape}</span>
          <label for="lieu">Lieu</label>
        </li>
      {/if}
      <li>
        <span id="online" style="float: right;">{$audio->getOnline()}</span>
        <label for="online">Afficher</label>
      </li>
      {if !empty($membre)}
      <li>
        <span id="created_on" style="float: right;"><a href="{$membre->getUrl()}">{$membre->getPseudo()|escape}</a> le {$audio->getCreatedOn()|date_format:"%d/%m/%Y à %H:%M"}</span>
        <label for="created_on"><img src="/img/icones/upload.png" alt=""> Envoyé par</label>
      </li>
      {/if}
      <li>
        <span id="modified_on" style="float: right;">{$audio->getModifiedOn()|date_format:"%d/%m/%Y à %H:%M"}</span>
        <label for="modified_on"><img src="/img/icones/eye.png" alt=""> Modifié le</label>
      </li>
      <li>
        <span id="mp3" style="float: right;">{audio_player id=$audio->getId()}</span>
        <label for="mp3">Ecouter</label>
      </li>
    </ol>
  </fieldset>
  <input id="form-audio-delete-submit" name="form-audio-delete-submit" class="button" type="submit" value="Supprimer">
  <input type="hidden" name="id" value="{$audio->getId()|escape}">
</form>

{/if}

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
