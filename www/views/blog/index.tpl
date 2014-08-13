{include file="common/header.tpl"}

<a href="/blog/add?groupe={$groupe}" class="button">Ajout article</a>

{foreach from=$articles item=article}

<div class="blogarticle">
<div class="blogtitre"><strong>{$article.title|escape}</strong> par <strong>{$article.pseudo|escape}</strong> le {$article.date} [<a href="/blog/edit?groupe={$groupe}&amp;id={$article.id}">Editer</a>]</div>
<div class="blogcontent">{$article.text|escape}</div>
<p align="center">[ <img src="{#STATIC_URL#}/img/icones/comments.png" alt="" /><a href="javascript:;" onclick="toggleDiv('comart{$article.id}');">Lire</a> ({$article.nb_comments} commentaire(s)) ] [ <img src="{#STATIC_URL#}/img/icones/comment_add.png" alt="" /><a href="javascript:;" onclick="toggleDiv('comart{$article.id}');">Ajouter</a> ]</p>
<div id="comart{$article.id}" style="display:none">

{foreach from=$article.comments item=comment}
<p class="blogcommentaire"><strong>{$comment.pseudo|escape}</strong> le {$comment.date}<br />{$comment.text|escape}</p>
{/foreach}

<p align="center">Ajouter un commentaire</p>

<div align="center">
<form id="formcomart{$article.id|escape}" method="post" action="/blog/addcom">
<textarea name="text" rows="10" cols="40"></textarea>
<input type="hidden" name="groupe" value="{$groupe}" />
<input type="hidden" name="id_article" value="{$article.id}" />
<input id="blog-comart" name="blog-comart" type="submit" value="Ok" />
</form>
</div>

</div>
</div>

{/foreach}

{include file="common/footer.tpl"}
