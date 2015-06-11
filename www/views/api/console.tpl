<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Console API REST AD'HOC</title>
</head>

<body>

<div id="conteneur">

<h3>Console de debug de l'API REST AD'HOC</h3>

<style>
#form-console {
    width: 400px;
}
#form-console li {
    height: 20px;
    padding: 5px;
    margin: 3px;
    background-color: #ececec;
    list-style: none;
}
#form-console input, #form-console select {
    float: right;
    width: 90px;
}
</style>

<form id="form-console" name="form-console" action="/api/console" method="post">
  <ul>
    <li>
      <label for="action">action</label>
      <select id="action" name="action">
      {foreach from=$actions item=_action}
        <option value="{$_action}" {if $action == $_action} selected="selected"{/if}>{$_action}</option>
      {/foreach}
      </select>
    </li>
   <li>
      <label for="format">format</label>
      <select id="format" name="format">
      {foreach from=$formats item=_format}
        <option value="{$_format}" {if $format == $_format} selected="selected"{/if}>{$_format}</option>
      {/foreach}
      </select>
    </li>
    <li>
      <label for="groupe">groupe (n°)</label>
      <input type="text" name="groupe" id="groupe" value="{$groupe}">
    </li>
    <li>
      <label for="event">event (n°)</label>
      <input type="text" name="event" id="event" value="{$event}">
    </li>
    <li>
      <label for="datdeb">datdeb (yyyy-mm-dd)</label>
      <input type="text" name="datdeb" id="datdeb" value="{$datdeb}">
    </li>
    <li>
      <label for="datfin">datfin (yyyy-mm-dd)</label>
      <input type="text" name="datfin" id="datfin" value="{$datfin}">
    </li>
    <li>
      <label for="lieu">lieu (n°)</label>
      <input type="text" name="lieu" id="lieu" value="{$lieu}">
    </li>
    <li>
      <label for="contact">membre (n°)</label>
      <input type="text" name="contact" id="contact" value="{$contact}">
    </li>
    <li>
      <label for="sort">sort (id, created_on)</label>
      <input type="text" name="sort" id="sort" value="{$sort}">
    </li>
    <li>
      <label for="sens">sens (ASC|DESC)</label>
      <input type="text" name="sens" id="sens" value="{$sens}">
    </li>
    <li>
      <label for="debut">debut (num, utile pour pagination)</label>
      <input type="text" name="debut" id="debut" value="{$debut}">
    </li>
    <li>
      <label for="limit">limit (0 = no limit)</label>
      <input type="text" name="limit" id="limit" value="{$limit}">
    </li>
    <li>
      <input id="form-console-submit" name="form-console-submit" type="submit" value="GO">
    </li>
  </ul>
</form>

{if !empty($resp)}
<pre>
{$resp|@var_dump}
</pre>
{/if}

<p>En cas de difficultés, n'hésitez pas à <a href="http://www.adhocmusic.com/contact">prendre contact avec nous</a></p>

</div>

</body>

</html>
