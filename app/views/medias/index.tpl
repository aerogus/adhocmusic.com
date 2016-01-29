{include file="common/header.tpl"}

<div class="grid-2-1">

  <div>

    {if !empty($create)}
    <div class="success">Le contenu a bien été ajouté</div>
    {elseif !empty($edit)}
    <div class="success">Le contenu a bien été modifié</div>
    {elseif !empty($delete)}
    <div class="success">Le contenu a bien été effacé</div>
    {/if}

    {include file="common/boxstart.tpl" boxtitle="Rechercher un média"}
    <form id="form-media-search" name="form-media-search" method="get" action="/media/">
      <ol>
        <li>
          <select id="groupe" name="groupe" style="float: right;">
            <option value="0">---</option>
            {foreach from=$groupes item=groupe}
            <option value="{$groupe.id}">{$groupe.name|escape}</option>
            {/foreach}
          </select>
          <label for="groupe">Groupe</label>
        </li>
        <li>
          <select id="event" name="event" style="float: right;">
            <option value="0">---</option>
            {foreach from=$events item=event}
            <option value="{$event.id}">{$event.date|date_format:'%d/%m/%Y'} - {$event.name|escape} - {$event.lieu_name}</option>
            {/foreach}
          </select>
          <label for="event">Evénement</label>
        </li>
        <li>
          <ul id="type" style="float: right;">
            <li><img class="check_media" id="check_video" src="/img/icones/media-video-24.png" alt="Vidéo"></li>
            <li><img class="check_media" id="check_audio" src="/img/icones/media-audio-24.png" alt="Audio"></li>
            <li><img class="check_media" id="check_photo" src="/img/icones/media-photo-24.png" alt="Photo"></li>
          </ul>
          <input type="hidden" name="type_video" id="type_video" value="1">
          <input type="hidden" name="type_audio" id="type_audio" value="1">
          <input type="hidden" name="type_photo" id="type_photo" value="1">
          <label for="type">Type</label>
        </li>
      </ol>
    </form>

    <h3>Résultats de la recherche</h3>
    <div id="search-results"></div>

    {include file="common/boxend.tpl"}

    <div class="boxtitle">Derniers Média ajoutés</div>

    <ul id="search-box-results">
    {foreach from=$last_media key=type_media item=medias}
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
    {/foreach}
    </ul>

  </div>

  <div>

    {if !empty($comments)}
    {include file="common/boxstart.tpl" boxtitle="Derniers commentaires"}
    <ul>
      {foreach from=$comments item=comment}
      <li style="clear: both; margin-bottom: 5px;">
        <a href="/{$comment.type_full}/show/{$comment.id_content}">
          <img src="{image type='photo' id=$comment.id_content width=50 height=50 zoom=true}" alt="" style="float: left; padding-right: 5px; padding-bottom: 5px;" />
          <strong>{$comment.pseudo}</strong> le {$comment.created_on|date_format:'%d/%m/%Y'}<br />
          {$comment.text|truncate:'200'}
        </a>
      </li>
      {/foreach}
    </ul>
    {include file="common/boxend.tpl"}
    {/if}

  </div>

</div>{* .grid-2-1 *}

{include file="common/footer.tpl"}
