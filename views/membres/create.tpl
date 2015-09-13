{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Inscription"}

{if !empty($create)}

<div class="success">Votre compte AD'HOC a bien été créé ! Regardez votre boite aux lettres électronique, elle vous confirme votre inscription, et un mot de passe vous a été attribué.<br />
Vous pourrez le modifier le modifier dans votre "Tableau de bord" / "Mes Infos Persos" / "Modifier le mot de passe"</div>

<h3>Et Maintenant ?</h3>

<p>Vous avez un groupe de musique ? <a href="/groupes/create"> Inscrivez le</a></p>
<p>Vous gérer une salle de concert ? <a href="/lieux/create">Référencez la</a> dans notre annuaire ou bien <a href="/events/create">saisissez une date</a> dans notre agenda géolocalisé</p>
<p>Venez participer à notre <a href="/forums/forum/a">forum de discussion</a> ou bien <a href="/live">chattez avec nous en direct</a></p>
<p>Venez découvrir des centaines de <a href="/media/">photos, vidéos et musiques</a> de concerts</p>
<p>Découvrez les dizaines d'<a href="/articles/">articles sur la musique</a> (chronique, live report, pédagogie, actualité locale ...) écrits par nos bénévoles, et par vous !</p>
<p><a href="/contact">Contactez nous</a> pour toute question</p>

<p>Et encore bienvenue chez vous !</p>

{elseif !empty($error_generic)}

<div class="error">Erreur à l'inscription. Votre email est déjà présente, vous avez
déjà un compte. Si vous ne vous souvenez plus de votre mot de passe, <a href="/auth/lost-password">cliquez ici</a> pour le récupérer.</div>

{else}

<h3>Création d'un compte AD'HOC</h3>
<p>Le compte AD'HOC, dont l'inscription est totalement gratuite, donne accès à toute la zone membre du site.</p>
<strong>Vos Avantages :</strong>
<ul>
  <li>Annoncer des concerts dans l'agenda</li>
  <li>Communiquer entre membres par messagerie interne</li>
  <li>S'abonner aux alertes</li>
  <li>Faire partie d'une communauté de musiciens et d'amateurs de musique</li>
  <li>Inscrire et gérer sa fiche groupe</li>
</ul>

<hr />

<form style="width: 400px;" id="form-member-create" name="form-member-create" method="post" action="/membres/create">
  <ol>
    <li>
      <div class="warning" id="bubble_email" style="display: none;">Vous recevrez votre mot de passe à cette adresse</div>
      <div class="error" id="error_email"{if empty($error_email)} style="display: none"{/if}>Vous devez saisir un email valide</div>
      <div id="error_invalid_email" class="error"{if empty($error_invalid_email)} style="display: none"{/if}>Votre email est invalide</div>
      <div id="error_already_member" class="error"{if empty($error_already_member)} style="display: none"{/if}>Inscription impossible : votre email est déjà inscrit ! <a href="/auth/lost-password">Vous avez oublié votre mot de passe ?</a></div>
      <input id="email" name="email" type="email" size="35" value="{$data.email|escape}" style="float: right;" />
      <label for="email">Email</label>
    </li>
    <li>
      <div class="warning" id="bubble_pseudo" style="display: none;">Ce pseudo est nominatif, ce n'est pas le nom de votre groupe</div>
      <div id="error_pseudo_unavailable" class="error"{if empty($error_pseudo_unavailable)} style="display: none"{/if}>Pseudo déjà utilisé, veuillez en fournir un autre</div>
      <div class="error" id="error_pseudo"{if empty($error_pseudo)} style="display: none"{/if}>Vous devez saisir un pseudo de 5 à 10 caractères</div>
      <input id="pseudo" name="pseudo" type="text" size="35" value="{$data.pseudo|escape}" style="float: right;" />
      <label for="pseudo">Pseudo</label>
    </li>
    <li>
      <div class="error" id="error_last_name"{if empty($error_last_name)} style="display: none"{/if}>Vous devez saisir votre nom</div>
      <input id="last_name" name="last_name" type="text" size="35" value="{$data.last_name|escape}" style="float: right;" />
      <label for="last_name">Nom</label>
    </li>
    <li>
      <div class="error" id="error_first_name"{if empty($error_first_name)} style="display: none"{/if}>Vous devez saisir votre prénom</div>
      <input id="first_name" name="first_name" type="text" size="35" value="{$data.first_name|escape}" style="float: right;" />
      <label for="first_name">Prénom</label>
    </li>
    <li>
      <div class="error" id="error_id_country"{if empty($error_id_country)} style="display: none"{/if}>Vous devez préciser votre pays</div>
      <select id="id_country" name="id_country" style="float: right;">
        <option value="0">---</option>
        {foreach from=$countries key=id item=name}
        <option value="{$id}"{if $data.id_country == $id} selected="selected"{/if}>{$name.fr|escape}</option>
        {/foreach}
      </select>
      <label for="id_country">Pays</label>
    </li>
    <li>
      <div class="error" id="error_id_region"{if empty($error_id_region)} style="display: none"{/if}>Vous devez saisir votre région</div>
      <select id="id_region" name="id_region" style="float: right;">
        <option value="0"></option>
      </select>
      <label for="id_region">Région</label>
    </li>
    <li>
      <div class="error" id="error_id_departement"{if empty($error_id_departement)} style="display: none"{/if}>Vous devez saisir votre département</div>
      <select id="id_departement" name="id_departement" style="float: right;">
        <option value="0"></option>
      </select>
      <label for="id_departement">Département</label>
    </li>
    <li>
      <div class="error" id="error_id_city"{if empty($error_id_city)} style="display: none"{/if}>Vous devez choisir votre ville</div>
      <select id="id_city" name="id_city" style="float: right;">
        <option value="0"></option>
      </select>
      <label for="id_city">Ville</label>
    </li>
    <li>
      <div class="error" id="error_mailing"{if empty($error_mailing)} style="display: none"{/if}>Vous devez cocher la case pour recevoir la newsletter</div>
      <span style="float: right;"><input id="mailing" name="mailing" type="checkbox"{if !empty($data.mailing)} checked="checked"{/if} /> oui, je veux bien recevoir la lettre d'information (4 à 5 par an).</span>
      <label for="mailing">Newsletter</label>
    </li>
  </ol>
  <input type="hidden" name="csrf" value="{$data.csrf}" />
  <input type="hidden" name="text" value="{$data.text|escape}" />
  <input id="form-membrer-create-submit" name="form-member-create-submit" class="button" type="submit" value="S'Inscrire" />
</form>

{/if}

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
