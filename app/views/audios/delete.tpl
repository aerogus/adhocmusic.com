{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Supprimer un son</h1>
  </header>
  <div>

    {if !empty($unknown_audio)}

    <p class="infobulle error">Cet audio est introuvable !</p>

    {else}

    <form id="form-audio-delete" name="form-audio-delete" method="post" action="/audios/delete">
      <ul>
        <li>
          <label for="mp3">Écouter</label>
          <audio controls id="mp3" src="{$audio->getDirectMp3Url()}"></audio>
        </li>
        <li>
          <label for="name">Nom</label>
          <span id="name">{$audio->getName()|escape}</span>
        </li>
        {if !empty($groupe)}
        <li>
          <label for="groupe">Groupe</label>
          <span id="groupe">{$groupe->getName()|escape}</span>
        </li>
        {/if}
        {if !empty($event)}
        <li>
          <label for="event">Événement</label>
          <span id="event">{$event->getDate()|date_format:"%d/%m/%Y %h:%i"} - {$event->getName()|escape}</span>
        </li>
        {/if}
        {if !empty($lieu)}
        <li>
          <label for="lieu">Lieu</label>
          <span id="lieu">{$lieu->getIdDepartement()} - {$lieu->getName()|escape}</span>
        </li>
        {/if}
        <li>
          <label for="online">Afficher</label>
          <span id="online">{$audio->getOnline()}</span>
        </li>
        {if !empty($membre)}
        <li>
          <label for="created_at">Envoyé par</label>
          <span id="created_at"><a href="{$membre->getUrl()}">{$membre->getPseudo()|escape}</a> le {$audio->getCreatedAt()|date_format:"%d/%m/%Y à %H:%M"}</span>
        </li>
        {/if}
        <li>
          <label for="modified_at">Modifié le</label>
          <span id="modified_at" style="float: right;">{$audio->getModifiedAt()|date_format:"%d/%m/%Y à %H:%M"}</span>
        </li>
        <li>
          <label for="mp3">Ecouter</label>
          <audio id="mp3" src="{$audio->getDirectMp3Url()}"></audio>
        </li>
      </ul>
      <input id="form-audio-delete-submit" name="form-audio-delete-submit" class="button" type="submit" value="Supprimer">
      <input type="hidden" name="id" value="{$audio->getId()|escape}">
    </form>

    {/if}

  </div>
</div>

{include file="common/footer.tpl"}
