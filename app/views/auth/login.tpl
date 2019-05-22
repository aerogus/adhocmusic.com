{include file="common/header.tpl"}

{if !empty($auth_failed)}
<div class="infobulle error">Authentification échouée</div>
{/if}

{if !empty($auth_required)}
<div class="infobulle warning">Vous devez posséder un compte AD'HOC pour accéder à cette page ou vous n'avez pas les droits suffisants</div>
{/if}

<div class="box" style="width: 215px; margin: 0 auto 20px">
  <header>
    <h1>Se connecter</h1>
  </header>
  <div>
    <form id="form-login" name="form-login" method="post" action="/auth/login">
      <div class="infobulle error" id="error_login-pseudo"{if empty($error_login_pseudo)} style="display: none"{/if}>Pseudo vide !</div>
      <input type="text" id="login-pseudo" name="pseudo" placeholder="Pseudo">
      <div class="infobulle error" id="error_login-password"{if empty($error_login_password)} style="display: none"{/if}>Password vide !</div>
      <input type="password" id="login-password" name="password" placeholder="Password">
      <input id="form-login-submit" name="form-login-submit" type="submit" value="Ok">
      {if !empty($referer)}<input type="hidden" id="login-referer" name="referer" value="{$referer|escape:'url'}">{/if}
      <ul>
        <li><a href="/auth/lost-password">mot de passe oublié</a></li>
        <li><a href="/membres/create">créer un compte</a></li>
      </ul>
    </form>
  </div>
</div>

{include file="common/footer.tpl"}
