{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Stats Top Groupes"}

<p>Statistique des groupes AD'HOC qui ont joué le plus de fois en Spinolie</p>

<table class="tab">
  <tr>
    <th>Rang</th>
    <th>Groupe</th>
    <th>Nombre de Concerts</th>
    <th>Date de Concerts</th>
  </tr>
  {foreach from=$tops key=rank item=top}
  <tr class="{if $rank is even}even{else}odd{/if}">
    <td>{$rank}</td>
    <td><a href="/groupes/show/{$top.id_groupe}">{$top.nom_groupe|escape}</a></td>
    <td>{$top.nb}</td>
    <td>
    {foreach from=$top.events item=event}
    <a href="/events/show/{$event.id|escape}">{$event.date|date_format:'%d/%m/%Y'} - {$event.name|escape}</a><br />
    {/foreach}
    </td>
  </tr>
  {/foreach}
</table>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
