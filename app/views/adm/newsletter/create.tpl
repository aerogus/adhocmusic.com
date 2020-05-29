{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Ajout Newsletter</h1>
  </header>
  <div>
    <form id="form-newsletter-create" name="form-newsletter-create" method="post" action="/adm/newsletter/create">
      <fieldset>
        <label for="title">Titre</label>
        <input type="text" id="title" name="title" size="50" value="{$data.title|escape}">
        <label for="content">Contenu</label>
        <textarea id="content" name="content">{$data.content|escape}</textarea>
      </fieldset>
      <input id="form-newsletter-create-submit" name="form-newsletter-create-submit" class="btn btn--primary" type="submit" value="Ok">
    </form>
  </div>
</div>

{include file="common/footer.tpl"}
