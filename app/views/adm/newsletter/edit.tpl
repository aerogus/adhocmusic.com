{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Edition Newsletter"}

<form id="form-newsletter-edit" name="form-newsletter-edit" method="post" action="/adm/newsletter/edit">
  <fieldset>
    <label for="title">Titre</label>
    <input type="text" id="title" name="title" size="50" value="{$newsletter->getTitle()|escape}" />
    <label for="content">Contenu (<a href="/emails/newsletter/{$newsletter->getId()}">Preview Web</a>)</label>
    <textarea style="font-size: 0.9em; background: #ccc; color: #000; width: 900px; height: 1200px;" id="content" name="content">{$newsletter->getRawContent()|escape}</textarea>
  </fieldset>
  <input id="form-newsletter-edit-submit" name="form-newsletter-edit-submit" class="button" type="submit" value="Ok" />
  <input type="hidden" name="id" value="{$newsletter->getId()|escape}" />
</form>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}