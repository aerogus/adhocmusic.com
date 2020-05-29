{include file="common/header.tpl"}

<div class="grid-2 has-gutter">

<div class="box" style="width: 320px; margin: 0 auto 20px">
  <header>
    <h1>Se connecter</h1>
  </header>
  <div>
    <form id="form-login" name="form-login" method="post" action="/auth/login">
      <ul>
        <li>
          <label for="login-pseudo">Pseudo</label>
          <div class="infobulle error" id="error_login-pseudo"{if empty($error_login_pseudo)} style="display: none"{/if}>Pseudo vide !</div>
          <input type="text" id="login-pseudo" name="pseudo" placeholder="Pseudo" style="width:100%">
        </li>
        <li>
          <label for="login-password">Mot de passe</label>
          <div class="infobulle error" id="error_login-password"{if empty($error_login_password)} style="display: none"{/if}>Mot de passe vide !</div>
          <input type="password" id="login-password" name="password" placeholder="Mot de passe" style="width:100%">
        </li>
      </ul>
      {if !empty($referer)}<input type="hidden" id="login-referer" name="referer" value="{$referer|escape:'url'}">{/if}
      <ul class="txtrght sublinks">
        <li><a href="/auth/lost-password">mot de passe oublié</a></li>
      </ul>
      <input id="form-login-submit" name="form-login-submit" type="submit" value="Je me connecte" class="btn btn--primary w100">
    </form>
  </div>
</div>

<div class="box" style="width: 320px; margin: 0 auto 20px">
  <header>
    <h1>Créer un compte</h1>
  </header>
  <div>
    <form id="form-member-create" name="form-member-create" method="post" action="/membres/create">
    <ul>
        <li>
        <label for="pseudo">Pseudo</label>
        <div id="error_pseudo_unavailable" class="infobulle error"{if empty($error_pseudo_unavailable)} style="display: none"{/if}>Ce pseudo est pris, veuillez en choisir un autre</div>
        <div class="infobulle error" id="error_pseudo"{if empty($error_pseudo)} style="display: none"{/if}>Vous devez saisir un pseudo entre 2 à 16 caractères</div>
        <input id="pseudo" name="pseudo" type="text" size="35" value="{$data.pseudo|escape}" placeholder="Pseudo">
        </li>
        <li>
        <label for="email">E-mail</label>
        <div id="error_email"{if empty($error_email)} style="display: none"{/if} class="infobulle error">Vous devez saisir votre e-mail</div>
        <div id="error_invalid_email" class="infobulle error"{if empty($error_invalid_email)} style="display: none"{/if}>Cet e-mail semble invalide</div>
        <div id="error_already_member" class="infobulle error"{if empty($error_already_member)} style="display: none"{/if}>Inscription impossible car un compte avec cet e-mail existe déjà. Vous avez <a href="/auth/lost-password">oublié votre mot de passe ?</a></div>
        <input id="email" name="email" type="email" size="35" value="{$data.email|escape}" placeholder="E-mail">
        </li>
        <li>
        <label for="mailing">Newsletter</label>
        <span><input id="mailing" class="switch" name="mailing" type="checkbox"{if !empty($data.mailing)} checked="checked"{/if}> Je souhaite recevoir la newsletter</span>
        </li>
    </ul>
    <input type="hidden" name="csrf" value="{$data.csrf}">
    <input type="hidden" name="text" value="{$data.text|escape}">
    <input id="form-membrer-create-submit" name="form-member-create-submit" class="btn btn--primary w100" type="submit" value="Je crée mon compte">
    </form>
  </div>
</div>

</div>

{include file="common/footer.tpl"}
