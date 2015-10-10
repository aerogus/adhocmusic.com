{include file="common/header.tpl"}

<script>
$(function() {
  $("#form-comment-delete").submit(function() {
    var valid = true;
    return valid;
  });
});
</script>

{include file="common/boxstart.tpl" boxtitle="Effacer un commentaire"}

<form id="form-comment-delete" name="form-comment-delete" method="post" action="/comments/delete">
  <fieldset>
  <ol>
    <li>
      <label for="name">Nom</label>
      <textarea id="text" name="text" readonly="readonly">{$comment->getText()|escape}</textarea>
    </li>
  </ol>
  </fieldset>
  <input id="form-comment-delete-submit" name="form-comment-delete-submit" type="submit" value="Supprimer" />
  <input type="hidden" name="id" value="{$comment->getId()}" />
</form>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
