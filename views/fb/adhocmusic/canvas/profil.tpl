{include file="fb/adhocmusic/canvas/common/header.tpl"}

<img src="http://www.adhocmusic.com{$mbr->getPhoto()}" alt="{$mbr->getPseudo()|escape}" style="float: right;" />
<img src="{#STATIC_URL#}/img/profil.jpg" alt="Photo non disponible" style="float: right;" />

<table>
  <tr>
    <td>Pseudo :</td>
    <td><strong>{$mbr->getPseudo()|escape}</strong></td>
  </tr>
  <tr>
    <td>Site :</td><td><a href="{$mbr->getSite()}">{$mbr->getSite()}</a></td></tr>
  <tr>
    <td>Présentation :</td>
    <td>{$mbr->getText()|escape}</td>
  </tr>
  <tr>
    <td>Inscription :</td>
    <td>{$mbr->getCreatedOn()|date_format:"%d/%m/%Y %H:%M"}</td>
  </tr>
  <tr>
    <td>Mise à jour :</td>
    <td>{$mbr->getModifiedOn()|date_format:"%d/%m/%Y %H:%M"}</td>
  </tr>
  <tr>
    <td>Dernière connexion :</td>
    <td>{$mbr->getVisitedOn()|date_format:"%d/%m/%Y %H:%M"}</td>
  </tr>
  <tr>
    <td>Groupe(s) :</td>
    <td>...</td>
  </tr>
  <tr>
    <td>Photos(s) :</td>
    <td></td>
  </tr>
{if !empty($mbr->getFacebook()}
  <tr>
    <td>Profil Facebook :</td>
    <td><a href="http://www.facebook.com/profile.php?id={$mbr->getFacebookUid()}"><fb:profile-pic uid="{$mbr->getFacebookUid()}" linked="false" /></a></td>
  </tr>
{/if}
</table>

{include file="fb/adhocmusic/canvas/common/footer.tpl"}
