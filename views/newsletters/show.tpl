{include file="common/header.tpl"}

{if !empty($unknown_newsletter)}

<p class="error">Cette newsletter est introuvable !</p>

{else}

<div id="newsletter">
<div id="newsletterbody">

<div class="fb-share-box">
<a class="fb-share-link" href="http://www.facebook.com/sharer/sharer.php?u={$newsletter->getUrl()|escape:'url'}">Partager</a>
<fb:like style="margin-left: 74px;" href="{$newsletter->getUrl()}" show_faces="false" width="600" font="arial" send="true"></fb:like>
</div>

{$newsletter->getBodyHtml()}

</div>
</div>

{/if} {* test unknown newsletter *}

{include file="common/footer.tpl"}
