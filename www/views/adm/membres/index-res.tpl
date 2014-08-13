  {foreach from=$membres key=cpt item=membre}
  <tbody>
    <tr class="{if $cpt is odd}odd{else}even{/if}">
      <td>{$membre.id|escape}</td>
      <td><a href="/adm/membres/show/{$membre.id}">{$membre.pseudo|escape}</a></td>
      <td>{$membre.last_name|escape}</td>
      <td>{$membre.first_name|escape}</td>
      <td>{$membre.email|escape}</td>
      <td>{$membre.created_on|date_format:'%d/%m/%y'}</td>
      <td>{$membre.modified_on|date_format:'%d/%m/%y'}</td>
      <td>{$membre.visited_on|date_format:'%d/%m/%y'}</td>
      <td>{$membre.lastnl|date_format:'%d/%m/%y'}</td>
    </tr>
  </tbody>
  {/foreach}
