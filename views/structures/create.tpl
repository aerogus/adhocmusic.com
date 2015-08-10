{include file="common/header.tpl"}

<script>
$(function() {
  $("#form-structure-create").submit(function() {
    var valid = true;
    if($("#name").val() == "") {
      $("#name").prev(".error").fadeIn();
      valid = false;
    } else {
      $("#name").prev(".error").fadeOut();
    }
    return valid;
  });
});
</script>

{include file="common/boxstart.tpl" boxtitle="Proposer une structure"}

<form id="form-structure-create" name="form-structure-create" method="post" action="/structures/create">
  <fieldset>
  <ol>
    <li>
      <div class="error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez saisir un titre pour la structure</div>
      <label for="name">Nom</label>
      <input type="text" id="name" name="name" size="50" value="" />
    </li>
  </ol>
  </fieldset>
  <input id="form-structure-create-submit" name="form-structure-create-submit" class="button" type="submit" value="Enregistrer" />
</form>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
