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
      <section class="grid-4">
        <div>
          <label for="mp3">Écouter</label>
        </div>
        <div class="col-3">
          <audio controls id="mp3" src="{$audio->getDirectMp3Url()}"></audio>
        </div>
        <div>
          <label for="name">Nom</label>
        </div>
        <div class="col-3">
          <span id="name">{$audio->getName()|escape}</span>
        </div>
        {if !empty($groupe)}
        <div>
          <label for="groupe">Groupe</label>
        </div>
        <div class="col-3">
          <span id="groupe">{$groupe->getName()|escape}</span>
        </div>
        {/if}
        {if !empty($event)}
        <div>
          <label for="event">Événement</label>
        </div>
        <div class="col-3">
          <span id="event">{$event->getDate()|date_format:"%d/%m/%Y %h:%i"} - {$event->getName()|escape}</span>
        </div>
        {/if}
        {if !empty($lieu)}
        <div>
          <label for="lieu">Lieu</label>
        </div>
        <div class="col-3">
          <span id="lieu">{$lieu->getIdDepartement()} - {$lieu->getName()|escape}</span>
        </div>
        {/if}
        <div>
          <label for="online">Afficher</label>
        </div>
        <div class="col-3">
          <span id="online">{$audio->getOnline()}</span>
        </div>
        {if !empty($membre)}
        <div>
          <label for="created_at">Envoyé le</label>
        </div>
        <div class="col-3">
          <span id="created_at">{$audio->getCreatedAt()|date_format:"%d/%m/%Y à %H:%M"} par <a href="{$membre->getUrl()}">{$membre->getPseudo()|escape}</a></span>
        </div>
        {/if}
        {if $audio->getModifiedAt()}
        <div>
          <label for="modified_at">Modifié le</label>
        </div>
        <div class="col-3">
          <span id="modified_at">{$audio->getModifiedAt()|date_format:"%d/%m/%Y à %H:%M"}</span>
        </div>
        {/if}
        <div>
          <label for="mp3">Ecouter</label>
        </div>
        <div class="col-3">
          <audio id="mp3" src="{$audio->getDirectMp3Url()}"></audio>
        </div>
        <div></div>
        <div class="col-3">
          <input id="form-audio-delete-submit" name="form-audio-delete-submit" class="btn btn--primary w100" type="submit" value="Supprimer">
          <input type="hidden" name="id" value="{$audio->getId()|escape}">
        </div>
      </section>
    </form>

    {/if}

  </div>
</div>

{include file="common/footer.tpl"}
