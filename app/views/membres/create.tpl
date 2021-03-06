{include file="common/header.tpl"}

<div class="box" style="width: 320px; margin: 0 auto 20px">
  <header>
    <h1>Créer un compte</h1>
  </header>
  <div>

{if !empty($create)}

<div class="infobulle success">Bienvenue ! Votre compte AD’HOC a bien été créé. Consultez votre boite aux lettres électronique, elle vous confirme votre inscription et un mot de passe vous a été communiqué.<br>
Cliquez alors sur le cadenas en haut à droite pour vous identifier.</div>

{elseif !empty($error_generic)}

<div class="infobulle error">Erreur à l’inscription. Votre email est déjà présente, vous avez
déjà un compte. Si vous ne vous souvenez plus de votre mot de passe, <a href="/auth/lost-password">cliquez ici</a> pour le récupérer.</div>

  {if !empty($password)}
    <div class="infobulle info">Mot de passe: {$password}</div>
  {/if}

{else}

<form id="form-member-create" name="form-member-create" method="post" action="/membres/create">
  <div class="mbs">
    <label for="pseudo">Pseudo</label>
    <div id="error_pseudo_unavailable" class="infobulle error"{if empty($error_pseudo_unavailable)} style="display: none"{/if}>Ce pseudo est pris, veuillez en choisir un autre</div>
    <div class="infobulle error" id="error_pseudo"{if empty($error_pseudo)} style="display: none"{/if}>Vous devez saisir un pseudo entre 1 à 50 caractères</div>
    <input id="pseudo" name="pseudo" type="text" maxlength="50" value="{$data.pseudo|escape}" placeholder="Pseudo">
  </div>
  <div class="mbs">
    <label for="email">E-mail</label>
    <div id="error_email"{if empty($error_email)} style="display: none"{/if} class="infobulle error">Vous devez saisir votre e-mail</div>
    <div id="error_invalid_email" class="infobulle error"{if empty($error_invalid_email)} style="display: none"{/if}>Cet e-mail semble invalide</div>
    <div id="error_already_member" class="infobulle error"{if empty($error_already_member)} style="display: none"{/if}>Inscription impossible car un compte avec cet e-mail existe déjà. Vous avez <a href="/auth/lost-password">oublié votre mot de passe ?</a></div>
    <input id="email" name="email" type="email" maxlength="50" value="{$data.email|escape}" placeholder="E-mail">
  </div>
  <div class="mbs">
    <label for="mailing" class="visually-hidden">Newsletter</label>
    <span><input id="mailing" class="checkbox" name="mailing" type="checkbox"{if !empty($data.mailing)} checked="checked"{/if}> Je souhaite recevoir la newsletter</span>
  </div>
  <div>
    <input type="hidden" name="csrf" value="{$data.csrf}">
    <input type="hidden" name="text" value="{$data.text|escape}">
    <input id="form-membrer-create-submit" name="form-member-create-submit" class="btn btn--primary" style="width:100%" type="submit" value="Je crée mon compte">
  </div>
</form>

{/if}

  </div>
</div>

{include file="common/footer.tpl"}
