{include file="common/header.tpl"}

{if !empty($unknown_video)}

<p class="infobulle error">Cette vidéo est introuvable !</p>

{else}

<div class="box">
  <header>
    <h1>Supprimer une vidéo</h1>
  </header>
  <div>
  <form id="form-video-delete" name="form-video-delete" method="post" action="/videos/delete">
    <section class="grid-4">
      <div>
        <label for="player">Visualiser</label>
      </div>
      <div class="col-3 mbs">
        <span id="player">{$video->getPlayer()}</span>
      </div>
      <div>
        <label for="name">Nom</label>
      </div>
      <div class="col-3 mbs">
        <span id="name">{$video->getName()|escape}</span>
      </div>
      <div>
        <label for="thumb">Miniature</label>
      </div>
      <div class="col-3 mbs">
        <span id="thumb"><img src="{$video->getThumbUrl()}" alt=""></span>
      </div>
      <div>
        <label for="id_host">Hébergeur</label>
      </div>
      <div class="col-3 mbs">
        <span id="id_host">{$video->getHost()->getName()}</span>
      </div>
      <div>
        <label for="reference">Référence</label>
      </div>
      <div class="col-3 mbs">
        <span id="reference">{$video->getReference()}</span>
      </div>
      {if !empty($groupe)}
      <div>
        <label for="groupe">Groupe</label>
      </div>
      <div class="col-3 mbs">
        <span id="groupe">{$groupe->getName()|escape}</span>
      </div>
      {/if}
      {if !empty($event)}
      <div>
        <label for="event">Événement</label>
      </div>
      <div class="col-3 mbs">
        <span id="event">{$event->getDate()} - {$event->getName()|escape}</span>
      </div>
      {/if}
      {if !empty($lieu)}
      <div>
        <label for="lieu">Lieu</label>
      </div>
      <div class="col-3 mbs">
        <span id="lieu">{$lieu->getName()|escape}</span>
      </div>
      {/if}
      <div>
        <label for="online">Afficher</label>
      </div>
      <div class="col-3 mbs">
        <span id="online">{$video->getOnline()}</span>
      </div>
      <div></div>
      <div class="col-3">
        <input id="form-video-delete-submit" name="form-video-delete-submit" class="btn btn--primary" type="submit" value="Confirmer la suppression">
        <input type="hidden" name="id" value="{$video->getId()|escape}">
      </div>
    </section>
  </form>
  </div>
</div>

{/if}

{include file="common/footer.tpl"}

