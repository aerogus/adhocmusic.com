{include file="common/header.tpl"}

<div class="box" style="width: 215px; margin: 0 auto 20px">
  <header>
    <h1>Mot de passe oublié</h1>
  </header>
  <div>

{if !empty($sent_ok)}
<div class="infobulle success">Un nouveau mot de passe vous a été attribué. Veuillez consulter votre boite aux lettres.</div>
{/if}

{if !empty($sent_ko)}
<div class="infobulle error">Un nouveau mot de passe vous a été attribué mais l'envoi de l'email a échoué (c'est plutôt con !). Veuillez <a href="/contact">nous contacter</a>.</div>
  {if !empty($new_password)}
  <div class="infobulle success">{$new_password}</div>
  {/if}
{/if}

{if !empty($err_email_unknown)}
<div class="infobulle error">Compte introuvable</div>
{/if}

{if !empty($err_email_invalid)}
<div class="infobulle error">Erreur Email synatiquement incorrect.</div>
{/if}

{if !empty($form)}
<form id="form-lost-password" name="form-lost-password" method="post" action="/auth/lost-password">
  Veuillez entrer l'email que vous avez utilisé pour l'inscription, un nouveau mot de passe vous sera envoyé par email.</p>
  <label for="email">Email</label>
  <div class="infobulle error" id="error_email"{if empty($error_email)} style="display: none"{/if}>Vous devez renseigner votre email ou email invalide</div>
  <input name="email" id="email" type="text">
  <input id="form-lost-password-submit" name="form-lost-password-submit" class="button" type="submit" value="Ok">
</form>
{/if}

  </div>
</div>

{include file="common/footer.tpl"}
