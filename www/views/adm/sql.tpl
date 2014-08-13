{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Requête SQL"}

<div class="warning">SELECT, DESCRIBE, SHOW queries only</div>

<form id="form-sql" name="form-sql" method="post" action="/adm/sql">
  <textarea id="q" name="q" style="width: 500px; height: 100px;">{$q|escape}</textarea>
  <input id="form-sql-submit" name="form-sql-submit" type="submit" value="OK" />
</form>

{if !empty($fields) && !empty($table)}

<hr />

<table>
  <thead>
    <tr>
      {foreach from=$fields item=field}
      <th>{$field|escape}</th>
      {/foreach}
    </tr>
  </thead>
  <tbody>
    {foreach from=$table item=row}
    <tr>
      {foreach from=$row item=field}
      <td>{$field|escape}</td>
      {/foreach}
    </tr>
    {/foreach}
  </tbody>
</table>

{/if}

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
