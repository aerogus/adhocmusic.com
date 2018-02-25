{include file="common/header.tpl"}

{if !empty($unknown_video)}

<p class="infobulle error">Cette vidéo est introuvable !</p>

{else}

{include file="common/boxstart.tpl" boxtitle="Supprimer une vidéo"}
<form method="post" action="/videos/delete">
  <fieldset>
    <ol>
      <li>
        <span id="name" style="float: right;">{$video->getName()|escape}</span>
        <label for="name">Nom</label>
      </li>
      <li>
        <span id="thumb" style="float: right;"><img src="/media/video/{$video->getId()}.jpg" alt=""></span>
        <label for="thumb">Miniature</label>
      </li>
      <li>
        <span id="id_host" style="float: right;">{$video->getIdHost()}</span>
        <label for="id_host">Hébergeur</label>
      </li>
      <li>
        <span id="reference" style="float: right;">{$video->getReference()}</span>
        <label for="reference">Référence</label>
      </li>
      {if !empty($groupe)}
      <li>
        <span id="groupe" style="float: right;">{$groupe->getName()|escape}</span>
        <label for="groupe">Groupe</label>
      </li>
      {/if}
      {if !empty($event)}
      <li>
        <span id="event" style="float: right;">{$event->getDate()} - {$event->getName()|escape}</span>
        <label for="event">Evénement</label>
      </li>
      {/if}
      {if !empty($lieu)}
      <li>
        <span id="lieu" style="float: right;">{$lieu->getName()|escape}</span>
        <label for="lieu">Lieu</label>
      </li>
      {/if}
      <li>
        <span id="online" style="float: right;">{$video->getOnline()}</span>
        <label for="online">Afficher</label>
      </li>
      <li>
        <span id="player" style="float: right;">{$video->getPlayer()}</span>
        <label for="player">Voir</label>
      </li>
    </ol>
  </fieldset>
  <input id="form-video-delete-submit" name="form-video-delete-submit" class="button" type="submit" value="Confirmer la suppression">
  <input type="hidden" name="id" value="{$video->getId()|escape}">
</form>
{include file="common/boxend.tpl"}

{/if}

{include file="common/footer.tpl"}

