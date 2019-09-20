{include file="_header.tpl"}

<tbody>
  <tr>
    <td>
      <p>Vous avez envoyé un message via le formulaire de contact du site AD'HOC, en voici une copie</p>
      <table>
        <tr>
          <td>De :</td>
          <td>{$name|escape}</td>
        <tr>
          <td>Email :</td>
          <td>{$email|escape}</td>
        </tr>
        <tr>
          <td>Sujet :</td>
          <td>{$subject|escape}</td>
        </tr>
        <tr>
          <td>Texte :</td>
          <td>{$text|escape|@nl2br}</td>
        </tr>
      </table>
    </td>
  </tr>
</tbody>

{include file="_footer.tpl"}
