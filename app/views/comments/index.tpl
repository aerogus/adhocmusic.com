{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Commentaires</h1>
  </header>
  <div>

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
  {foreach $comments as $comment}
    <tr id="row-{$comment->getIdComment()}">
      <td><input type="checkbox" id="com-del-{$comment->getIdComment()}"></td>
      <td><a href="/comments/show/{$comment->getIdComment()}">{$comment->getIdComment()}</a></td>
      <td><a href="/{$comment.type_full}/{$comment.id_content}">{$comment.type} {$comment.id_content}</a></td>
      <td>{$comment->getCreatedAt()}</td>
      <td>{$comment->getOnline()}</td>
      <td>{$comment->getPseudo()}<br>{$comment->getEmail()}</td>
      <td><a href="/membres/show/{$comment->getIdCcontact()}">{$comment->getPseudo()}</a><br>{$comment->getEmail()}</td>
      <td>{$comment->getText()|@nl2br}</td>
    </tr>
  {/foreach}
  </tbody>
</table>

<input name="form-comments-delete-submit" id="form-comments-delete-submit" type="submit" value="Effacer sélectionnés">

</form>

  </div>
</div>

{include file="common/footer.tpl"}
