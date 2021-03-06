{include file="common/header.tpl"}

<div>

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
      <section class="grid-4">
        <div>
          <label for="name">Nom</label>
        </div>
        <div class="col-3 mbs">
          <span id="name">{$groupe->getName()|escape}</span>
        </div>
        <div>
          <label for="lelogo">Logo (.jpg)</label>
        </div>
        <div class="col-3 mbs">
          <img src="{$groupe->getLogo()}" alt=""><br><input type="file" id="lelogo" name="lelogo">
        </div>
        <div>
          <label for="photo">Photo (.jpg)</label>
        </div>
        <div class="col-3 mbs">
          <img src="{$groupe->getPhoto()}" alt=""><br><input type="file" id="photo" name="photo">
        </div>
        <div>
          <label for="mini_photo">Mini Photo carrée</label>
        </div>
        <div class="col-3 mbs">
          <img src="{$groupe->getMiniPhoto()}" alt=""><br><input type="file" id="mini_photo" name="mini_photo">
        </div>
        <div>
          <label for="style">Style (*)</label>
        </div>
        <div class="col-3 mbs">
          <div class="infobulle error" id="error_style"{if empty($error_style)} style="display: none"{/if}>Vous devez préciser le style musical</div>
          <input type="text" id="style" name="style" class="w100" value="{$data.style|escape}">
        </div>
        <div>
          <label for="influences">Influences</label>
        </div>
        <div class="col-3 mbs">
          <div class="infobulle error" id="error_influences"{if empty($error_influences)} style="display: none"{/if}>Vous devez préciser vos influences</div>
          <input type="text" id="influences" class="w100" name="influences" value="{$data.influences|escape}">
        </div>
        <div>
          <label for="site">Site</label>
        </div>
        <div class="col-3 mbs">
          <input type="text" id="site" name="site" class="w100" value="{$data.site|escape}">
        </div>
        <div>
          <label for="facebook_page_id">Id Page Facebook</label>
        </div>
        <div class="col-3 mbs">
          http://www.facebook.com/pages/{$groupe->getAlias()}/<input type="text" id="facebook_page_id" name="facebook_page_id" value="{$data.facebook_page_id|escape}">
        </div>
        <div>
          <label for="twitter_id">Identifiant Twitter</label>
        </div>
        <div class="col-3 mbs">
          http://www.twitter.com/<input type="text" id="twitter_id" name="twitter_id" value="{$data.twitter_id|escape}">
        </div>
        <div>
          <label for="lineup">Lineup (*)</label>
        </div>
        <div class="col-3 mbs">
          <div class="infobulle error" id="error_lineup"{if empty($error_lineup)} style="display: none"{/if}>Vous devez préciser votre formation</div>
          <textarea id="lineup" name="lineup" class="w100" rows="5">{$data.lineup|escape}</textarea>
        </div>
        <div>
          <label for="mini_text">Mini Présentation (*)</label>
        </div>
        <div class="col-3 mbs">
          <div class="infobulle error" id="error_mini_text"{if empty($error_mini_text)} style="display: none"{/if}>Vous devez écrire une mini présentation de moins de 250 caractères</div>
          <textarea id="mini_text" name="mini_text" class="w100" rows="5">{$data.mini_text|escape}</textarea>
        </div>
        <div>
          <label for="text">Présentation (*)</label>
        </div>
        <div class="col-3 mbs">
          <div class="infobulle error" id="error_text"{if empty($error_text)} style="display: none"{/if}>Vous devez préciser le champ présentation</div>
          <textarea id="text" name="text" class="w100" rows="20">{$data.text|escape}</textarea>
        </div>
        <div>
          <label for="id_type_musicien">Ma fonction</label>
        </div>
        <div class="col-3 mbs">
          <select id="id_type_musicien" name="id_type_musicien" class="w100">
            {foreach from=$types_musicien item=type_musicien}
            <option value="{$type_musicien->getId()|escape}"{if $data.id_type_musicien === $type_musicien->getId()} selected="selected"{/if}>{$type_musicien->getName()|escape}</option>
            {/foreach}
          </select>
        </div>
        <div></div>
        <div class="col-3">
          <input type="hidden" name="id" value="{$groupe->getId()|escape}">
          <input id="form-groupe-edit-submit" name="form-groupe-edit-submit" class="btn btn--primary w100" type="submit" value="Modifier">
        </div>
      </section>
    </form>

  </div>
</div>

</div>

<div>
  <a href="/photos/create?id_groupe={$groupe->getId()|escape}" class="btn btn--primary">Ajouter une photo</a>
  <a href="/audios/create?id_groupe={$groupe->getId()|escape}" class="btn btn--primary">Ajouter une musique</a>
  <a href="/videos/create?id_groupe={$groupe->getId()|escape}" class="btn btn--primary">Ajouter une vidéo</a>
  <a href="{$groupe->getUrl()}" class="btn btn--primary">Voir la fiche</a>
</div>

{/if}

{include file="common/footer.tpl"}
