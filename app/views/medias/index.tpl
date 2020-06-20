{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Rechercher une vidéo</h1>
  </header>
  <div>
    <form id="form-media-search" name="form-media-search" method="get" action="/medias" style="margin-bottom:2rem">
      <section class="grid-4">
        <div>
          <label for="groupe">Groupe</label>
        </div>
        <div class="col-3 mbs">
          <select id="groupe" name="groupe" class="w100">
            <option value="">---</option>
            {foreach from=$groupes item=groupe}
            <option value="{$groupe->getIdGroupe()}">{$groupe->getName()|escape}</option>
            {/foreach}
          </select>
        </div>
        <div>
          <label for="event">Événement</label>
        </div>
        <div class="col-3 mbs">
          <select id="event" name="event" class="w100">
            <option value="">---</option>
            {foreach from=$events item=event}
            <option value="{$event->getIdEvent()}">{$event->getDate()|date_format:'%d/%m/%Y'} - {$event->getName()|escape} - {$event->getLieu()->getName()}</option>
            {/foreach}
          </select>
        </div>
        <div>
          <label for="lieu">Lieu</label>
        </div>
        <div class="col-3">
          <select id="lieu" name="lieu" class="w100">
            <option value="">---</option>
            {foreach from=$lieux item=lieu}
            <option value="{$lieu->getIdLieu()}">{$lieu->getCity()->getCp()} {$lieu->getCity()->getName()|escape} - {$lieu->getName()}</option>
            {/foreach}
          </select>
        </div>
      </section>
    </form>
    <div class="mtm" id="search-results"></div>
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
        <a class="playbtn" href="{$video->getUrl()}" title="Regarder la vidéo {$video->getName()|escape}">▶</a>
      </div>
      <p class="title"><a href="{$video->getUrl()}" title="Regarder la vidéo {$video->getName()|escape}">{$video->getName()|escape}</a></p>
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
