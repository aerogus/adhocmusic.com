{include file="_header.tpl"}

<tbody>
  <tr>
    <td>
      <p>Bonjour <strong>{$email|escape}</strong> !</p>
      <p>Votre email est inscrite le site <a style="color: #000000;" href="http://www.adhocmusic.com">AD'HOC</a> comme contact pour le groupe <a href="http://www.adhocmusic.com/{$alias|escape}" style="color: #000000;"><strong>{$name|escape}</strong></a></p>
      <p>Vous avez créé cette fiche le <strong>{$created_on|date_format:'%d/%m/%Y'}</strong></p>
      <table><tr><td bgcolor="#ececec">
      <img align="left" src="http://static.adhocmusic.com/media/groupe/m{$id|escape}.jpg" alt="" style="float: left; padding-right: 10px;" />
      {$mini_text|escape}
      </td></tr></table>
      <p>Cependant nous remarquons que votre fiche groupe n'a pas été mise à jour depuis plus d'un an.</p>
      <p>Afin d'améliorer la communication entre AD'HOC et ses groupes, nous vous envoyons donc ce message de rappel.</p>
      <p>Beaucoup d'améliorations ont vu le jour ces derniers mois au service des musiciens et groupes, venez découvrir toutes ces nouveautés sur notre <a style="color: #000000;" href="http://www.adhocmusic.com">nouveau site</a>.</p>
      <p align="center"><a href="http://www.adhocmusic.com"><img src="http://static.adhocmusic.com/img/emails/adhoc-homepage.jpg" alt="" /></a></p>
      <p>Si vous avez oublié le mot de passe de votre compte AD'HOC, rendez vous sur la page de <a style="color: #000000;" href="http://www.adhocmusic.com/auth/lost-password">récupération du mot de passe</a></p>
      <p>Pour toute demande d'informations, de suppression éventuelle de fiche groupe, n'hésitez pas à nous écrire via notre <a style="color: #000000;" href="http://www.adhocmusic.com/contact">formulaire de contact</a></p>
      <p>En vous souhaitant bientôt de retour parmi nous !</p>
      <p>Musicalement,</p>
      <p>L'équipe AD'HOC</p>
    </td>
  </tr>
</tbody>

{include file="_footer.tpl"}
