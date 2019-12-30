{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Cotisations</h1>
  </header>
  <div>

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
    <tr>
      <td>{$subscription->getSubscribedAt()}</td>
      <td>{$subscription->getCreatedAt()}</td>
      <td>{$subscription->getFirstName()}</td>
      <td>{$subscription->getLastName()}</td>
    </tr>
    {/foreach}
  </tbody>
</table>

  </div>
</div>

{include file="common/footer.tpl"}
