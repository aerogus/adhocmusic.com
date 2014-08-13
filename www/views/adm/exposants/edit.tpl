{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Edition Exposant"}

<form id="form-exposants-edit" name="form-exposants-edit" action="/adm/exposants/edit" method="post">
  <fieldset style="width: 600px;">
    <ol>
      <li>
        <span style="float: right">{$exposant->getCreatedOn()|date_format:'%d/%m/%Y %H:%M:%S'}</span>
        <label for="created_on">Crée le :</label>
      </li>
      <li>
        <span style="float: right">{$exposant->getModifiedOn()|date_format:'%d/%m/%Y %H:%M:%S'}</span>
        <label for="modified_on">Modifié le :</label>
      </li>
      <li>
        <input type="text" id="name" name="name" value="{$exposant->getName()|escape}" style="width: 500px; float: right;" />
        <label for="name">Nom</label>
      </li>
      <li>
        <input type="text" id="email" name="email" value="{$exposant->getEmail()|escape}" style="width: 500px; float: right;" />
        <label for="email">Email</label>
      </li>
      <li>
        <input type="text" id="phone" name="phone" value="{$exposant->getPhone()|escape}" style="width: 500px; float: right;" />
        <label for="phone">Téléphone</label>
      </li>
      <li>
        <input type="text" id="site" name="site" value="{$exposant->getSite()|escape}" style="width: 500px; float: right;" />
        <label for="site">Site</label>
      </li>
      <li>
        <input type="text" id="type" name="type" value="{$exposant->getType()|escape}" style="width: 500px; float: right;" />
        <label for="type">Type</label>
      </li>
      <li>
        <input type="text" id="city" name="city" value="{$exposant->getCity()|escape}" style="width: 500px; float: right;" />
        <label for="city">Ville</label>
      </li>
      <li>
        <input type="text" id="state" name="state" value="{$exposant->getState()|escape}" style="width: 500px; float: right;" />
        <label for="state">Etat</label>
      </li>
    </ol>
  <input id="form-exposants-edit-submit" name="form-exposants-edit-submit" class="button" type="submit" value="Enregistrer" />
  <input type="hidden" id="id" name="id" value="{$exposant->getId()|escape}" />
</form>

<p><a href="/adm/exposants/delete/{$exposant->getId()|escape}">Effacer cet exposant</a></p>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
