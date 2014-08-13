{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Ajout Exposant"}

<form id="form-exposants-create" name="form-exposants-create" action="/adm/exposants/create" method="post">
  <fieldset style="width: 600px;">
    <ol>
      <li>
        <input type="text" id="name" name="name" style="width: 500px; float: right;" />
        <label for="name">Nom</label>
      </li>
      <li>
        <input type="text" id="email" name="email" style="width: 500px; float: right;" />
        <label for="email">Email</label>
      </li>
      <li>
        <input type="text" id="phone" name="phone" style="width: 500px; float: right;" />
        <label for="phone">Téléphone</label>
      </li>
      <li>
        <input type="text" id="site" name="site" style="width: 500px; float: right;" /> 
        <label for="site">Site</label>
      </li>
      <li>
        <input type="text" id="type" name="type" style="width: 500px; float: right;" /> 
        <label for="type">Type</label>
      </li>
      <li>
        <input type="text" id="citye" name="city" style="width: 500px; float: right;" /> 
        <label for="city">Ville</label>
      </li>
      <li>
        <input type="text" id="state" name="state" style="width: 500px; float: right;" /> 
        <label for="state">Etat</label>
      </li>
    </ol>
  </fieldset>
  <input id="form-exposants-create-submit" name="form-exposants-create-submit" class="button" type="submit" value="Enregistrer" />
</form>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
