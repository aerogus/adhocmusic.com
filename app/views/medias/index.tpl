{include file="common/header.tpl"}

{if !empty($create)}
<div class="infobulle success">Le contenu a bien été ajouté</div>
{elseif !empty($edit)}
<div class="infobulle success">Le contenu a bien été modifié</div>
{elseif !empty($delete)}
<div class="infobulle success">Le contenu a bien été effacé</div>
{/if}

<div class="box">
  <header>
    <h1>Rechercher une vidéo</h1>
  </header>
  <div>
    <form id="form-media-search" name="form-media-search" method="get" action="/medias">
      <ul>
        <li>
          <label for="groupe">Groupe</label>
          <select id="groupe" name="groupe">
            <option value="0">---</option>
            {foreach from=$groupes item=groupe}
            <option value="{$groupe->getIdGroupe()}">{$groupe->getName()|escape}</option>
            {/foreach}
          </select>
        </li>
        <li>
          <label for="event">Evénement</label>
          <select id="event" name="event">
            <option value="0">---</option>
            {foreach from=$events item=event}
            <option value="{$event->getIdEvent()}">{$event->getDate()|date_format:'%d/%m/%Y'} - {$event->getName()|escape} - {$event->getLieu->getName()}</option>
            {/foreach}
          </select>
        </li>
      </ul>
      <input type="hidden" name="type_video" id="type_video" value="1">
      <input type="hidden" name="type_audio" id="type_audio" value="0">
      <input type="hidden" name="type_photo" id="type_photo" value="0">
    </form>
    <h2>Résultats de la recherche</h2>
    <div id="search-results"></div>
  </div>
</div>{* .box *}

<div class="box">
  <header>
    <h2>Dernières vidéos ajoutées</h2>
  </header>
  {if count($last_media.video)}
  <div class="reset">
    <ul id="search-box-results" class="grid-8">
    {foreach from=$last_media key=type_media item=medias}
    {if $type_media == 'video'}
      {foreach from=$medias item=media}
      <li class="search-box-result">
        <div class="search-box-result-{$media.type}">
          <div class="thumb-100">
            <a href="{$media.url}">
              <img src="{$media.thumb_80_80}" style="width: 100px; height: 100px;" alt="{$media.name|escape}">
              <h3>{$media.name|truncate:35:"...":true:true|escape}</h3>
            </a>
            <a class="overlay-100 overlay-{$media.type}-100" href="{$media.url}" title="{$media.name|escape}"></a>
          </div>
        </div>
      </li>
      {/foreach}
    {/if}
    {/foreach}
    </ul>
  </div>
  {else}
  <div>
    <p>Aucune vidéo ajoutée</p>
  </div>
  {/if}
</div>

{include file="common/footer.tpl"}
