{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Stats Top Membres"}

<p>Statistique des membres AD'HOC qui ont joué le plus de fois en Spinolie</p>

<table class="tab">
  <tr>
    <th>Rang</th>
    <th>Musicien</th>
    <th>Nombre de concerts</th>
    <th>Date Concert / Groupe</th>
  </tr>
  {foreach from=$tops key=rank item=top}
  <tr class="{if $rank is even}even{else}odd{/if}">
    <td>{$rank}</td>
    <td><a href="/membres/show/{$top.id_contact}">{$top.first_name|escape} {$top.last_name|escape}</a></td>
    <td>{$top.nb}</td>
    <td>
    {foreach from=$top.events item=event}
    <a href="/events/show/{$event.id_event}">{$event.date_event|date_format:'%d/%m/%Y'}</a> (<a href="/groupes/show/{$event.id_groupe|escape}">{$event.nom_groupe|escape}</a>)<br />
    {/foreach}
    </td>
  </tr>
  {/foreach}
</table>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}