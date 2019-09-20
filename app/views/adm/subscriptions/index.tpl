{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Cotisations"}

<a href="/adm/subscriptions/create">Saisir une cotisation</a>

<table id="tab-subscriptions">
  <thead>
    <tr>
      <th>Date Cotisation</th>
      <th>Date Saisie</th>
      <th>Nom</th>
      <th>Prénom</th>
    </tr>
  </thead>
  <tbody>
    {foreach from=$subscriptions item=subscription}
    <tr class="{if $cpt is odd}odd{else}even{/if}">
      <td>{$subscription->getSubscribedAt()}</td>
      <td>{$subscription->getCreatedAt()}</td>
      <td>{$subscription->getFirstName()}</td>
      <td>{$subscription->getLastName()}</td>
    </tr>
    {/foreach}
  </tbody>
</table>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
