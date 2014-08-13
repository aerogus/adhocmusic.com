{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Suppression à l'affiche"}

<form id="form-featured-delete" name="form-featured-delete" action="/adm/featured/delete" method="post">
  <fieldset>
    <ol>
     <li>
       <label for="slot">Slot</label>
       <strong>{$featured->getSlotName()|escape}</strong>
     </li>
     <li>
        <label for="title">Titre</label>
        <strong>{$featured->getTitle()|escape}</strong>
      </li>
      <li>
        <label for="description">Description</label>
        <strong>{$featured->getDescription()|escape}</strong>
      </li>
      <li>
        <label for="image">Image</label>
        <img src="{$featured->getImage()}" alt="" />
      </li>
      <li>
        <label for="datdeb">Début</label>
        <strong>{$featured->getDatDeb()|escape}</strong>
      </li>
      <li>
        <label for="datfin">Fin</label>
        <strong>{$featured->getDatFin()|escape}</strong>
      </li>
      <li>
        <label for="online">En ligne</label>
        <strong>{$featured->getOnline()|display_on_off_icon}</strong>
      </li>
    </ol>
  </fieldset>
  <input id="form-featured-delete-submit" name="form-featured-delete-submit" type="submit" value="Confirmer la suppression" />
  <input type="hidden" name="id" value="{$featured->getId()}" />
</form>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
