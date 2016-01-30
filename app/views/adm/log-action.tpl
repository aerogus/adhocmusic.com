{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Log Action"}

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
    {*<th>Ip</th>*}
    <th>Host</th>
  </tr>
  {foreach from=$logs key=cpt item=log}
  <tr class="{if $cpt is odd}odd{else}even{/if}">
    <td>{$log.datetime|date_format:'%d/%m/%y %H:%M:%S'}</td>
    <td><a href="/membres/show/{$log.id_contact|escape}">{$log.pseudo|escape}</a></td>
    <td><strong>{$log.actionlib|escape}</strong>{if !empty($log.extra)} ({$log.extra|escape}){/if}</td>
    {*<td>{$log.ip|escape}</td>*}
    <td>{$log.host|escape}</td>
  </tr>
  {/foreach}
</table>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
