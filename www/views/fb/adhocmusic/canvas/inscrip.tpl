{include file="fb/adhocmusic/canvas/common/header.tpl"}

<p>Création d'un compte AD'HOC</p>

{if !empty($error_params)}<p>Erreur : Paramètres incorrects pseudo ou email</p>{/if}
{if !empty($error_already_account)}<p>Vous avez déjà un compte AD'HOC, n°{$error_already_account}</p>{/if}
{if !empty($error_pseudo_unavailable)}<p>Erreur : Pseudo déjà utilisé, veuillez en fournir un autre</p>{/if}
{if !empty($error_email_found)}<p>Erreur : L'email est déjà présente. Vous avez déjà un compte AD'HOC ?</p>{/if}

{if !empty($inscrip_ok)}
<p>La création de votre compte AD'HOC est effectuée. Votre boite aux lettres vous confirme l'inscription, et vous a généré un mot de passe.</p>
<p>Vous pourrez modifier ce mot de passe sur le site http://www.adhocmusic.com dans la "Zone Membre", rubrique "Mon Compte".</p>
{/if}

<style>
label {
    display: block;
}
</style>

<fieldset>
  <legend>Création d'un compte AD'HOC</legend>
  <form method="post">
    <p>Note: vous devez accepter les emails pour recevoir votre password !</p>
    <label for="name">Nom</label>
    <input type="text" id="name" name="name" value="{$info.last_name|escape}" readonly="readonly" />
    <label for="first_name">Prénom</label>
    <input type="text" id="first_name" name="first_name" value="{$info.first_name|escape}" readonly="readonly" />
    <label for="pseudo">Pseudo</label>
    <input type="text" id="pseudo" name="pseudo" value="" />
    <label for="email">Email</label>
    <input type="text" id="email" name="email" value="" />
    <input type="submit" value="Ok" />
    <input type="hidden" name="promptpermission" value="email" />
  </form>
</fieldset>
        
{include file="fb/adhocmusic/canvas/common/footer.tpl"}
