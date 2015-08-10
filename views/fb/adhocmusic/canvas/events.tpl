{include file="fb/adhocmusic/canvas/common/header.tpl"}

{include file="fb/adhocmusic/canvas/common/boxstart.tpl" title="L'Agenda Concert AD'HOC du département 91"}
<table bgcolor="#999999" cellspacing="1">
  <tr>
    <th>Date</th>
    <th>Titre</th>
    <th>Flyer</th>
  </tr>
{foreach from=$evts item=evt}
  <tr>
    <td bgcolor="#cccccc">{$evt.date|date_format:"%d/%m/%Y à %H:%M"}</td>
    <td bgcolor="#cccccc"><a href="event/{$evt.id|escape}.html">{$evt.name|escape}</a></td>
    <td bgcolor="#cccccc">{$evt.flyer}</td>
  </tr>
{/foreach}
</table>
{include file="fb/adhocmusic/canvas/common/boxend.tpl"}

{include file="fb/adhocmusic/canvas/common/footer.tpl"}
