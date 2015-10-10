{include file="common/header.tpl"}

<div id="left-center">

{if !empty($unknown_groupe)}

<div class="error">Groupe introuvable</div>

{elseif !empty($not_my_groupe)}

<div class="error">Vous ne pouvez pas éditer ce groupe.</div>

{else}

<script>
$(function() {
  $("#form-groupe-edit").submit(function() {
    var valid = true;
    if($("#style").val() == "") {
      $("#error_style").fadeIn();
      valid = false;
    } else {
      $("#error_style").fadeOut();
    }
    if($("#influences").val() == "") {
      $("#error_influences").fadeIn();
      valid = false;
    } else {
      $("#error_influences").fadeOut();
    }
    if($("#lineup").val() == "") {
      $("#error_lineup").fadeIn();
      valid = false;
    } else {
      $("#error_lineup").fadeOut();
    }
    if($("#mini_text").val() == "") {
      $("#error_mini_text").fadeIn();
      valid = false;
    } else {
      $("#error_mini_text").fadeOut();
    }
    if($("#text").val() == "") {
      $("#error_text").fadeIn();
      valid = false;
    } else {
      $("#error_text").fadeOut();
    }
    return valid;
  });
});
</script>

{include file="common/boxstart.tpl" boxtitle=$groupe->getName()}

<form id="form-groupe-edit" name="form-groupe-edit" method="post" action="/groupes/edit" enctype="multipart/form-data">
  <ol>
    <li>
      <label for="name">Nom</label>
      <span id="name">{$groupe->getName()|escape}</span>
    </li>
    <li>
      <label for="lelogo">Logo (.jpg)</label>
      <img src="{$groupe->getLogo()}" alt="" /><br /><input type="file" id="lelogo" name="lelogo" />
    </li>
    <li>
      <label for="photo">Photo (.jpg)</label>
      <img src="{$groupe->getPhoto()}" alt="" /><br /><input type="file" id="photo" name="photo" />
    </li>
    <li>
      <label for="mini_photo">Mini Photo carrée</label>
      <img src="{$groupe->getMiniPhoto()}" alt="" /><br /><input type="file" id="mini_photo" name="mini_photo" />
    </li>
    <li>
      <div class="error" id="error_style"{if empty($error_style)} style="display: none"{/if}>Vous devez préciser le style musical</div>
      <label for="style">Style</label>
      <input type="text" id="style" name="style" value="{$data.style|escape}" />
      {*
      <br />
      {section name=style start=0 loop=3}
      {$smarty.section.style.index + 1} - <select id="style" name="style[{$smarty.section.style.index}]">
        <option value="0">---</option>
        {foreach from=$styles key=id item=name}
        <option value="{$id}"{if false} selected="selected"{/if}>{$name}</option>
        {/foreach}
      </select>
      {/section}
      *}
    </li>
    <li>
      <div class="error" id="error_influences"{if empty($error_influences)} style="display: none"{/if}>Vous devez préciser vos influences</div>
      <label for="influences">Influences</label>
      <input type="text" id="influences" name="influences" value="{$data.influences|escape}" />
    </li>
    <li>
      <label for="site">Site</label>
      <input type="text" id="site" name="site" size="50" value="{$data.site|escape}" /><br />Ne mettez pas votre url MySpace !
    </li>
    <li>
      <label for="myspace">Identifiant Myspace</label>
      http://www.myspace.com/<input type="text" id="myspace" name="myspace" value="{$data.myspace}" />
    </li>
    <li>
      <label for="facebook_page_id">Identifiant Page Fan Facebook</label>
      http://www.facebook.com/pages/{$groupe->getAlias()}/<input type="text" id="facebook_page_id" name="facebook_page_id" value="{$data.facebook_page_id|escape}" />
    </li>
    <li>
      <label for="twitter_id">Identifiant Twitter</label>
      http://www.twitter.com/<input type="text" id="twitter_id" name="twitter_id" value="{$data.twitter_id|escape}" />
    </li>
    <li>
      <div class="error" id="error_lineup"{if empty($error_lineup)} style="display: none"{/if}>Vous devez préciser votre formation</div>
      <label for="lineup">Lineup</label>
      <textarea id="lineup" name="lineup" cols="50" rows="5">{$data.lineup|escape}</textarea>
    </li>
    <li>
      <div class="error" id="error_mini_text"{if empty($error_mini_text)} style="display: none"{/if}>Vous devez préciser le champ biographie</div>
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
        <option value="{$id}"{if $id == $id_type_musicien} selected="selected"{/if}>{$name|escape}</option>
        {/foreach}
      </select>
    </li>
  </ol>
  <input type="hidden" name="id" value="{$groupe->getId()|escape}" />
  <input id="form-groupe-edit-submit" name="form-groupe-edit-submit" class="button" type="submit" value="Modifier" />
</form>

{include file="common/boxend.tpl"}

</div>

<div id="right">
<a href="/photos/create?id_groupe={$groupe->getId()|escape}" class="button">Ajouter une photo</a>
<a href="/audios/create?id_groupe={$groupe->getId()|escape}" class="button">Ajouter une musique</a>
<a href="/videos/create?id_groupe={$groupe->getId()|escape}" class="button">Ajouter une vidéo</a>
<a href="{$groupe->getUrl()}" class="button">Voir la fiche</a>
</div>

{/if}

{include file="common/footer.tpl"}