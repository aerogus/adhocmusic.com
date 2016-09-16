{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Mes Infos Persos"}

{if !empty($updated_ok)}
<p class="success">Enregistrement effectué</p>
{/if}

<form id="form-member-edit" name="form-member-edit" method="post" action="/membres/edit" enctype="multipart/form-data">
  <fieldset>
      {if !empty($fb_me)}
      <p>Votre compte AD'HOC est lié au profil Facebook suivant:</p>
      <p align="center">
        <img src="{$fb_me.picture}" alt="{$fb_me.first_name|escape} {$fb_me.last_name|escape}"><br>
        <strong>{$fb_me.first_name|escape} {$fb_me.last_name|escape}</strong>
      </p>
      <p><a href="/membres/fb-unlink">Délier ce profil Facebook de mon compte AD'HOC</a></p>
      {else}
      <p>Votre compte AD'HOC n'est lié à aucun profil Facebook.</p>
      <p><a href="/membres/fb-link">Lier mon compte AD'HOC à mon profil Facebook</a></p>
      {/if}
  </fieldset>
  {if $me->isInterne()}
  <fieldset>
    <legend>Inscription Forums Privés</legend>
    <p>Veuillez cocher les cases des forums dont vous voulez recevoir les notifications de nouveaux messages par email</p>
    <ol>
      <li>
        <input type="checkbox" name="forum[a]" id="forum[a]"{if !empty($forum['a'])} checked="checked"{/if}> Général
      </li>
      <li>
        <input type="checkbox" name="forum[b]" id="forum[b]"{if !empty($forum['b'])} checked="checked"{/if}> Bureau
      </li>
      <li>
        <input type="checkbox" name="forum[e]" id="forum[e]"{if !empty($forum['e'])} checked="checked"{/if}> Exposition
      </li>
      <li>
        <input type="checkbox" name="forum[s]" id="forum[s]"{if !empty($forum['s'])} checked="checked"{/if}> Site
      </li>
      <li>
        <input type="checkbox" name="forum[t]" id="forum[t]"{if !empty($forum['t'])} checked="checked"{/if}> Technique
      </li>
    </ol>
  </fieldset>
  {/if}
  <fieldset>
    <legend>Mes Infos</legend>
    <ol>
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
        <a href="/auth/change-password" style="float: right">Changer password</a>
        <label for="password">Password</label>
      </li>
      {if $me->isInterne()}
      <li>
        <span style="float: right">
          <img src="{$me->getAvatarInterne()}" alt=""><br>
          <input type="file" name="photo">
        </span>
        <label for="photo">Photo "corporate" (.jpg 100x100)</label>
      </li>
      {/if}
      <li>
        <span style="float: right">
          <img src="{$me->getAvatar()}" alt=""><br>
          <input type="file" name="avatar">
        </span>
        <label for="avatar">Avatar public (.jpg 100x---)</label>
      </li>
      <li>
        <div class="error" id="error_last_name"{if empty($error_last_name)} style="display: none"{/if}>Vous devez renseigner votre nom</div>
        <input id="last_name" name="last_name" type="text" size="40" maxlength="50" value="{$me->getLastName()|escape}" style="float: right">
        <label for="last_name">Nom</label>
      </li>
      <li>
        <div class="error" id="error_first_name"{if empty($error_first_name)} style="display: none"{/if}>Vous devez préciser votre prénom</div>
        <input id="first_name" name="first_name" type="text" size="40" maxlength="50" value="{$me->getFirstName()|escape}" style="float: right">
        <label for="first_name">Prénom</label>
      </li>
      <li>
        <input id="address" name="address" type="text" size="40" maxlength="50" value="{$me->getAddress()|escape}" style="float: right">
        <label for="address">Adresse</label>
      </li>

      {*
      <li>
        <input id="cp" name="cp" type="text" size="40" maxlength="50" value="{$me->getCp()|escape}" style="float: right">
        <label for="cp">Code Postal</label>
      </li>
      <li>
        <div class="error" id="error_city"{if empty($error_city)} style="display: none"{/if}>Vous devez renseigner votre ville</div>
        <input id="city" name="city" type="text" size="40" maxlength="50" value="{$me->getCity()|escape}" style="float: right">
        <label for="city">Ville</label>
      </li>
      <li>
        <div class="error" id="error_country"{if  empty($error_country)} style="display: none"{/if}>Vous devez renseigner votre pays</div>
        <input id="country" name="country" type="text" size="40" maxlength="50" value="{$me->getCountry()|escape}" style="float: right">
        <label for="country">Pays</label>
      </li>
      *}

      <li>
        <div class="error" id="error_id_country"{if empty($error_id_country)} style="display: none"{/if}>Vous devez choisir un pays</div>
        <select id="id_country" name="id_country" style="float: right;">
          <option value="0">---</option>
        </select>
        <label for="id_country">Pays (*)</label>
      </li>
      <li>
        <div class="error" id="error_id_region"{if empty($error_id_region)} style="display: none"{/if}>Vous devez choisir une région</div>
        <select id="id_region" name="id_region" style="float: right;">
          <option value="0">---</option>
        </select>
        <label for="id_region">Région (*)</label>
      </li>
      <li>
        <div class="error" id="error_id_departement"{if empty($error_id_departement)} style="display: none"{/if}>Vous devez choisir un département</div>
        <select id="id_departement" name="id_departement" style="float: right;">
          <option value="0">---</option>
        </select>
        <label for="id_departement">Département (*)</label>
      </li>
      <li>
        <div class="error" id="error_id_city"{if empty($error_id_city)} style="display: none"{/if}>Vous devez choisir une ville</div>
        <select id="id_city" name="id_city" style="float: right;">
          <option value="0">---</option>
        </select>
        <label for="id_city">Ville (*)</label>
      </li>
      <li>
        <input id="tel" name="tel" type="text" size="40" maxlength="50" value="{$me->getTel()|escape}" style="float: right">
        <label for="tel">Téléphone</label>
      </li>
      <li>
        <input id="port" name="port" type="text" size="40" maxlength="50" value="{$me->getPort()|escape}" style="float: right">
        <label for="port">Portable</label>
      </li>
      <li>
        <div class="error" id="error_email"{if empty($error_email)} style="display: none"{/if}>Vous devez renseigner votre email</div>
        <input id="email" name="email" type="email" size="40" maxlength="50" value="{$me->getEmail()|escape}" style="float: right">
        <label for="email">Email</label>
      </li>
      <li>
        <span style="float: right"><input id="mailing" name="mailing" type="checkbox"{if $me->getMailing()} checked="checked"{/if}> oui, je veux recevoir la newsletter mensuelle</span>
        <label for="mailing">Newsletter</label>
      </li>
      <li>
        <input id="site" name="site" type="text" size="40" maxlength="50" value="{$me->getSite()}" style="float: right">
        <label for="site">Site Internet</label>
      </li>
      <li>
        <textarea name="text" cols="49" rows="10" style="float: right">{$me->getText()|escape}</textarea>
        <label for="text">Présentation</label>
      </li>
    </ol>
  </fieldset>
  <input id="form-member-edit-submit" name="form-member-edit-submit" type="submit" class="button" value="Enregistrer">
</form>

{include file="common/boxend.tpl"}

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
