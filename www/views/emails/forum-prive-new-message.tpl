{include file="_header.tpl"}

<tbody>
  <tr>
    <td>
      <p>Salut <strong>{$pseudo_to|escape}</strong> !</p>

      <img align="left" src="{$avatar|escape}" alt="" style="float: left; width: 50px; height: 50px; padding-right: 10px; padding-bottom: 10px;" />
      <p><strong>{$pseudo_from|escape}</strong> a envoyé un nouveau message dans le forum <strong>{$forum_name|escape}</strong></p>

      {if !empty($subject)}
      <p>Sujet : <strong>{$subject|escape}</strong></p>
      {/if}

      {$text}

      <p>Pour le consulter et y répondre, <a href="http://www.adhocmusic.com/adm/forums/thread/{$id_thread|escape}">clique ici</a>.</p>
      <p>Ne répond pas à ce message directement.</p>
      <p>Musicalement,</p>
      <p>Le site AD'HOC</p>
    </td>
  </tr>
</tbody>

{include file="_footer.tpl"}
