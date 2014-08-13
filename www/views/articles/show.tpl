{include file="common/header.tpl"}

<div id="right">
{include file="common/boxstart.tpl" boxtitle="Participez"}
<p>Envie d'écrire des articles sur ce site ? Rejoignez-nous en tant que rédacteur ! Pour cela, <a href="/contact">contactez-nous</a></p>
{include file="common/boxend.tpl"}
</div>

<div id="left-center">

{if !empty($unknown_article)}

<p class="error">Cet article est introuvable !</p>

{elseif !$article->getOnline()}

<p class="error">Cet article n'est pas en ligne!</p>

{else}

{include file="common/boxstart.tpl" boxtitle="{$article->getTitle()}"}

<div class="art">
  <p>Posté par <a href="/membres/show/{$article->getIdContact()}">{$article->getPseudo()}</a> le {$article->getCreatedOn()|date_format:"%A %e %B %Y"}</p>
  <div class="artbody">{$article->getText()}</div>
  <div class="artfoot"></div>
</div>

{include file="comments/share.tpl" title="cet article" url=$article->getUrl()}

{include file="comments/box.tpl" type="a" id_content=$article->getId()}

{include file="common/boxend.tpl"}

{/if} {* test unknown article *}

</div>

{include file="common/footer.tpl"}
