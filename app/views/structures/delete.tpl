{include file="common/header.tpl"}

<div class="box">
  <header>
    <h2>Effacer une structure</h2>
  </header>
  <div>

<form id="form-structure-delete" name="form-structure-delete" method="post" action="/structures/delete">
  <fieldset>
    <ul>
      <li>
        <label for="name">Nom</label>
        <input type="text" id="name" name="name" value="{$structure->getName()|escape}" readonly="readonly">
      </li>
    </ul>
  </fieldset>
  <input id="form-structure-delete-submit" name="form-structure-delete-submit" type="submit" value="Supprimer">
  <input type="hidden" name="id" value="{$structure->getId()}">
</form>

  </div>
</div>

{include file="common/footer.tpl"}
