{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Agenda"}

<a href="/events/create" class="button">Annoncer une date</a>

{if !empty($create)}<p class="success">Evénement ajouté</p>{/if}
{if !empty($edit)}<p class="success">Evénement modifié</p>{/if}
{if !empty($delete)}<p class="success">Evénement supprimé</p>{/if}

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

{foreach from=$events item=event}
<table cellpadding="2" width="100%">
<tr background="#565656">
  <td width="30%"><strong>{$event->getDate()|date_format:"%d/%m/%Y à %H:%M"}</strong></td>
  <td width="70%"><a href="{$event->getUrl()|escape}"><strong>{$event->getName()|escape}</strong></a></td>
</tr>
<tr>
  <td width="30%">
  <p>Evénement proposé par <a href="{$event->getContactUrl()|escape}"><strong>{$event->getContactPseudo()|escape}</strong></a></p>
  <p>Groupes AD'HOC :</p>
  <ul>
    {foreach from=$event->getGroupes(true) item=groupe}
    <li><a href="{$groupe->getUrl()}"><strong>{$groupe->getName()|escape}</strong></a> ({$groupe->getStyle()|escape})</li>
    {/foreach}
  </ul>
  <p>Organisateur :</p>
  {*
  <ul>
    {foreach from=$event->getStructures() item=structure}
    <li><img src="{$structure->getPicto()}" alt="" title="{$structure->getName()}" /><strong>{$structure->getName()|escape}</strong></li>
    {/foreach}
  </ul>
  *}
  </td>
  <td width="70%">
  <p align="justify">
  <a href="{$event->getUrl()}"><img src="/dynimg/event/{$event->getId()}/100/100/666666/0/0.jpg" align="right" alt="{$event->getName()|escape}" /></a>
  </p>
  <p>
  Entrée : <strong>{$event->getPrice()|escape}</strong><br />
  {*
  Lieu : <a href="/lieux/show/{$event->getIdLieu()}" title="Voir la fiche lieu"><strong>{$lieu->getName()|escape}</strong></a> <a href="/lieux/show/{$event->getIdLieu()}" title="Visualiser ce lieu sur une carte"><img src="{#STATIC_URL#}/img/icones/map.png" alt="" /></a> ({$lieu->getIdDepartement()} - {$lieu->getCity()})<br />
 *}
  <a href="{$event->getUrl()}">Fiche complète</a><br />
  </p>
  </td>
</tr>
</table>
{/foreach}

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
