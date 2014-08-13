{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Résultats du Jeu Concours"}

<table>
  <thead>
    <tr>
      <th>Date</th>
      <th>Pseudo</th>
      <th>Nom</th>
      <th>Score</th>
    </tr>
  </thead>
  <tbody>
  {foreach from=$results item=p}
    <tr>
      <td>{$p.date|escape}</td>
      <td>{$p.pseudo|escape}</td>
      <td>{$p.first_name|escape} {$p.last_name|escape}</td>
      <td>{$p.score} / 6</td>
    </tr>
  {/foreach}
  </tbody>
</table>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}

