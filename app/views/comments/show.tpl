{include file="common/header.tpl"}

{if !empty($unknown_comment)}

<p class="infobulle error">Ce commentaire est introuvable !</p>

{else}

<div class="box">
  <header>
    <h1>Commentaire</h1>
  </header>
  <div>

<table>
  <tr>
    <th>Id</th>
    <td>{$comment->getIdComment()}</td>
  </tr>
  <tr>
    <th>Texte</th>
    <td>{$comment->getText()|@nl2br}</td>
  </tr>
</table>

  </div>
</div>

{/if} {* test unknown comment *}

{include file="common/footer.tpl"}
