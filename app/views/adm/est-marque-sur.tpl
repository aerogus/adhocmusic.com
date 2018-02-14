{include file="common/header.tpl"}

{if !empty($tag_ok)}
<p class="success">Tag enregistré</p>
{/if}

{if !empty($show_list)}

{include file="common/boxstart.tpl" boxtitle="Taggage des photos"}

{if !empty($nb_photos)}
{foreach $photos as $photo}
<div class="thumb-80">
<a href="/adm/est-marque-sur/{$photo.id|escape}?page={$page|escape}"><img src="{$photo.thumb_80_80}" alt="{$photo.name|escape}{if !empty($photo.groupe_name)} ({$photo.groupe_name|escape}){/if}"></a>
<a class="overlay-80 overlay-photo-80" href="/adm/est-marque-sur/{$photo.id|escape}?page={$page|escape}" title="{$photo.name|escape}{if !empty($photo.groupe_name)} ({$photo.groupe_name|escape}){/if}"></a>
<br><span style="background-color: {$photo.bgcolor|escape};     color:#000000;">{$photo.nb_tags|escape}</span>
</div>
{/foreach}
{else}
<p>Aucune photo</p>
{/if}

{include file="common/boxend.tpl"}

{/if}

{if !empty($show_photo)}

{include file="common/boxstart.tpl" boxtitle="Tagguer une photo"}

<form id="form-est-marque-sur" name="form-est-marque-sur" method="post" action="/adm/est-marque-sur">
  <table align="center">
    <tr>
      <td>Photo :</td>
      <td align="left"><img src="/dynimg/photo/{$photo->getId()}/400/300/666666/0/0.jpg" alt=""></td>
    </tr>
    <tr>
      <td>Tags :</td>
      <td>
      {section name=cpt_tag loop=5}
      <select name="id_contact_{$smarty.section.cpt_tag.index}" size="1">
        <option value="0">---</option>
        {foreach $membres as $membre}
          <option value="{$membre.id_contact|escape}"{if !empty($tags)} selected="selected" {/if}>{$membre.last_name|escape} {$membre.first_name|escape} ({$membre.pseudo|escape})</option>
        {/foreach}
      </select><br>
      {/section}
      </td>
    </tr>
    <tr>
      <td><input type="hidden" name="confirm" value="1"></td>
      <td><input id="form-est-marque-sur-submit" name="form-est-marque-sur-submit" type="submit" value="Enregistrer"> <a href="/adm/est-marque-sur?page={$page}">retour</a></td>
    </tr>
  </table>
  <input type="hidden" name="id_photo" value="{$photo->getId()}">
  <input type="hidden" name="page" value={$page}">
</form>

{include file="common/boxend.tpl"}

{/if}

{include file="common/footer.tpl"}
