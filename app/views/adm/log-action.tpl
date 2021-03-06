{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Log Action</h1>
  </header>
  <div>

<form method="get" action="/adm/log-action">
  <label for="action">Filtrer un événement</label>
  <select id="action" name="action">
    <option value="0">Tous</option>
    {foreach from=$actions key=action_id item=action_lib}
    <option value="{$action_id|escape}">{$action_lib|escape}</option>
    {/foreach}
  </select>
  <input type="submit" value="OK">
</form>

<table>
  <tr>
    <th>Date</th>
    <th>Membre</th>
    <th>Action</th>
    <th>Host</th>
  </tr>
  {foreach from=$logs key=cpt item=log}
  <tr>
    <td>{$log.datetime|date_format:'%d/%m/%y %H:%M:%S'}</td>
    <td><a href="/membres/show/{$log.id_contact|escape}">{$log.pseudo|escape}</a></td>
    <td><strong>{$log.actionlib|escape}</strong>{if !empty($log.extra)} ({$log.extra|escape}){/if}</td>
    <td>{$log.host|escape}</td>
  </tr>
  {/foreach}
</table>

  </div>
</div>

{include file="common/footer.tpl"}
