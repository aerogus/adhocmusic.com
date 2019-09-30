{include file="common/header.tpl"}

<div class="grid-3-small-1 has-gutter-l">

  <div class="col-2-small-1">

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
        <form id="form-media-search" name="form-media-search" method="get" action="/media/">
          <ul>
            <li>
              <label for="groupe">Groupe</label>
              <select id="groupe" name="groupe">
                <option value="0">---</option>
                {foreach from=$groupes item=groupe}
                <option value="{$groupe.id}">{$groupe.name|escape}</option>
                {/foreach}
              </select>
            </li>
            <li>
              <label for="event">Evénement</label>
              <select id="event" name="event">
                <option value="0">---</option>
                {foreach from=$events item=event}
                <option value="{$event.id}">{$event.date|date_format:'%d/%m/%Y'} - {$event.name|escape} - {$event.lieu_name}</option>
                {/foreach}
              </select>
            </li>
          </ul>
          <input type="hidden" name="type_video" id="type_video" value="1">
          <input type="hidden" name="type_audio" id="type_audio" value="0">
          <input type="hidden" name="type_photo" id="type_photo" value="0">
        </form>
        <h3>Résultats de la recherche</h3>
        <div id="search-results"></div>
      </div>
    </div>{* .box *}

    <div class="box">
      <header>
        <h1>Dernières vidéos ajoutées</h1>
      </header>
    </div>

    <ul id="search-box-results">
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

  </div>{* .col-2-small-1 *}

  <div class="col-1">

    <div class="box">
      <header>
        <h1>Derniers commentaires</h1>
      </header>
      <div>
        {if !empty($comments)}
        <ul>
          {foreach from=$comments item=comment}
          <li style="clear:both;margin-bottom:5px">
            <a href="/{$comment.type_full}/{$comment.id_content}">
              <img src="{image type='photo' id=$comment.id_content width=50 height=50 zoom=true}" alt="" style="float: left; padding-right: 5px; padding-bottom: 5px;" />
              <strong>{$comment.pseudo}</strong> le {$comment.created_on|date_format:'%d/%m/%Y'}<br />
              {$comment.text|truncate:'200'}
            </a>
          </li>
          {/foreach}
        </ul>
        {else}
        <p>Aucun commentaire</p>
        {/if}
      </div>
    </div>{* .box *}

  </div>{* .col-1 *}

</div>{* .grid-3-small-1 *}

{include file="common/footer.tpl"}
