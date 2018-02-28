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
        <label for="content">Contenu (<a href="{$newsletter->getUrl()}">Preview Web</a>)</label>
        <textarea id="content" name="content">{$newsletter->getContent()|escape}</textarea>
      </fieldset>
      <input id="form-newsletter-edit-submit" name="form-newsletter-edit-submit" class="button" type="submit" value="Ok">
      <input type="hidden" name="id" value="{$newsletter->getId()|escape}">
    </form>

    <p>Uploader un fichier pour cette newsletter</p>
    <form id="form-newsletter-edit-upload" name="form-newsletter-edit-upload" method="post" action="/adm/newsletter/upload" enctype="multipart/form-data">
      <input type="file" name="file">
      <input type="submit" id="form-newsletter-edit-upload-submit" value="Envoyer">
      <input type="hidden" name="id" value="{$newsletter->getId()|escape}">
    </form>

    <p><a href="/newsletters/{$newsletter->getId()|escape}" target="_blank">Prévisualiser</a></p>
  </div>
</div>

{include file="common/footer.tpl"}
