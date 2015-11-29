{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Mot de passe perdu"}

{if !empty($sent_ok)}
<div class="success">Un nouveau mot de passe vous a été attribué. Veuillez consulter votre boite aux lettres.</div>
{/if}

{if !empty($sent_ko)}
<div class="error">Un nouveau mot de passe vous a été attribué mais l'envoi de l'email a échoué (c'est plutôt con !). Veuillez appeler le webmaster.</div>
{/if}

{if !empty($err_email_unknown)}
<div class="error">Email non trouvé dans la liste des membres.</div>
{/if}

{if !empty($err_email_invalid)}
<div class="error">Erreur Email synatiquement incorrect.</div>
{/if}

<script>
$(function() {
  $("#form-lost-password").submit(function() {
    var valid = true;
    if($("#email").val() == "") {
      $("#email").prev(".error").fadeIn();
      valid = false;
    } else {
      $("#email").prev(".error").fadeOut();
    }
    if($("#email").val() != "") {
      if(validateEmail($("#email").val()) == 0) {
        $("#email").prev(".error").fadeIn();
        valid = false;
      } else {
        $("#email").prev(".error").fadeOut();
      }
    });
    return valid;
  });
});
</script>

{if !empty($form)}
<form id="form-lost-password" name="form-lost-password" method="post" action="/auth/lost-password">
  <p>Vous avez égaré votre mot de passe ?<br>
  Veuillez entrer l'adresse email que vous avez utilisé pour l'inscription, un nouveau mot de passe vous sera envoyé par email.</p>
  <label for="email">Email</label>
  <div class="error" id="error_email"{if empty($error_email)} style="display: none"{/if}>Vous devez renseigner votre email ou email invalide</div>
  <input name="email" id="email" type="text" size="40" maxlength="50">
  <input id="form-lost-password-submit" name="form-lost-password-submit" type="submit" value="Ok">
</form>
{/if}

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
