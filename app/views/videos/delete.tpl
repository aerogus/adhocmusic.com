{include file="common/header.tpl"}

{if !empty($unknown_video)}

<p class="infobulle error">Cette vidéo est introuvable !</p>

{else}

<div class="box">
  <header>
    <h1>Supprimer une vidéo</h1>
  </header>
  <div>
  <form method="post" action="/videos/delete">
    <ul>
      <li>
        <label for="name">Nom</label>
        <span id="name">{$video->getName()|escape}</span>
      </li>
      <li>
        <label for="thumb">Miniature</label>
        <span id="thumb"><img src="{$video->getThumbnailUrl()}" alt=""></span>
      </li>
      <li>
        <label for="id_host">Hébergeur</label>
        <span id="id_host">{$video->getIdHost()}</span>
      </li>
      <li>
        <label for="reference">Référence</label>
        <span id="reference">{$video->getReference()}</span>
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
        <span id="event">{$event->getDate()} - {$event->getName()|escape}</span>
      </li>
      {/if}
      {if !empty($lieu)}
      <li>
        <label for="lieu">Lieu</label>
        <span id="lieu">{$lieu->getName()|escape}</span>
      </li>
      {/if}
      <li>
        <label for="online">Afficher</label>
        <span id="online">{$video->getOnline()}</span>
      </li>
      <li>
        <label for="player">Voir</label>
        <span id="player">{$video->getPlayer()}</span>
      </li>
    </ul>
    <input id="form-video-delete-submit" name="form-video-delete-submit" class="button" type="submit" value="Confirmer la suppression">
    <input type="hidden" name="id" value="{$video->getId()|escape}">
  </form>
  </div>
</div>

{/if}

{include file="common/footer.tpl"}

