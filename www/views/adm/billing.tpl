{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Factures OVH"}

<table>
  <thead>
    <tr>
      <th>Date</th>
      <th>n° facture</th>
      <th>Payé par</th>
      <th>Montant TTC</th>
      <th>Description</th>
    </tr>
  </thead>
  {foreach from=$invoices key=cpt item=in}
  <tbody>
    <tr class="{if $cpt is odd}odd{else}even{/if}">
      <td>{$in.date}</td>
      <td>{$in.billnum}</td>
      <td>{$in.nic}</td>
      <td>{$in.totalPriceWithVat}</td>
      <td>{foreach $in.details as $detail}
      {$detail->domain} / {$detail->reference} / {$detail->description}<br />
      {/foreach}</td>
    </tr>
  </tbody>
  {/foreach}
</table>

<p>Total payé : <strong>{$total} E</strong></p>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
