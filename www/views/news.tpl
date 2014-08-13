{include file="common/header.tpl"}

{if !empty($unknown_news)}
 
<p class="error">News introuvable</p>

{else}

<div id="left-center">
{include file="common/boxstart.tpl" boxtitle="{$news->getTitle()}" boxtitle2=$news->getCreatedOn()|date_format:'%d/%m/%Y'}
{$news->getText()}
{*
<p align="center">[ <img src="{#STATIC_URL#}/img/icones/comments.png" alt="" /><a href="javascript:;">Lire{+t}</a> (0 commentaire(s)) ] [ <img src="{#STATIC_URL#}/img/icones/comment_add.png" alt="" /><a href="javascript:;">Ajouter</a> ]</p>
*}
{include file="common/boxend.tpl"}
</div>

<div id="right">
{include file="common/boxstart.tpl" boxtitle="Dernières News"}
<ul>
{foreach from=$newslist item=new}
  <li style="margin-bottom: 5px;"><a href="/news/{$new.id}" title="{$new.title|escape}"><strong>{$new.title|truncate:'50'|escape}</strong></a><br /><em>{$new.created_on|date_format:"%a. %d %B %Y"}</em></li>
{/foreach}
</ul>
{include file="common/boxend.tpl"}
</div>

{/if} {* test unknown news *}

{include file="common/footer.tpl"}
