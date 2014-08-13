{include file="common/header.tpl" swfobject=true}

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

<div id="right">

{include file="common/boxstart.tpl" boxtitle="Partager cette vidéo"}
{include file="comments/share.tpl" title="" url=$video->getUrl()}
{include file="common/boxend.tpl"}

{if !empty($groupe)}
{include file="common/boxstart.tpl" boxtitle="Groupe"}
<div class="metacontent">
  <a href="{$groupe->getUrl()}"><img style="float: right;" src="{$groupe->getMiniPhoto()}" alt="" /><strong>{$groupe->getName()|escape}</strong></a>
</div>
{include file="common/boxend.tpl"}
{/if}

{if !empty($event)}
{include file="common/boxstart.tpl" boxtitle="Evénement"}
<div class="metacontent">
  <a href="{$event->getUrl()}"><img style="float: right;" src="{$event->getFlyer100Url()}" alt="" /><strong>{$event->getName()|escape}</strong></a><br />{$event->getDate()|date_format:'%d/%m/%Y'}
</div>
{include file="common/boxend.tpl"}
{/if}

{if !empty($lieu)}
{include file="common/boxstart.tpl" boxtitle="Lieu"}
<div class="metacontent">
  <a href="{$lieu->getUrl()}"><img style="float: right;" src="{$lieu->getMapUrl('64x64')}" alt="" /><strong>{$lieu->getName()|escape}</strong></a><br />{$lieu->getAddress()}<br />{$lieu->getCp()} {$lieu->getCity()|escape}
</div>
<br style="clear: both;" />
{include file="common/boxend.tpl"}
{/if}

{if !empty($videos) || !empty($photos)}
{include file="common/boxstart.tpl" boxtitle="Du même concert"}
{foreach from=$videos item=vid}
<div class="thumb-80">
  <a href="{$vid.url}"><img src="{$vid.thumb_80_80}" alt="{$vid.name|escape}" /><br />{$vid.name|truncate:15:"...":true:true|escape}</a>
  <a class="overlay-80 overlay-video-80" href="{$vid.url}" title="{$vid.name|escape}"></a>
</div>
{/foreach}
{foreach from=$photos item=pho}
<div class="thumb-80">
  <a href="{$pho.url}"><img src="{$pho.thumb_80_80}" alt="{$pho.name|escape}" /><br />{$pho.name|truncate:15:"...":true:true|escape}</a>
  <a class="overlay-80 overlay-photo-80" href="{$pho.url}" title="{$pho.name|escape}"></a>
</div>
{/foreach}
{include file="common/boxend.tpl"}
{/if}

</div>

<div id="left-center">

<div class="boxtitle">{$video->getName()|escape}</div>
{$video->getPlayer(true)}
<br />
<br />

{include file="common/boxstart.tpl" boxtitle="Commentaires"}
{include file="comments/box.tpl" type="v" id_content=$video->getId()}
{include file="common/boxend.tpl"}

</div>

{/if} {* test unknown video *}

{include file="common/footer.tpl"}
