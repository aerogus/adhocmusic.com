{include file="_header.tpl"}

<tbody>
  <tr>
    <td>
      <p>{$subject}</p>
      <p><strong>{$pseudo}</strong> a écrit le <strong>{$date|date_format:'%d/%m/%Y à %H:%M'}</strong> :</p>
      <p><em>{$text}</em></p>
      <p>Pour y répondre, veuillez vous rendre sur la page suivante :</p>
      <p><a href="{$url}">{$url}</a></p>
    </td>
  </tr>
</tbody>

{include file="_footer.tpl"}
