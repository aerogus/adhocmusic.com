{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Gestion du cache image"}

<form action="/dynimg/tool" method="get">
  <ol>
    <li>
      <label for="type">Type</label>
      <select id="type" name="type">
        <option value="photo"{if $type == 'photo'} selected="selected"{/if}>Photo</option>
        <option value="video"{if $type == 'video'} selected="selected"{/if}>Vidéo</option>
        <option value="event"{if $type == 'event'} selected="selected"{/if}>Evénement</option>
      </select>
    </li>
    <li>
      <label for="id">Identifiant (= le n°)</label>
      <input type="text" id="id" name="id" value="{$id|escape}">
    </li>
    <li>
      <label for="width">Largeur (en pixels)</label>
      <input type="text" id="width" name="width" value="{$width|escape}">
    </li>
    <li>
      <label for="height">Hauteur (en pixels)</label>
      <input type="text" id="height" name="height" value="{$height|escape}">
    </li>
    <li>
      <label for="border">Bordure (force la taille selectionnée en ajoutant des bordures)</label>
      <select id="border" name="border">
        <option value="0"{if $border == false} selected="selected"{/if}>Non</option>
        <option value="1"{if $border == true} selected="selected"{/if}>Oui</option>
      </select>
    </li>
    <li>
      <label for="bgcolor">Fond (si bordure, couleur de celles ci)</label>
      <input type="text" id="bgcolor" name="bgcolor" value="{$bgcolor|escape}">
    </li>
    <li>
      <label for="zoom">Zoom (zoom centré)</label>
      <select id="zoom" name="zoom">
        <option value="0"{if $zoom == false} selected="selected"{/if}>Non</option>
        <option value="1"{if $zoom == true} selected="selected"{/if}>Oui</option>
      </select>
    </li>
  </ol>
  <input type="submit" class="button" value="Générer">
</form>

{if !empty($url)}
<hr />
<p>Url de l'image : <strong>{$url|escape}</strong></p>
<p>Image : <img src="{$url|escape}" alt=""></p>
{*<p><a href="">Invalider le cache pour cette imagette</a></p>*}
{/if}

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
