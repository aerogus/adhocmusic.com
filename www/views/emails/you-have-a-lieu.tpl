{include file="_header.tpl"}

<tbody>
  <tr>
    <td>
      <p>Bonjour <strong>{$email|escape}</strong> !</p>
      <p>Nous vous envoyons ce message car votre email est inscrite le site <a style="color: #000000;" href="http://www.adhocmusic.com"><strong>AD'HOC</strong></a> comme contact pour le lieu de diffusion : <a style="color: #000000;" href="http://www.adhocmusic.com/lieux/show/{$id|escape}" style="color: #000000;"><strong>{$name|escape}</strong></a>.</p>
      <table><tr><td bgcolor="#ececec">
      <strong>{$name|escape}</strong><br>
      {$address|escape}<br>
      {$cp2|escape} {$city2|escape}<br>
      </td></tr></table>
      <p>Pourriez vous aller sur votre <a style="color: #000000;" href="http://www.adhocmusic.com/lieux/show/{$id|escape}">fiche lieu</a> pour vérifier l'exactitude de l'ensemble des informations afin que notre base de données soit à jour ?</p>
      <p>Nous vous rappelons également que le <a style="color: #000000;" href="http://www.adhocmusic.com">site AD'HOC</a>, c'est un <strong>agenda culturel collaboratif, et géolocalisé</strong>. Nous vous invitons donc à saisir régulièrement vos dates d'événements que nous relayerons sur notre <a href="http://www.adhocmusic.com" style="color: #000000;">site web</a>, notre <a style="color: #000000;" href="http://m.adhocmusic.com">site mobile</a>, notre <a style="color: #000000;" href="http://www.facebook.com/adhocmusic">page facebook</a> et avec nos partenaires. <strong>Saisies une fois => visibles sur différentes plateformes !</strong></p>
      <p>Plus généralement, beaucoup d'améliorations ont vu le jour ces derniers mois sur AD'HOC, toujours au service des musiciens, des groupes et des lieux de diffusion, venez donc découvrir toutes ces nouveautés sur notre <a style="color: #000000;" href="http://www.adhocmusic.com">nouveau site</a>.</p>
      <p align="center"><a href="http://www.adhocmusic.com"><img src="http://static.adhocmusic.com/img/emails/adhoc-homepage.jpg" alt="" /></a></p>
      <p>Si vous avez oublié le mot de passe de votre compte AD'HOC, rendez vous sur la page de <a style="color: #000000;" href="http://www.adhocmusic.com/auth/lost-password">récupération du mot de passe</a></p>
      <p>Pour toute demande d'informations, modification d'info sur votre fiche lieu, n'hésitez pas à nous écrire via notre <a style="color: #000000;" href="http://www.adhocmusic.com/contact">formulaire de contact</a></p>
      <p>En vous souhaitant du succès dans vos lieux de diffusion respectifs.</p>
      <p>Musicalement,</p>
      <p>L'équipe AD'HOC</p>
    </td>
  </tr>
</tbody>

{include file="_footer.tpl"}
