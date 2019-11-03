{include file="common/header.tpl"}

<div class="box">
  <header>
    <h2>Forums privés</h2>
  </header>
  <div class="reset">

<table class="table table--zebra">
  <thead>
    <tr>
      <th>Forum</th>
      <th>Dernier message</th>
      <th>Discussions</th>
      <th>Messages</th>
    </tr>
  </thead>
  <tbody>
  {foreach from=$forums key=cpt item=forum}
    <tr>
      <td><a href="/adm/forums/forum/{$forum.id_forum|escape}"><strong>{$forum.title|escape}</strong></a><br />{$forum.description|escape}</td>
      <td>Par <a href="/membres/{$forum.id_contact}">{$forum.pseudo}</a><br />le {$forum.date|date_format:'%d/%m/%Y à %H:%M'}</td>
      <td>{$forum.nb_threads|escape}</td>
      <td>{$forum.nb_messages|escape}</td>
    </tr>
  {/foreach}
  </tbody>
</table>

  </div>
</div>

{include file="common/footer.tpl"}
