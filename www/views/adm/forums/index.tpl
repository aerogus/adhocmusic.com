{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Forums privés"}

<table style="width: 100%">
  <thead>
    <tr>
      <th>Forum</th>
      <th>Dernier Message</th>
      <th>Discussions</th>
      <th>Messages</th>
    </tr>
  </thead>
  <tbody>
  {foreach from=$forums key=cpt item=forum}
    <tr class="{if $cpt is odd}odd{else}even{/if}">
      <td><a href="/adm/forums/forum/{$forum.id_forum|escape}"><strong>{$forum.title|escape}</strong></a><br />{$forum.description|escape}</td>
      <td>Par <a href="/membres/show/{$forum.id_contact}">{$forum.pseudo}</a><br />le {$forum.date|date_format:'%d/%m/%Y à %H:%M'}</td>
      <td>{$forum.nb_threads|escape}</td>
      <td>{$forum.nb_messages|escape}</td>
    </tr>
  {/foreach}
  </tbody>
</table>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}

