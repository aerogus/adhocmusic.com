{include file="_header.tpl"}

<tbody>
  <tr>
    <td>Bonjour <strong>{$pseudo_to|escape}</strong> !</td>
  </tr>
  <tr>
    <td><strong>{$pseudo_from}</strong> vous a envoyé un message privé :</td>
  </tr>
  <tr>
    <td>{$text|@nl2br}</td>
  </tr>
  <tr>
    <td>Pour y répondre, veuillez vous connecter vous sur le <a style="color: #000000;" href="http://www.adhocmusic.com">site AD'HOC</a></td>
  </tr>
  <tr>
    <td>Musicalement,</td>
  </tr>
  <tr>
    <td>L'équipe AD'HOC</td>
  </tr>
</tbody>

{include file="_footer.tpl"}
