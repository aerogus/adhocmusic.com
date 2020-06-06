{include file="common/header.tpl"}

<div class="box" style="width: 320px; margin: 0 auto 20px">
  <header>
    <h1>Changer le mot de passe</h1>
  </header>
  <div>

{if !empty($change_ok)}<div class="infobulle success">Mot de passe changé avec succès</div>{/if}
{if !empty($change_ko)}<div class="infobulle error">Echec de la modification du mot de passe</div>{/if}

{if !empty($form)}
<form id="form-password-change" name="form-password-change" method="post" action="/auth/change-password">
  <div class="mbs">
    <div class="infobulle error" id="error_password_old"{if empty($error_password_old)} style="display: none"{/if}>Vous devez indiquer votre mot de passe actuel</div>
    <label for="password_old">Mot de passe actuel (*)</label>
    <input id="password_old" name="password_old" type="password" class="w100" maxlength="50">
  </div>
  <div class="mbs">
    <div class="infobulle error" id="error_password_new_1"{if empty($error_password_new_1)} style="display: none"{/if}>Vous devez indiquer un nouveau mot de passe</div>
    <label for="password_new_1">Nouveau mot de passe (*)</label>
    <input id="password_new_1" name="password_new_1" type="password" class="w100" maxlength="50">
  </div>
  <div class="mbs">
    <div class="infobulle error" id="error_password_new_2"{if empty($error_password_new_2)} style="display: none"{/if}>Vous devez indiquer un nouveau mot de passe</div>
    <div class="infobulle error" id="error_password_new_check"{if empty($error_password_new_check)} style="display: none"{/if}>Problème dans votre saisie</div>
    <label for="password_new_2">Vérification nouveau mot de passe (*)</label>
    <input id="password_new_2" name="password_new_2" type="password" class="w100" maxlength="50">
  </div>
  <div>
    <input id="form-password-change-submit" name="form-password-change-submit" type="submit" class="btn btn--primary w100" value="Modifier">
  </div>
</form>
{/if}

  </div>
</div>

{include file="common/footer.tpl"}
