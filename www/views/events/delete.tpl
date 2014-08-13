{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Supprimer une date"}

<form name="form-event-delete" id="form-event-delete" action="/events/delete" method="post">
  <fieldset>
    <ol>
      <li><strong>Lieu :</strong><br />{$lieu->getName()|escape}</li>
      <li><strong>Titre :</strong><br />{$event->getName()|escape}</li>
      <li><strong>Date :</strong><br />{$event->getDate()|escape}</li>
      <li><strong>Description :</strong><br />{$event->getText()|escape}</li>
      <li><strong>Tarif :</strong><br />{$event->getPrice()|escape}</li>
    </ol>
  </fieldset>
  <input id="form-event-delete-submit" name="form-event-delete-submit" class="button" type="submit" value="Supprimer" />
  <input type="hidden" name="id" value="{$event->getId()|escape}" />
</form>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
