{include file="common/header.tpl"}

{if !empty($unknown_comment)}

<p class="error">Ce commentaire est introuvable !</p>

{else}

{include file="common/boxstart.tpl" boxtitle="Commentaire"}

<table>
  <tr>
    <th>Id</th>
    <td>{$comment->getId()}</td>
  </tr>
  <tr>
    <th>Texte</th>
    <td>{$comment->getText()|@nl2br}</td>
  </tr>
</table>

{include file="common/boxend.tpl"}

{/if} {* test unknown comment *}

{include file="common/footer.tpl"}
