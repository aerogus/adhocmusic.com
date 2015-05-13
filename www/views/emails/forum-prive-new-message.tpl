{include file="_header.tpl"}

<tbody>
  <tr>
    <td>
      <img align="left" src="{$avatar|escape}" alt="" style="float: left; width: 50px; height: 50px; padding-right: 10px; padding-bottom: 10px;">
      <p><strong>{$pseudo_from|escape}</strong> a écrit dans le forum <strong>{$forum_name|escape}</strong> :</p>
      {if !empty($subject)}
      <p><strong>{$subject|escape}</strong></p>
      {/if}
      {$text|@nl2br}
      <p>Pour y répondre, <a href="http://www.adhocmusic.com/adm/forums/thread/{$id_thread|escape}">clique ici</a>.</p>
    </td>
  </tr>
</tbody>

{include file="_footer.tpl"}
