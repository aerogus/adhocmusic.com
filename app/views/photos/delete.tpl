{include file="common/header.tpl"}

{if !empty($unknown_photo)}

<p class="infobulle error">Cette photo est introuvable !</p>

{else}

<div class="box">
  <header>
    <h1>Supprimer une photo</h1>
  </header>
  <div>
    <form id="form-photo-delete" name="form-photo-delete" method="post" action="/photos/delete">
      <ul>
        <li>
          <img src="{$photo->getThumbUrl(320)}" alt="">
        </li>
        <li>
          Titre : {$photo->getName()|escape}
        </li>
        <li>
          Photographe : {$photo->getCredits()|escape}
        </li>
        {if !empty($groupe)}
        <li>
          Groupe : {$groupe->getName()|escape}
        </li>
        {/if}
        {if !empty($event)}
        <li>
          Événement : {$event->getDate()} - {$event->getName()|escape}
        </li>
        {/if}
        {if !empty($lieu)}
        <li>
          Lieu : {$lieu->getIdDepartement()} - {$lieu->getName()|escape}
        </li>
        {/if}
      </ul>
      <input id="form-photo-delete-submit" name="form-photo-delete-submit" type="submit" class="btn btn--primary" value="Supprimer">
      <input type="hidden" name="id" value="{$photo->getId()}">
    </form>
  </div>
</div>

{/if}

{include file="common/footer.tpl"}
