{include file="_header.tpl"}

<tbody>
  <tr>
    <td>
      <p>Un message a été envoyé à partir du formulaire de contact du site AD'HOC. Le voici</p>
      <table>
        <tr>
          <td>De :</td>
          <td>{$name|escape}</td>
        <tr>
          <td>Email :</td>
          <td>{$email|escape}</td>
        </tr>
        <tr>
          <td>Date :</td>
          <td>{$date|date_format:'le %d/%m/%Y à %H:%M:%S'}</td>
        </tr>
        <tr>
          <td>Sujet :</td>
          <td>{$subject|escape}</td>
        </tr>
        <tr>
          <td>Texte :</td>
          <td>{$text|escape|@nl2br}</td>
        </tr>
        <tr>
          <td>Copie :</td>
          <td>{$cc|escape}</td>
        </tr>
        <tr>
          <td>Newsletter :</td>
          <td>{$mailing|escape}</td>
        </tr>
      </table>
    </td>
  </tr>
</tbody>

{include file="_footer.tpl"}
