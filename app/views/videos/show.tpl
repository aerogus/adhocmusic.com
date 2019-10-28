{include file="common/header.tpl"}

{if !empty($unknown_video)}

<p class="infobulle error">Cette vidéo est introuvable !</p>

{else}

<style>
.metatop {
  color: #fff;
  margin-top: 5px;
  padding: 3px 5px;
  font-weight: bold;
  background-color: #999999;
}
.metacontent {
  padding: 5px 0px 5px 5px;
}
</style>

<div class="grid-3-small-1 has-gutter-l">

  <div class="col-2-small-1">
    <div class="box">
      <header>
        <h1>{$video->getName()|escape}</h1>
      </header>
      <div class="reset">
      {$video->getPlayer(true)}
      </div>
    </div>

    {if false}{* commentaires désactivés *}
    <div class="box">
      <header>
        <h2>Commentaires</h2>
      </header>
      <div>
        {include file="comments/box.tpl" type="v" id_content=$video->getId()}
      </div>
    </div>
    {/if}

  </div>

  <div class="col-1">

    <div class="box">
      <header>
        <h2>Partager cette vidéo</h2>
      </header>
      <div>
        {include file="comments/share.tpl" title="" url=$video->getUrl()}
      </div>
    </div>

    {if !empty($groupe)}
    <div class="box">
      <header>
        <h2>Groupe</h2>
      </header>
      <div class="metacontent">
        <a href="{$groupe->getUrl()}"><img style="float: right;" src="{$groupe->getMiniPhoto()}" alt=""><strong>{$groupe->getName()|escape}</strong></a>
      </div>
    </div>
    {/if}

    {if !empty($event)}
    <div class="box">
      <header>
        <h2>Événement</h2>
      </header>
      <div class="metacontent">
        <a href="{$event->getUrl()}"><img style="float: right;" src="{$event->getFlyer100Url()}" alt=""><strong>{$event->getName()|escape}</strong></a><br>{$event->getDate()|date_format:'%d/%m/%Y'}
      </div>
    </div>
    {/if}

    {if !empty($lieu)}
    <div class="box">
      <header>
        <h2>Lieu</h2>
      </header>
      <div class="metacontent">
        <a href="{$lieu->getUrl()}"><img style="float: right;" src="{$lieu->getMapUrl('64x64')}" alt=""><strong>{$lieu->getName()|escape}</strong></a><br>{$lieu->getAddress()}<br>{$lieu->getCp()} {$lieu->getCity()|escape}
      </div>
    </div>
    {/if}

    {if !empty($videos) || !empty($photos)}
    <div class="box">
      <header>
        <h2>Du même concert</h2>
      </header>
      <div>
        {foreach $videos as $vid}
        {if $vid.id != $video->getId()}
        <div class="thumb-80">
          <a href="{$vid.url}"><img src="{$vid.thumb_80_80}" alt="{$vid.name|escape}"><br>{$vid.name|truncate:15:"...":true:true|escape}</a>
          <a class="overlay-80 overlay-video-80" href="{$vid.url}" title="{$vid.name|escape}"></a>
        </div>
        {/if}
        {/foreach}
        {foreach $photos as $pho}
        <div class="thumb-80">
          <a href="{$pho.url}"><img src="{$pho.thumb_80_80}" alt="{$pho.name|escape}"><br>{$pho.name|truncate:15:"...":true:true|escape}</a>
          <a class="overlay-80 overlay-photo-80" href="{$pho.url}" title="{$pho.name|escape}"></a>
        </div>
        {/foreach}
      </div>
    </div>
    {/if}

  </div>

</div>

{/if} {* test unknown video *}

{include file="common/footer.tpl"}
