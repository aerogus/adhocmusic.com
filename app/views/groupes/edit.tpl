{include file="common/header.tpl"}

<div id="left-center">

{if !empty($unknown_groupe)}

<div class="infobulle error">Groupe introuvable</div>

{elseif !empty($not_my_groupe)}

<div class="infobulle error">Vous ne pouvez pas éditer ce groupe.</div>

{else}

<div class="box">
  <header>
    <h2>{$groupe->getName()}</h2>
  </header>
  <div>

<form id="form-groupe-edit" name="form-groupe-edit" method="post" action="/groupes/edit" enctype="multipart/form-data">
  <ul>
    <li>
      <label for="name">Nom</label>
      <span id="name">{$groupe->getName()|escape}</span>
    </li>
    <li>
      <label for="lelogo">Logo (.jpg)</label>
      <img src="{$groupe->getLogo()}" alt=""><br><input type="file" id="lelogo" name="lelogo">
    </li>
    <li>
      <label for="photo">Photo (.jpg)</label>
      <img src="{$groupe->getPhoto()}" alt=""><br><input type="file" id="photo" name="photo">
    </li>
    <li>
      <label for="mini_photo">Mini Photo carrée</label>
      <img src="{$groupe->getMiniPhoto()}" alt=""><br><input type="file" id="mini_photo" name="mini_photo">
    </li>
    <li>
      <div class="infobulle error" id="error_style"{if empty($error_style)} style="display: none"{/if}>Vous devez préciser le style musical</div>
      <label for="style">Style</label>
      <input type="text" id="style" name="style" value="{$data.style|escape}">
    </li>
    <li>
      <div class="infobulle error" id="error_influences"{if empty($error_influences)} style="display: none"{/if}>Vous devez préciser vos influences</div>
      <label for="influences">Influences</label>
      <input type="text" id="influences" name="influences" value="{$data.influences|escape}">
    </li>
    <li>
      <label for="site">Site</label>
      <input type="text" id="site" name="site" size="50" value="{$data.site|escape}">
    </li>
    <li>
      <label for="facebook_page_id">Identifiant Page Fan Facebook</label>
      http://www.facebook.com/pages/{$groupe->getAlias()}/<input type="text" id="facebook_page_id" name="facebook_page_id" value="{$data.facebook_page_id|escape}">
    </li>
    <li>
      <label for="twitter_id">Identifiant Twitter</label>
      http://www.twitter.com/<input type="text" id="twitter_id" name="twitter_id" value="{$data.twitter_id|escape}">
    </li>
    <li>
      <div class="infobulle error" id="error_lineup"{if empty($error_lineup)} style="display: none"{/if}>Vous devez préciser votre formation</div>
      <label for="lineup">Lineup</label>
      <textarea id="lineup" name="lineup" cols="50" rows="5">{$data.lineup|escape}</textarea>
    </li>
    <li>
      <div class="infobulle error" id="error_mini_text"{if empty($error_mini_text)} style="display: none"{/if}>Vous devez écrire une mini présentation de moins de 250 caractères</div>
      <label for="mini_text">Mini Présentation</label>
      <textarea id="mini_text" name="mini_text" cols="50" rows="5">{$data.mini_text|escape}</textarea>
    </li>
    <li>
      <div class="infobulle error" id="error_text"{if empty($error_text)} style="display: none"{/if}>Vous devez préciser le champ biographie</div>
      <label for="text">Présentation</label>
      <textarea id="text" name="text" cols="50" rows="20">{$data.text|escape}</textarea>
    </li>
  </ul>
  <input type="hidden" name="id" value="{$groupe->getId()|escape}">
  <input id="form-groupe-edit-submit" name="form-groupe-edit-submit" class="button" type="submit" value="Modifier">
</form>

  </div>
</div>

</div>

<div id="right">
  <a href="/photos/create?id_groupe={$groupe->getId()|escape}" class="button">Ajouter une photo</a>
  <a href="/audios/create?id_groupe={$groupe->getId()|escape}" class="button">Ajouter une musique</a>
  <a href="/videos/create?id_groupe={$groupe->getId()|escape}" class="button">Ajouter une vidéo</a>
  <a href="{$groupe->getUrl()}" class="button">Voir la fiche</a>
</div>

{/if}

{include file="common/footer.tpl"}
