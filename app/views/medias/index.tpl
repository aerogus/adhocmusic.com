{include file="common/header.tpl"}

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
            <option value="">---</option>
            {foreach from=$groupes item=groupe}
            <option value="{$groupe->getIdGroupe()}">{$groupe->getName()|escape}</option>
            {/foreach}
          </select>
        </li>
        <li>
          <label for="event">Evénement</label>
          <select id="event" name="event">
            <option value="">---</option>
            {foreach from=$events item=event}
            <option value="{$event->getIdEvent()}">{$event->getDate()|date_format:'%d/%m/%Y'} - {$event->getName()|escape} - {$event->getLieu()->getName()}</option>
            {/foreach}
          </select>
        </li>
      </ul>
    </form>
    <div id="search-results"></div>
  </div>
</div>{* .box *}

<div class="box">
  <header>
    <h2>Dernières vidéos ajoutées</h2>
  </header>
  {if count($last_videos)}
  <div class="reset">
    <ul id="search-box-results" class="grid-8">
    {foreach from=$last_videos item=video}
      <li class="search-box-result">
        <div class="search-box-result-video">
          <div class="thumb-100">
            <a href="{$video->getUrl()}">
              <img src="{$video->getThumbUrl(80)}" style="width: 100px; height: 100px;" alt="{$video->getName()|escape}">
              <h3>{$video->getName()|truncate:35:"...":true:true|escape}</h3>
            </a>
            <a class="overlay-100 overlay-video-100" href="{$video->getUrl()}" title="{$video->getName()|escape}"></a>
          </div>
        </div>
      </li>
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
