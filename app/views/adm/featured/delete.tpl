{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Suppression à l'affiche</h1>
  </header>
  <div>
    <form id="form-featured-delete" name="form-featured-delete" action="/adm/featured/delete" method="post">
      <ul>
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
      <input id="form-featured-delete-submit" name="form-featured-delete-submit" type="submit" value="Confirmer la suppression">
      <input type="hidden" name="id" value="{$featured->getId()}">
    </form>
  </div>
</div>

{include file="common/footer.tpl"}
