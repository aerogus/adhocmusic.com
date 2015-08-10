{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Nos Domaines"}

<table>
  <thead>
    <tr>
      <th>Domaine</th>
      <th>Création</th>
      <th>Modification</th>
      <th>Expiration</th>
      <th>Owner</th>
      <th>Admin</th>
      <th>Tech</th>
      <th>Billing</th>
    </tr>
  </thead>
  {foreach from=$domains key=cpt item=domain}
  <tbody>
    <tr class="{if $cpt is odd}odd{else}even{/if}">
      <td>{$domain->domain}</td>
      <td>{$domain->creation}</td>
      <td>{$domain->modification}</td>
      <td>{$domain->expiration}</td>
      <td>{$domain->nicowner}</td>
      <td>{$domain->nicadmin}</td>
      <td>{$domain->nictech}</td>
      <td>{$domain->nicbilling}</td>
    </tr>
  </tbody>
  {/foreach}
</table>

<p>Domaines non gérés par nous mais pointant sur notre serveur : e-core.fr, saisonsenvrac.fr</p>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
