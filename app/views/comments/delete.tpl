{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Effacer un commentaire</h1>
  </header>
  <div>

<form id="form-comment-delete" name="form-comment-delete" method="post" action="/comments/delete">
  <fieldset>
  <ol>
    <li>
      <label for="name">Nom</label>
      <textarea id="text" name="text" readonly="readonly">{$comment->getText()|escape}</textarea>
    </li>
  </ol>
  </fieldset>
  <input id="form-comment-delete-submit" name="form-comment-delete-submit" type="submit" value="Supprimer">
  <input type="hidden" name="id" value="{$comment->getId()}">
</form>

  </div>
</div>

{include file="common/footer.tpl"}
