{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Édition Newsletter</h1>
  </header>
  <div>
<form id="form-newsletter-edit" name="form-newsletter-edit" method="post" action="/adm/newsletter/edit">
  <fieldset>
    <label for="title">Titre</label>
    <input type="text" id="title" name="title" size="50" value="{$newsletter->getTitle()|escape}">
    <label for="content">Contenu (<a href="/newsletters/{$newsletter->getId()}">Preview Web</a>)</label>
    <textarea style="font-size: 0.9em; background: #ccc; color: #000; width: 900px; height: 1200px;" id="content" name="content">{$newsletter->getContent()|escape}</textarea>
  </fieldset>
  <input id="form-newsletter-edit-submit" name="form-newsletter-edit-submit" class="button" type="submit" value="Ok">
  <input type="hidden" name="id" value="{$newsletter->getId()|escape}">
</form>
  </div>
</div>

{include file="common/footer.tpl"}
