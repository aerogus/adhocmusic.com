{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Modifier une structure</h1>
  </header>
  <div>

<form id="form-structure-edit" name="form-structure-edit" method="post" action="/structures/edit">
  <fieldset>
    <ul>
      <li>
        <div class="infobulle error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez saisir un titre pour la structure</div>
        <label for="name">Nom</label>
        <input type="text" id="name" name="name" value="{$structure->getName()|escape}">
      </li>
    </ul>
  </fieldset>
  <input id="form-structure-edit-submit" name="form-structure-edit-submit" type="submit" value="Modifier">
  <input type="hidden" name="id" value="{$structure->getId()|escape}">
</form>

  </div>
</div>

{include file="common/footer.tpl"}
