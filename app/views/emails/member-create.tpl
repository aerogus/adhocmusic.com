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
          <td>E-mail :</td>
          <td>{$email|escape}</td>
        </tr>
      </table>
    </td>
  </tr>
</tbody>

{include file="_footer.tpl"}
