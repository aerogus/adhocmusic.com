{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Supprimer une date</h1>
  </header>
  <div>

<form name="form-event-delete" id="form-event-delete" action="/events/delete" method="post">
  <fieldset>
    <ul>
      <li><strong>Lieu :</strong><br>{$lieu->getName()|escape}</li>
      <li><strong>Titre :</strong><br>{$event->getName()|escape}</li>
      <li><strong>Date :</strong><br>{$event->getDate()|escape}</li>
      <li><strong>Description :</strong><br>{$event->getText()|escape}</li>
      <li><strong>Tarif :</strong><br>{$event->getPrice()|escape}</li>
    </ul>
  </fieldset>
  <input id="form-event-delete-submit" name="form-event-delete-submit" class="btn btn--primary" type="submit" value="Supprimer">
  <input type="hidden" name="id" value="{$event->getId()|escape}">
</form>

  </div>
</div>

{include file="common/footer.tpl"}
