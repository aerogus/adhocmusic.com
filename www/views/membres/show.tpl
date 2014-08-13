{include file="common/header.tpl"}

{if !empty($unknown_member)}

<p class="error">Ce membre est introuvable !</p>

{else}

{include file="common/boxstart.tpl" boxtitle="Profil de {$membre->getPseudo()|escape}"}

{if $membre->getAvatar()}
<img src="{$membre->getAvatar()}" alt="{$membre->getPseudo()|escape}" style="float: right;" />
{/if}

<table>
  <tr>
    <td>Pseudo :</td>
    <td><strong>{$membre->getPseudo()|escape}</strong> <a href="/messagerie/write?pseudo={$membre->getPseudo()|escape}"><img src="{#STATIC_URL#}/img/icones/email_write.png" alt="" />Lui Ecrire</a></td>
  </tr>
  <tr>
    <td>Site :</td>
    <td><a href="{$membre->getSite()}">{$membre->getSite()}</a></td>
  </tr>
  <tr>
    <td>Présentation :</td>
    <td>{$membre->getText()}</td>
  </tr>
  <tr>
    <td>Inscription :</td>
    <td>{$membre->getCreatedOn()|date_format:"%d/%m/%Y %H:%M"}</td>
  </tr>
  <tr>
    <td>Mise à jour :</td>
    <td>{$membre->getModifiedOn()|date_format:"%d/%m/%Y %H:%M"}</td>
  </tr>
  <tr>
    <td>Dernière connexion :</td>
    <td>{$membre->getVisitedOn()|date_format:"%d/%m/%Y %H:%M"}</td>
  </tr>
  <tr>
    <td>Groupe(s) :</td>
    <td>

{if $groupes|@count > 0}
<ul>
  {foreach from=$groupes item=groupe}
  <li><a href="{$groupe.url|escape}">{$groupe.name|escape}</a> ({$groupe.type_musicien_name|escape})</li>
  {/foreach}
</ul>
{else}
<p>aucun groupe</p>
{/if}

    </td>
  </tr>

  {if !empty($photos)}
  <tr>
    <td>Photos avec {$membre->getPseudo()|escape} :</td>
    <td>
    {foreach from=$photos item=photo}
    <div class="thumb-80">
      <a href="{$photo.url}"><img src="{$photo.thumb_80_80}" alt="{$photo.name|escape}{if !empty($photo.groupe_name)} ({$photo.groupe_name|escape}){/if}" /></a>
      <a class="overlay-80 overlay-photo-80" href="{$photo.url}?from=profil" title="{$photo.name|escape}{if !empty($photo.groupe_name)} ({$photo.groupe_name|escape}){/if}"></a>
    </div>
    {/foreach}
    </td>
  </tr>
  {/if}

  {if $membre->getFacebookUid()}
  <tr>
    <td>Facebook :</td>
    <td><a href="http://www.facebook.com/profile.php?id={$membre->getFacebookUid()}"><img src="{#STATIC_URL#}/img/facebook.gif" alt="" /></a></td>
  </tr>
  {/if}

</table>

{include file="common/boxend.tpl"}

{/if} {* test unknown membre *}

{include file="common/footer.tpl"}
