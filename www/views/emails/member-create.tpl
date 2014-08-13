{include file="_header.tpl"}

<tbody>
  <tr>
    <td>
      <p>Cet email confirme votre inscription au site AD'HOC</p>
      <p>Voici les informations qui ont été enregistrées dans notre base</p>
    </td>
  </tr>
  <tr>
    <td>
      <table>
        <tr>
          <td>Pseudo :</td>
          <td><strong>{$pseudo|escape}</strong></td>
        </tr>
        <tr>
          <td>Password :</td>
          <td><strong>{$password|escape}</strong></td>
        </tr>
        <tr>
          <td>Nom :</td>
          <td>{$last_name|escape}</td>
        </tr>
        <tr>
          <td>Prénom :</td>
          <td>{$first_name|escape}</td>
        </tr>
        <tr>
          <td>Code Postal :</td>
          <td>{$cp|escape}</td>
        </tr>
        <tr>
          <td>Ville :</td>
          <td>{$city|escape}</td>
        </tr>
        <tr>
          <td>Pays :</td>
          <td>{$country|escape}</td>
        </tr>
        <tr>
          <td>Email :</td>
          <td>{$email|escape}</td>
        </tr>
      </table>
    </td>
  </tr>
</tbody>

{include file="_footer.tpl"}
