{include file="common/header.tpl"}

{if !empty($inscrip_ok)}
<p class="infobulle error">Un groupe nommé <strong>{$groupe_name|escape}</strong> est déjà présent dans la base AD'HOC, sa création est donc impossible.<br>
Vous pouvez contacter le <a href="/membres/show/1">webmaster</a> pour plus d'infos.</p>
{/if}

{if !empty($inscrip_ok)}
<p class="infobulle success">Le groupe <strong>{$groupe_name}</strong> a bien été enregistré dans la base AD'HOC.<br>
Merci pour votre inscription. Vous pouvez si vous le souhaiter éditer votre fiche groupe et dès à présent annoncer les concerts de votre groupe.</p>
{/if}

<div class="box">
  <header>
    <h1>Ajouter un groupe</h1>
  </header>
  <div>
    <form id="form-groupe-create" name="form-groupe-create" method="post" action="/groupes/create" enctype="multipart/form-data">
      <section class="grid-4">
        <div>
          <label for="name">Nom (*)</label>
        </div>
        <div class="col-3 mbs">
          <div class="infobulle error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez renseigner le nom de votre groupe</div>
          <input type="text" id="name" name="name" value="{$data.name|escape}" class="w100">
        </div>
        <div>
          <label for="logo">Logo (.jpg)</label>
        </div>
        <div class="col-3 mbs">
          <input type="file" id="lelogo" name="lelogo">
        </div>
        <div>
          <label for="photo">Photo (.jpg)</label>
        </div>
        <div class="col-3 mbs">
          <input type="file" id="photo" name="photo">
        </div>
        <div>
          <label for="mini_photo">Mini Photo carrée</label>
        </div>
        <div class="col-3 mbs">
          <input type="file" id="mini_photo" name="mini_photo">
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
          <input type="text" id="influences" name="influences" class="w100" value="{$data.influences|escape}">
        </div>
        <div>
          <label for="site">Site Web</label>
        </div>
        <div class="col-3 mbs">
          <input type="text" id="site" name="site" class="w100" value="{$data.site|escape}">
        </div>
        <div>
          <label for="facebook_page_id">Identifiant Page Fan Facebook</label>
        </div>
        <div class="col-3 mbs">
          http://www.facebook.com/pages/nomdugroupe/<input type="text" id="facebook_page_id" name="facebook_page_id" value="{$data.facebook_page_id|escape}">
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
            <option value="{$type_musicien->getId()|escape}">{$type_musicien->getName()|escape}</option>
            {/foreach}
          </select>
        </div>
        <div></div>
        <div class="col-3 mbs">
          <input id="form-groupe-create-submit" name="form-groupe-create-submit" class="btn btn--primary w100" type="submit" value="Ajouter">
        </div>
      </section>
    </form>
  </div>
</div>

{include file="common/footer.tpl"}
