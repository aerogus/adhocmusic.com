{include file="fb/adhocmusic/canvas/common/header.tpl"}

<p>Les musiciens AD'HOC sont sur Facebook !</p>

<table bgcolor="#999999" cellspacing="1">
  <tr>
    <th>Groupe</th>
    <th>Membres</th>
  </tr>
  {foreach from=$groupes item=groupe}
  <tr>
    <td bgcolor="#cccccc"><a href="groupe/{$groupe.id|escape}.html"><strong>{$groupe.name|escape}</strong><br /><img src="{$groupe.mini_photo|escape}" /><br /></a></td>
    <td bgcolor="#cccccc">
    <table>
      <tr>
      {assign var=id_groupe value=$groupe.id}
      {foreach from=$membres.$id_groupe item=membre}
        <td align="center">
          <a href="profil/{$membre.facebook_uid|escape}.html"><fb:profile-pic uid="{$membre.facebook_uid|escape}" linked="false" /></a>
          <br />
          <a href="profil/{$membre.facebook_uid|escape}.html">({$membre.type_musicien_name|escape})</a>)
          {if $membre.nb_photos|escape > 0}
          <br />
          <a href="profil/{$membre.facebook_uid|escape}.html">{$membre.nb_photos|escape} photos</a>)
          {/if}
        </td>
      {/foreach}
      </tr>
    </table>
  </td>
</tr>
{/foreach}
</table>

{include file="fb/adhocmusic/canvas/common/footer.tpl"}
