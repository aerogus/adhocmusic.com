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
  <section class="grid-4">
  {if $me->isInterne()}
  <div>Notifications</div>
  <div class="col-3 mbs">
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
  </div>
  {/if}
  <div>
    <label for="created_at">Date Inscription</label>
  </div>
  <div class="col-3 mbs">
    <span id="created_at">{$me->getCreatedAt()|date_format:"%d/%m/%Y %H:%M"}</span>
  </div>
  <div>
    <label for="modified_at">Date Modification</label>
  </div>
  <div class="col-3 mbs">
    <span id="modified_at">{$me->getModifiedAt()|date_format:"%d/%m/%Y %H:%M"}</span>
  </div>
  <div>
    <label for="visited_at">Dernière visite</label>
  </div>
  <div class="col-3 mbs">
    <span id="visited_at">{$me->getVisitedAt()|date_format:"%d/%m/%Y %H:%M"}</span>
  </div>
  <div>
    <label for="pseudo">Pseudo</label>
  </div>
  <div class="col-3 mbs">
    <strong>{$me->getPseudo()|escape}</strong>
  </div>
  <div>
    <label for="password">Mot de passe</label>
  </div>
  <div class="col-3 mbs">
    <a href="/auth/change-password" class="btn btn--primary">Modifier le mot de passe</a>
  </div>
  {if $me->isInterne()}
  <div>
    <label for="photo">Photo "corporate" (.jpg 100x100)</label>
  </div>
  <div class="col-3 mbs">
    <img src="{$me->getAvatarInterneUrl()}" alt=""><br>
    <input type="file" name="photo">
  </div>
  {/if}
  <div>
    <label for="avatar">Avatar public (.jpg 100x---)</label>
  </div>
  <div class="col-3 mbs">
    <img src="{$me->getAvatarUrl()}" alt=""><br>
    <input type="file" name="avatar">
  </div>
  <div>
    <label for="last_name">Nom</label>
  </div>
  <div class="col-3 mbs">
    <div class="infobulle error" id="error_last_name"{if empty($error_last_name)} style="display: none"{/if}>Vous devez renseigner votre nom</div>
    <input id="last_name" name="last_name" type="text" class="w100" maxlength="50" value="{$me->getLastName()|escape}">
  </div>
  <div>
    <label for="first_name">Prénom</label>
  </div>
  <div class="col-3 mbs">
    <div class="infobulle error" id="error_first_name"{if empty($error_first_name)} style="display: none"{/if}>Vous devez préciser votre prénom</div>
    <input id="first_name" name="first_name" type="text" class="w100" maxlength="50" value="{$me->getFirstName()|escape}">
  </div>
  <div>
    <label for="address">Adresse</label>
  </div>
  <div class="col-3 mbs">
    <input id="address" name="address" type="text" class="w100" maxlength="50" value="{$me->getAddress()|escape}">
  </div>
  <div>
    <label for="id_country">Pays (*)</label>
  </div>
  <div class="col-3 mbs">
    <div class="infobulle error" id="error_id_country"{if empty($error_id_country)} style="display: none"{/if}>Vous devez choisir un pays</div>
    <select id="id_country" name="id_country" class="w100">
      <option value="0">---</option>
    </select>
  </div>
  <div>
    <label for="id_region">Région (*)</label>
  </div>
  <div class="col-3 mbs">
    <div class="infobulle error" id="error_id_region"{if empty($error_id_region)} style="display: none"{/if}>Vous devez choisir une région</div>
    <select id="id_region" name="id_region" class="w100">
      <option value="0">---</option>
    </select>
  </div>
  <div>
    <label for="id_departement">Département (*)</label>
  </div>
  <div class="col-3 mbs">
    <div class="infobulle error" id="error_id_departement"{if empty($error_id_departement)} style="display: none"{/if}>Vous devez choisir un département</div>
    <select id="id_departement" name="id_departement" class="w100">
      <option value="0">---</option>
    </select>
  </div>
  <div>
    <label for="id_city">Ville (*)</label>
  </div>
  <div class="col-3 mbs">
    <div class="infobulle error" id="error_id_city"{if empty($error_id_city)} style="display: none"{/if}>Vous devez choisir une ville</div>
    <select id="id_city" name="id_city" class="w100">
      <option value="0">---</option>
    </select>
  </div>
  <div>
    <label for="tel">Téléphone</label>
  </div>
  <div class="col-3 mbs">
    <input id="tel" name="tel" type="text" class="w100" maxlength="50" value="{$me->getTel()|escape}" placeholder="+33 1 ..">
  </div>
  <div>
    <label for="port">Portable</label>
  </div>
  <div class="col-3 mbs">
    <input id="port" name="port" type="text" class="w100" maxlength="50" value="{$me->getPort()|escape}" placeholder="+33 6 ..">
  </div>
  <div>
    <label for="email">Email</label>
  </div>
  <div class="col-3 mbs">
    <div class="infobulle error" id="error_email"{if empty($error_email)} style="display: none"{/if}>Vous devez renseigner votre email</div>
    <input id="email" name="email" type="email" class="w100" maxlength="50" value="{$me->getEmail()|escape}">
  </div>
  <div>
    <label for="mailing">Newsletter</label>
  </div>
  <div class="col-3 mbs">
    <span><input id="mailing" class="checkbox" name="mailing" type="checkbox"{if $me->getMailing()} checked="checked"{/if}> oui, je veux recevoir la newsletter mensuelle</span>
  </div>
  <div>
    <label for="site">Site Internet</label>
  </div>
  <div class="col-3 mbs">
    <input id="site" name="site" type="text" class="w100" maxlength="50" value="{$me->getSite()}" placeholder="https://...">
  </div>
  <div>
    <label for="text">Présentation</label>
  </div>
  <div class="col-3 mbs">
    <textarea name="text" class="w100" rows="10">{$me->getText()|escape}</textarea>
  </div>
  <div></div>
  <div class="col-3">
    <input id="form-member-edit-submit" name="form-member-edit-submit" type="submit" class="btn btn--primary" value="Enregistrer">
  </div>
  </section>
</form>

  </div>
</div>

{include file="common/footer.tpl"}
