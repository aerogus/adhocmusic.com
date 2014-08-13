{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Supprimer un Article"}

<form id="form-article-delete" name="form-article-delete" action="/articles/delete" method="post">
  <strong>Titre : </strong>{$article->getTitle()|escape}<br />
  <input type="hidden" name="id" value="{$article->getId()}" />
  <input id="form-article-delete-submit" name="form-article-delete-submit" type="submit" value="Supprimer" />
</form>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
