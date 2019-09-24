{include file="common/header.tpl"}

<div class="box">
  <header>
    <h2>Mes Infos Persos</h2>
  </header>
  <div>

{if !empty($updated_ok)}
<p class="infobulle success">Enregistrement effectué</p>
{/if}

<form id="form-member-edit" name="form-member-edit" method="post" action="/membres/edit" enctype="multipart/form-data">
  {if $me->isInterne()}
  <fieldset>
    <legend>Inscription Forums Privés</legend>
    <p>Veuillez cocher les cases des forums dont vous voulez recevoir les notifications de nouveaux messages par email</p>
    <ul>
      <li>
        <input type="checkbox" class="switch" name="forum[a]" id="forum[a]"{if !empty($forum['a'])} checked="checked"{/if}> Général
      </li>
      <li>
        <input type="checkbox" class="switch" name="forum[b]" id="forum[b]"{if !empty($forum['b'])} checked="checked"{/if}> Bureau
      </li>
      <li>
        <input type="checkbox" class="switch" name="forum[e]" id="forum[e]"{if !empty($forum['e'])} checked="checked"{/if}> Exposition
      </li>
      <li>
        <input type="checkbox" class="switch" name="forum[s]" id="forum[s]"{if !empty($forum['s'])} checked="checked"{/if}> Site
      </li>
      <li>
        <input type="checkbox" class="switch" name="forum[t]" id="forum[t]"{if !empty($forum['t'])} checked="checked"{/if}> Technique
      </li>
    </ul>
  </fieldset>
  {/if}
  <fieldset>
    <legend>Mes Infos</legend>
    <ul>
      <li>
        <span id="created_on" style="float: right">{$me->getCreatedOn()|date_format:"%d/%m/%Y %H:%M"}</span>
        <label for="created_on">Date Inscription</label>
      </li>
      <li>
        <span id="modified_on" style="float: right">{$me->getModifiedOn()|date_format:"%d/%m/%Y %H:%M"}</span>
        <label for="modified_on">Date Modification</label>
      </li>
      <li>
        <span id="visited_on" style="float: right">{$me->getVisitedOn()|date_format:"%d/%m/%Y %H:%M"}</span>
        <label for="visited_on">Dernière visite</label>
      </li>
      <li>
        <strong style="float: right">{$me->getPseudo()|escape}</strong>
        <label for="pseudo">Pseudo</label>
      </li>
      <li>
        <a href="/auth/change-password" style="float: right">Modifier le mot de passe</a>
        <label for="password">Mot de passe</label>
      </li>
      {if $me->isInterne()}
      <li>
        <label for="photo">Photo "corporate" (.jpg 100x100)</label>
        <img src="{$me->getAvatarInterne()}" alt=""><br>
        <input type="file" name="photo">
      </li>
      {/if}
      <li>
        <label for="avatar">Avatar public (.jpg 100x---)</label>
        <img src="{$me->getAvatar()}" alt=""><br>
        <input type="file" name="avatar">
      </li>
      <li>
        <label for="last_name">Nom</label>
        <div class="infobulle error" id="error_last_name"{if empty($error_last_name)} style="display: none"{/if}>Vous devez renseigner votre nom</div>
        <input id="last_name" name="last_name" type="text" size="40" maxlength="50" value="{$me->getLastName()|escape}">
      </li>
      <li>
        <label for="first_name">Prénom</label>
        <div class="infobulle error" id="error_first_name"{if empty($error_first_name)} style="display: none"{/if}>Vous devez préciser votre prénom</div>
        <input id="first_name" name="first_name" type="text" size="40" maxlength="50" value="{$me->getFirstName()|escape}">
      </li>
      <li>
        <label for="address">Adresse</label>
        <input id="address" name="address" type="text" size="40" maxlength="50" value="{$me->getAddress()|escape}">
      </li>
      <li>
        <label for="id_country">Pays (*)</label>
        <div class="infobulle error" id="error_id_country"{if empty($error_id_country)} style="display: none"{/if}>Vous devez choisir un pays</div>
        <select id="id_country" name="id_country">
          <option value="0">---</option>
        </select>
      </li>
      <li>
        <label for="id_region">Région (*)</label>
        <div class="infobulle error" id="error_id_region"{if empty($error_id_region)} style="display: none"{/if}>Vous devez choisir une région</div>
        <select id="id_region" name="id_region">
          <option value="0">---</option>
        </select>
      </li>
      <li>
        <label for="id_departement">Département (*)</label>
        <div class="infobulle error" id="error_id_departement"{if empty($error_id_departement)} style="display: none"{/if}>Vous devez choisir un département</div>
        <select id="id_departement" name="id_departement">
          <option value="0">---</option>
        </select>
      </li>
      <li>
        <label for="id_city">Ville (*)</label>
        <div class="infobulle error" id="error_id_city"{if empty($error_id_city)} style="display: none"{/if}>Vous devez choisir une ville</div>
        <select id="id_city" name="id_city">
          <option value="0">---</option>
        </select>
      </li>
      <li>
        <label for="tel">Téléphone</label>
        <input id="tel" name="tel" type="text" size="40" maxlength="50" value="{$me->getTel()|escape}">
      </li>
      <li>
        <label for="port">Portable</label>
        <input id="port" name="port" type="text" size="40" maxlength="50" value="{$me->getPort()|escape}">
      </li>
      <li>
        <label for="email">Email</label>
        <div class="infobulle error" id="error_email"{if empty($error_email)} style="display: none"{/if}>Vous devez renseigner votre email</div>
        <input id="email" name="email" type="email" size="40" maxlength="50" value="{$me->getEmail()|escape}">
      </li>
      <li>
        <label for="mailing">Newsletter</label>
        <span><input id="mailing" class="switch" name="mailing" type="checkbox"{if $me->getMailing()} checked="checked"{/if}> oui, je veux recevoir la newsletter mensuelle</span>
      </li>
      <li>
        <label for="site">Site Internet</label>
        <input id="site" name="site" type="text" size="40" maxlength="50" value="{$me->getSite()}">
      </li>
      <li>
        <label for="text">Présentation</label>
        <textarea name="text" cols="49" rows="10">{$me->getText()|escape}</textarea>
      </li>
    </ul>
  </fieldset>
  <input id="form-member-edit-submit" name="form-member-edit-submit" type="submit" class="button" value="Enregistrer">
</form>

  </div>
</div>

<script>
var lieu = {
    id: 0,
    id_country: '{$me->getIdCountry()}',
    id_region: '{$me->getIdRegion()}',
    id_departement: '{$me->getIdDepartement()}',
    id_city: '{$me->getIdCity()}'
};
</script>

{include file="common/footer.tpl"}
