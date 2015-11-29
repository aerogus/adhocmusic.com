{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Editer le password"}

{if !empty($change_ok)}<div class="success">Password changé avec succès</div>{/if}
{if !empty($change_ko)}<div class="error">Echec de la modification du mot de passe</div>{/if}

{if !empty($form)}
<form id="form-password-change" name="form-password-change" method="post" action="/auth/change-password">
  <fieldset>
    <ol>
      <li>
        <div class="error" id="error_password_old"{if empty($error_password_old)} style="display: none"{/if}>Vous devez indiquer votre mot de passe actuel</div>
        <input id="password_old" name="password_old" type="password" size="30" maxlength="50" style="float: right">
        <label for="password_old">Password Actuel</label>
      </li>
      <li>
        <div class="error" id="error_password_new_1"{if empty($error_password_new_1)} style="display: none"{/if}>Vous devez indiquer un nouveau mot de passe</div>
        <input id="password_new_1" name="password_new_1" type="password" size="30" maxlength="50" style="float: right">
        <label for="password_new_1">Nouveau Password</label>
      </li>
      <li>
        <div class="error" id="error_password_new_2"{if empty($error_password_new_2)} style="display: none"{/if}>Vous devez indiquer un nouveau mot de passe</div>
        <div class="error" id="error_password_new_check"{if empty($error_password_new_check)} style="display: none"{/if}>Problème dans votre saisie</div>
        <input id="password_new_2" name="password_new_2" type="password" size="30" maxlength="50" style="float: right">
        <label for="password_new_2">Nouveau Password (vérification)</label>
      </li>
    </ol>
    <input id="form-password-change-submit" name="form-password-change-submit" type="submit" class="button" value="Modifier">
  </fieldset>
</form>
{/if}

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
