{include file="common/header.tpl"}

{if !empty($inscrip_ok)}
<p class="error">Un groupe nommé <strong>{$groupe_name|escape}</strong> est déjà présent dans la base AD'HOC, sa création est donc impossible.<br>
Vous pouvez contacter le <a href="/membres/show/1">webmaster</a> pour plus d'infos.</p>
{/if}

{if !empty($inscrip_ok)}
<p class="success">Le groupe <strong>{$groupe_name}</strong> a bien été enregistré dans la base AD'HOC.<br>
Merci pour votre inscription. Vous pouvez si vous le souhaiter éditer votre fiche groupe et dès à présent annoncer les concerts de votre groupe.</p>
{/if}

{include file="common/boxstart.tpl" boxtitle="Ajouter un Groupe"}

<form id="form-groupe-create" name="form-groupe-create" method="post" action="/groupes/create" enctype="multipart/form-data">
  <ul>
    <li>
      <div class="error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez renseigner le nom de votre groupe</div>
      <label for="name">Nom</label>
      <input type="text" id="name" name="name" value="{$data.name|escape}">
    </li>
    <li>
      <label for="logo">Logo (.jpg)</label>
      <input type="file" id="lelogo" name="lelogo">
    </li>
    <li>
      <label for="photo">Photo (.jpg)</label>
      <input type="file" id="photo" name="photo">
    </li>
    <li>
      <label for="mini_photo">Mini Photo carrée</label>
      <input type="file" id="mini_photo" name="mini_photo">
    </li>
    <li>
      <div class="error" id="error_style"{if empty($error_style)} style="display: none"{/if}>Vous devez préciser le style musical</div>
      <label for="style">Style</label>
      <input type="text" id="style" name="style" size="50" value="{$data.style|escape}">
      {*
      {section name=style start=0 loop=3}
      {$smarty.section.style.index + 1} - <select name="style[{$smarty.section.style.index}]">
        <option value="0">---</option>
        {foreach from=$styles key=id item=name}
        <option value="{$id|escape}">{$name|escape}</option>
        {/foreach}
      </select>
      {/section}
      *}
    </li>
    <li>
      <div class="error" id="error_influences"{if empty($error_influences)} style="display: none"{/if}>Vous devez préciser vos influences</div>
      <label for="influences">Influences</label>
      <input type="text" id="influences" name="influences" size="50" value="{$data.influences|escape}">
    </li>
    <li>
      <label for="site">Site Web</label>
      <input type="text" id="site" name="site" size="50" value="{$data.site|escape}">
    </li>
    <li>
      <label for="myspace">Identifiant Myspace</label>
      http://www.myspace.com/<input type="text" id="myspace" name="myspace" size="50" value="{$data.myspace|escape}">
    </li>
    <li>
      <label for="facebook_page_id">Identifiant Page Fan Facebook</label>
      http://www.facebook.com/pages/nomdugroupe/<input type="text" id="facebook_page_id" name="facebook_page_id" value="{$data.facebook_page_id|escape}">
    </li>
    <li>
      <label for="twitter_id">Identifiant Twitter</label>
      http://www.twitter.com/<input type="text" id="twitter_id" name="twitter_id" value="{$data.twitter_id|escape}">
    </li>
    <li>
      <div class="error" id="error_lineup"{if empty($error_lineup)} style="display: none"{/if}>Vous devez préciser votre formation</div>
      <label for="lineup">Lineup</label>
      <textarea id="lineup" name="lineup" cols="50" rows="5">{$data.lineup|escape}</textarea>
    </li>
    <li>
      <div class="error" id="error_mini_text"{if empty($error_mini_text)} style="display: none"{/if}>Vous devez préciser le champ mini présentation</div>
      <label for="mini_text">Mini Présentation</label>
      <textarea id="mini_text" name="mini_text" cols="50" rows="5">{$data.mini_text|escape}</textarea>
    </li>
    <li>
      <div class="error" id="error_text"{if empty($error_text)} style="display: none"{/if}>Vous devez préciser le champ biographie</div>
      <label for="text">Présentation</label>
      <textarea id="text" name="text" cols="50" rows="20">{$data.text|escape}</textarea>
    </li>
    <li>
      <label for="id_type_musicien">Ma fonction au sein de ce groupe</label>
      <select id="id_type_musicien" name="id_type_musicien">
        {foreach from=$types_musicien key=id item=name}
        <option value="{$id|escape}">{$name|escape}</option>
        {/foreach}
      </select>
    </li>
  </ul>
  <input id="form-groupe-create-submit" name="form-groupe-create-submit" class="button" type="submit" value="Ajouter">
</form>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
