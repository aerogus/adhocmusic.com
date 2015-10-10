{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Commentaires"}

<form id="form-comments-delete" id="form-comments-delete">

<table>
  <thead>
    <tr>
      <th>X</th>
      <th>Id</th>
      <th>Contenu</th>
      <th>Créé</th>
      <th>Online</th>
      <th>Anonyme</th>
      <th>Membre</th>
      <th>Texte</th>
    </tr>
  </thead>
  <tbody>
  {foreach from=$comments item=comment}
    <tr id="row-{$comment.id}">
      <td><input type="checkbox" id="com-del-{$comment.id}" /></td>
      <td><a href="/comments/show/{$comment.id}">{$comment.id}</a></td>
      <td><a href="/{$comment.type_full}/show/{$comment.id_content}">{$comment.type} {$comment.id_content}</a></td>
      <td>{$comment.created_on}</td>
      <td>{$comment.online}</td>
      <td>{$comment.pseudo}<br />{$comment.email}</td>
      <td><a href="/membres/show/{$comment.id_contact}">{$comment.pseudo_mbr}</a><br />{$comment.email_mbr}</td>
      <td>{$comment.text|@nl2br}</td>
    </tr>
  {/foreach}
  </tbody>
</table>

<input name="form-comments-delete-submit" id="form-comments-delete-submit" type="submit" value="Effacer sélectionnés" />

</form>

<script>
$(function() {
  $("#form-comments-delete").submit(function(event) {
    $("#sablier").show();
    event.preventDefault();
    var checked = $(this).find('input:checked');
    var ids = checked.map(function() {
      var id = this.id.replace('com-del-', '');
      $.post('/comments/ajax-delete', { id: id }, function(data) {
        $("#row-" + id).hide();
      });
    });
    $("#sablier").hide();
  });
});
</script>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
