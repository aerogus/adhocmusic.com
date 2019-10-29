{include file="common/header.tpl"}

<div class="box" style="width: 320px; margin: 0 auto 20px">
  <header>
    <h2>Créer un compte</h2>
  </header>
  <div>

{if !empty($create)}

<div class="infobulle success">Votre compte AD'HOC a bien été créé ! Regardez votre boite aux lettres électronique, elle vous confirme votre inscription, et un mot de passe vous a été attribué.<br>
Vous pourrez le modifier le modifier dans votre "Tableau de bord" / "Mes Infos Persos" / "Modifier le mot de passe"</div>

<h3>Et Maintenant ?</h3>

<p>Vous avez un groupe de musique ? Vous voulez postuler pour nos concerts ? <a href="/groupes/create"> Inscrivez le</a></p>
<p>Venez découvrir des centaines de <a href="/media/">photos, vidéos et musiques</a> de concerts</p>
<p><a href="/contact">Contactez nous</a> pour toute question</p>

<p>Et encore bienvenue chez vous !</p>

{elseif !empty($error_generic)}

<div class="infobulle error">Erreur à l'inscription. Votre email est déjà présente, vous avez
déjà un compte. Si vous ne vous souvenez plus de votre mot de passe, <a href="/auth/lost-password">cliquez ici</a> pour le récupérer.</div>

  {if !empty($password)}
    <div class="infobulle info">Password: {$password}</div>
  {/if}

{else}

<form id="form-member-create" name="form-member-create" method="post" action="/membres/create">
  <ul>
    <li>
      <label for="email">Email</label>
      <div id="error_email"{if empty($error_email)} style="display: none"{/if} class="infobulle error">Vous devez saisir votre email</div>
      <div id="error_invalid_email" class="infobulle error"{if empty($error_invalid_email)} style="display: none"{/if}>Cet email semble invalide</div>
      <div id="error_already_member" class="infobulle error"{if empty($error_already_member)} style="display: none"{/if}>Inscription impossible car un compte avec cet email existe déjà. Vous avez <a href="/auth/lost-password">oublié votre mot de passe ?</a></div>
      <input id="email" name="email" type="email" size="35" value="{$data.email|escape}" placeholder="Email">
    </li>
    <li>
      <label for="pseudo">Pseudo</label>
      <div id="error_pseudo_unavailable" class="infobulle error"{if empty($error_pseudo_unavailable)} style="display: none"{/if}>Ce pseudo est pris, veuillez en choisir un autre</div>
      <div class="infobulle error" id="error_pseudo"{if empty($error_pseudo)} style="display: none"{/if}>Vous devez saisir un pseudo entre 2 à 16 caractères</div>
      <input id="pseudo" name="pseudo" type="text" size="35" value="{$data.pseudo|escape}" placeholder="Pseudo">
    </li>
    <li>
      <label for="mailing">Newsletter</label>
      <span><input id="mailing" class="switch" name="mailing" type="checkbox"{if !empty($data.mailing)} checked="checked"{/if}> Je souhaite recevoir la newsletter</span>
    </li>
  </ul>
  <input type="hidden" name="csrf" value="{$data.csrf}">
  <input type="hidden" name="text" value="{$data.text|escape}">
  <input id="form-membrer-create-submit" name="form-member-create-submit" class="button" type="submit" value="S'inscrire">
</form>

{/if}

  </div>
</div>

{include file="common/footer.tpl"}
