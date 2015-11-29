{include file="common/header.tpl"}

{if !empty($unknown_video)}

<p class="error">Cette vidéo est introuvable !</p>

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

<div id="left">

{include file="common/boxstart.tpl" width="200px"}
{if !empty($groupe)}
<div class="metatop">Groupe</div>
<div class="metacontent">
  <a href="{$groupe->getUrl()}"><img style="float: right;" src="{$groupe->getMiniPhoto()}" alt=""><strong>{$groupe->getName()|escape}</strong></a>
</div>
<br style="clear: both;">
{/if}
{if !empty($event)}
<div class="metatop">Evénement</div>
<div class="metacontent">
  <a href="{$event->getUrl()}"><img style="float: right;" src="{$event->getFlyer100Url()}" alt=""><strong>{$event->getName()|escape}</strong></a><br>{$event->getDate()|date_format:'%d/%m/%Y'}
</div>
<br style="clear: both;">
{/if}
{if !empty($lieu)}
<div class="metatop">Lieu</div>
<div class="metacontent">
  <a href="{$lieu->getUrl()}"><img style="float: right;" src="{$lieu->getMapUrl('64x64')}" alt=""><strong>{$lieu->getName()|escape}</strong></a><br>{$lieu->getAddress()}<br>{$lieu->getCp()} {$lieu->getCity()|escape}
</div>
<br style="clear: both;">
{/if}
{include file="common/boxend.tpl"}

</div>

<div id="center-right">

{include file="common/boxstart.tpl" boxtitle=$video->getName()|escape width="700px"}

<div style="margin: 10px auto; {if $video->getIdHost() != 7} width: 640px; height: 480px;{/if} background-color: #000; box-shadow: 0px 0px 10px #666;">{$video->getPlayer(true)}</div>

<div class="fb-share-box">
<a class="fb-share-link" href="http://www.facebook.com/sharer/sharer.php?u={$video->getUrl()|escape:'url'}">Partager</a>
<fb:like style="margin-left: 74px;" href="{$video->getUrl()}" show_faces="false" width="600" font="arial" send="true"></fb:like>
</div>

{*
<fb:comments href="{$video->getUrl()}" num_posts="2" width="680"></fb:comments>
*}

{include file="comments/box.tpl" type="v" id_content=$video->getId()}

{if !empty($videos) || !empty($photos)}
<p>Du même concert :</p>
{foreach from=$videos item=vid}
<div class="thumb-80">
  <a href="{$vid.url}"><img src="{$vid.thumb_80_80}" alt="{$vid.name|escape}"></a>
  <a class="overlay-80 overlay-video-80" href="{$vid.url}" title="{$vid.name|escape}"></a>
</div>
{/foreach}
{foreach from=$photos item=pho}
<div class="thumb-80">
  <a href="{$pho.url}"><img src="{$pho.thumb_80_80}" alt="{$pho.name|escape}"></a>
  <a class="overlay-80 overlay-photo-80" href="{$pho.url}" title="{$pho.name|escape}"></a>
</div>
{/foreach}
{/if}

{include file="common/boxend.tpl"}

{if $video->getIdHost() == 7}
<script>
$(function() {
  $('#embed-button').click(function() {
    $('#embed').fadeIn();
  });
});
</script>
<p class="button" id="embed-button">Intégrer</p>
<textarea id="embed" style="display: none; font-size: 10px; width: 400px; height: 100px; font-family: courier;">
{*<iframe src="http://www.adhocmusic.com/videos/embed/{$video->getId()}" width="{$video->getWidth()}" height="{$video->getHeight()}" frameborder="0"></iframe>*}
<embed flashvars="file={$video->getDirectUrl()}" allowfullscreen="true" allowscripaccess="always" id="adhocmusic-video-player" name="adhocmusic-video-player" src="https://www.adhocmusic.com/jwplayer/player.swf" width="{$video->getHeight()}" height="{$video->getHeight()}">
<p><a href="https://www.adhocmusic.com/videos/show/{$video->getId()}"><strong>{$video->getName()}</strong></a>{if !empty($groupe)} | Groupe : <a href="{$groupe->getUrl()}">{$groupe->getName()}</a>{/if}{if !empty($event)} | Evénement : <a href="{$event->getUrl()}">{$event->getName()}</a>{/if}{if !empty($lieu)} | Lieu : <a href="{$lieu->getUrl()}">{$lieu->getName()}</a>{/if} | Hébergement : <a href="http://www.adhocmusic.com">AD'HOC</a>.</p>
</textarea>
{/if}
</div>

{/if} {* test unknown video *}

{include file="common/footer.tpl"}
