{include file="common/header.tpl"}

{if empty($is_auth)}

<script>
$(function () {
  $("#form-login").submit(function () {
    var valid = true;
    if ($("#pseudo").val() === "") {
      $("#pseudo").prev(".error").fadeIn();
      valid = false;
    } else {
      $("#pseudo").prev(".error").fadeOut();
    }
    if ($("#password").val() === "") {
      $("#password").prev(".error").fadeIn();
      valid = false;
    } else {
      $("#password").prev(".error").fadeOut();
    }
    return valid;
  });
});
</script>

<fieldset style="width: 50%">
  <legend>Vous possédez déjà un compte AD'HOC ? Identifiez vous :</legend>
  {include file="common/boxstart.tpl" boxtitle="Zone Membre" width="200px"}
  <form id="form-login" name="form-login" method="post" action="/auth/login">
    <input size="18" type="text" id="pseudo" name="pseudo" placeholder="Pseudo">
    <input size="18" type="password" id="password" name="password" placeholder="Password">
    <input id="form-login-submit" name="form-login-submit" type="submit" value="Ok">
    <input type="hidden" name="referer" value="{$referer|escape:'url'}">
    <input type="hidden" name="facebook_uid" value="{$facebook_uid|escape}">
  </form>
  <ul>
    <li><a href="/auth/lost-password">mot de passe oublié</a></li>
  </ul>
  {include file="common/boxend.tpl"}
</fieldset>

<fieldset style="width: 50%">
  <legend>Vous ne possédez pas de compte AD'HOC ?</legend>
  <a class="button" href="/membres/create">Créer un compte AD'HOC</a>
</fieldset>

{/if}

{include file="common/footer.tpl"}
