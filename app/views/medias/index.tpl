{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Rechercher une vidéo</h1>
  </header>
  <div>
    <form id="form-media-search" name="form-media-search" method="get" action="/medias" style="margin-bottom:2rem">
      <ul>
        <li>
          <label for="groupe" style="width:100px">Groupe</label>
          <select id="groupe" name="groupe">
            <option value="">---</option>
            {foreach from=$groupes item=groupe}
            <option value="{$groupe->getIdGroupe()}">{$groupe->getName()|escape}</option>
            {/foreach}
          </select>
        </li>
        <li>
          <label for="event" style="width:100px">Evénement</label>
          <select id="event" name="event">
            <option value="">---</option>
            {foreach from=$events item=event}
            <option value="{$event->getIdEvent()}">{$event->getDate()|date_format:'%d/%m/%Y'} - {$event->getName()|escape} - {$event->getLieu()->getName()}</option>
            {/foreach}
          </select>
        </li>
        <li>
          <label for="lieu" style="width:100px">Lieu</label>
          <select id="lieu" name="lieu">
            <option value="">---</option>
            {foreach from=$lieux item=lieu}
            <option value="{$lieu->getIdLieu()}">{$lieu->getCp()} {$lieu->getCity()|escape} - {$lieu->getName()}</option>
            {/foreach}
          </select>
        </li>
      </ul>
    </form>
    <div class="margin-top:2rem" id="search-results"></div>
  </div>
</div>{* .box *}

<div class="box">
  <header>
    <h2>Dernières vidéos ajoutées</h2>
  </header>
  {if count($last_videos)}
  <div class="reset grid-3-small-2 has-gutter">
    {foreach from=$last_videos item=video}
    <div class="video">
      <div class="thumb" style="background-image: url({$video->getThumbUrl(320)})">
        <a class="playbtn" href="{$video->getUrl()}" title="Lire la vidéo {$video->getName()|escape}">▶</a>
      </div>
      <p class="title"><a href="{$video->getUrl()}" title="Lire la vidéo {$video->getName()|escape}">{$video->getName()|escape}</a></p>
      <p class="subtitle">{if !empty($video->getGroupe())}<a href="{$video->getGroupe()->getUrl()}" title="Aller à la page du groupe {$video->getGroupe()->getName()|escape}">{$video->getGroupe()->getName()|escape}</a>{/if}</p>
    </div>
    {/foreach}
  </div>
  {else}
  <div>
    <p>Aucune vidéo ajoutée</p>
  </div>
  {/if}
</div>

{include file="common/footer.tpl"}
