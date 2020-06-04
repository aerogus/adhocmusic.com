{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Liaison Membre / Groupe</h1>
  </header>
  <div>

<form id="form-appartient-a" name="form-appartient-a" method="post" action="/adm/appartient-a">
  <table align="center">
    <tr>
      <td>n° du membre :</td>
      <td><input type="text" name="membre" size="10" value="{$id_contact|escape}"></td>
    </tr>
    <tr>
      <td>n° du groupe :</td>
      <td><input type="text" name="groupe" size="10" value="{$id_groupe|escape}"></td>
    </tr>
    <tr>
      <td>Fonction :</td>
      <td><select name="type">
      {foreach from=$types item=type}
      <option value="{$type->getId()|escape}">{$type->getName()|escape}</option>
      {/foreach}
      </select></td>
    </tr>
    <tr>
      <td><input type="hidden" name="confirm" value="1"></td>
      <td><input id="form-appartient-a-submit" name="form-appartient-a-submit" type="submit" value="{$action_lib|escape}"></td>
    </tr>
  </table>
  <input type="hidden" name="action" value="{$action}">
  <input type="hidden" name="from" value="{$from}">
</form>

  </div>
</div>

{include file="common/footer.tpl"}
