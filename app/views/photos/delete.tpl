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
      <section class="grid-4">

        <div>
          <label for="photo">Photo</label>
        </div>
        <div class="col-3 mbs">
          <img src="{$photo->getThumbUrl(320)}" alt="">
        </div>

        <div>Titre</div>
        <div class="col-3 mbs">{$photo->getName()|escape}</div>

        <div>Photographe</div>
        <div class="col-3 mbs">{$photo->getCredits()|escape}</div>

        {if !empty($groupe)}
        <div>Groupe</div>
        <div class="col-3 mbs">{$groupe->getName()|escape}</div>
        {/if}

        {if !empty($event)}
        <div>Événement</div>
        <div class="col-3 mbs">{$event->getDate()} - {$event->getName()|escape}</div>
        {/if}

        {if !empty($lieu)}
        <div>Lieu :</div>
        <div class="col-3 mbs">{$lieu->getIdDepartement()} - {$lieu->getName()|escape}</div>
        {/if}

        <div></div>
        <div class="col-3">
          <input id="form-photo-delete-submit" name="form-photo-delete-submit" type="submit" class="btn btn--primary" value="Supprimer">
          <input type="hidden" name="id" value="{$photo->getId()}">
        </div>

      </section>

    </form>
  </div>
</div>

{/if}

{include file="common/footer.tpl"}
