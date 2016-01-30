<script>
$(function() {
    $("#form-message-write").submit(function () {
        var valid = true;
        if($("#text").val() === "") {
            $("#text").prev(".error").fadeIn();
            valid = false;
        } else {
            $("#text").prev(".error").fadeOut();
        }
    });
});
</script>

<form id="form-message-write" name="form-message-write" action="/messagerie/write" method="post">
  <ul>
    <li>
      <div class="error" id="error_text"{if empty($error_text)} style="display: none"{/if}>Vous devez écrire quelque chose !</div>
      <label for="text">Ecrire à <a href="/membres/show/{$id_to|escape}">{$pseudo_to|escape}</a></label>
      <textarea id="text" name="text" cols="50" rows="10"></textarea>
    </li>
    <li>
      <input type="hidden" id="to" name="to" value="{$id_to|escape}">
      <input id="form-message-write-submit" name="form-message-write-submit" type="submit" value="Envoyer">
    </li>
  </ul>
</form>
