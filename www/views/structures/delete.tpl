{include file="common/header.tpl"}

<script>
$(function() {
  $("#form-structure-delete").submit(function() {
    var valid = true;
    return valid;
  });
});
</script>

{include file="common/boxstart.tpl" boxtitle="Effacer une structure"}

<form id="form-structure-delete" name="form-structure-delete" method="post" action="/structures/delete">
  <fieldset>
  <ol>
    <li>
      <label for="name">Nom</label>
      <input type="text" id="name" name="name" value="{$structure->getName()|escape}" readonly="readonly" />
    </li>
  </ol>
  </fieldset>
  <input id="form-structure-delete-submit" name="form-structure-delete-submit" type="submit" value="Supprimer" />
  <input type="hidden" name="id" value="{$structure->getId()}" />
</form>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
