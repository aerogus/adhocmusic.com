{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Jeux Concours"}

<div class="fb-share-box">
<a class="fb-share-link" href="http://www.facebook.com/sharer/sharer.php?u={$concours->getUrl()|escape:'url'}">Partager</a>
<fb:like style="margin-left: 74px;" href="{$concours->getUrl()}" show_faces="false" width="600" font="arial" send="true"></fb:like>
</div>

{$concours->getDescription()}

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
