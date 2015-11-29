<script>
$(function () {
  $("#form-comment-box-write").submit(function () {
    var valid = true;
{if empty($is_auth)}
    if ($("#form-comment-box-pseudo").val() == "") {
      $("#error_pseudo").fadeIn();
      valid = false;
    } else {
      $("#error_pseudo").fadeOut();
    }
    if ($("#form-comment-box-email").val() == "") {
      $("#error_email").fadeIn();
      valid = false;
    } else {
      $("#error_email").fadeOut();
    }
    if ($("#form-comment-box-antispam").val() != "oui") {
      $("#error_antispam").fadeIn();
      valid = false;
    } else {
      $("#error_antispam").fadeOut();
    }
{/if}
    if ($("#form-comment-box-text").val() == "") {
      $("#error_text").fadeIn();
      valid = false;
    } else {
      $("#error_text").fadeOut();
    }
    return valid;
  });
});
</script>

<style>
#comment-box {
    wwidth: 500px;
}
#comment-box input, #comment-box textarea {
    width: 300px;
}
#comment-box textarea {
    height: 150px;
}
#comment-box input[type=submit] {
    width: 90px;
    margin-left: 120px;
}
#comment-box label {
    float: left;
    margin-right: 30px;
    margin-top: 5px;
    width: 90px;
}
#comment-box li {
    margin: 5px;
}
#comments .comment {
    margin: 5px;
    padding: 10px;
}
#comments .odd {
    background-color: #ececec;
    border: 1px solid #cecece;
}
#comments .even {
    background-color: #cecece;
    border: 1px solid #acacac;
}
#comments .odd:hover {
    border: 1px solid #333333;
}
#comments .even:hover {
    border: 1px solid #333333;
}
</style>

<div id="comments">

{if !empty($comments)}
<h4>Commentaires</h4>
{foreach from=$comments key=cpt item=comment}
<div class="comment {if $cpt is odd}odd{else}even{/if}" style="position: relative; min-height: 70px;">
{if !empty($comment.id_contact)}
  <div style="position: absolute;">
  <a href="/membres/show/{$comment.id_contact}">
  <strong>{$comment.pseudo_mbr}</strong><br />
  <img src="{$comment.id_contact|avatar_by_id}" alt="" style="width: 50px; height: 50px; padding-top: 5px;" />
  </a>
  </div>
  <span style="float: right;">{$comment.created_on|date_format:'le %d/%m/%Y à %H:%M'}</span>
{else}
  <div style="float: left;">
  <strong>{$comment.pseudo|escape}</strong>
  </div>
  <span style="float: right;">{$comment.created_on|date_format:'%d/%m/%Y à %H:%M'}</span>
{/if}
<p style="padding-left: 115px;">{$comment.text|escape|@nl2br}</p>
</div>
{/foreach}
{/if}
</div>

<div id="comment-box">
<h4>Commenter</h4>
<form id="form-comment-box-write" name="form-comment-box-write" action="/comments/create" method="POST">
  <ol>
    {if !empty($is_auth)}
    <li style="min-height: 50px;">
      <label for="form-comment-box-pseudo">Pseudo</label>
      <img src="{$me->getAvatar()|escape}" alt="" style="padding-right: 5px; float: left; width: 50px; height: 50px;"> <strong>{$me->getPseudo()|escape}</strong><br />({$me->getFirstName()} {$me->getLastName()})
    </li>
    {else}
    <li>
      <p>Vous pouvez <a href="/auth/login">vous identifier</a> pour poster ce commentaire. <a href="/membres/create">Pas encore de compte ?</a></p>
    </li>
    <li>
      <div class="error" id="error_pseudo"{if empty($error_pseudo)} style="display: none"{/if}>Vous devez écrire votre pseudonyme.</div>
      <label for="form-comment-box-pseudo">Pseudo</label>
      <input type="text" id="form-comment-box-pseudo" name="pseudo">
    </li>
    <li>
      <div class="error" id="error_email"{if empty($error_email)} style="display: none"{/if}>Vous devez écrire votre email (elle ne sera pas publiée).</div>
      <label for="form-comment-box-email">Email</label>
      <input type="text" id="form-comment-box-email" name="email">
    </li>
    {/if}
    <li>
      <div class="error" id="error_text"{if empty($error_text)} style="display: none"{/if}>Vous devez écrire quelque chose.</div>
      <label for="form-comment-box-text">Texte</label>
      <textarea id="form-comment-box-text" name="text"></textarea>
    </li>
    {if empty($is_auth)}
    <li>
      <div class="error" id="error_antispam"{if empty($error_antispam)} style="display: none"{/if}>Mince vous semblez être un robot !</div>
      <label for="form-comment-box-antispam">Ecrivez "<strong>oui</strong>" si vous êtes un vrai humain</label>
      <input type="text" id="form-comment-box-antispam" name="antispam">
    </li>
    {/if}
    <li>
      <input type="submit" id="form-comment-box-write-submit" name="form-comment-box-write-submit" value="Envoyer">
      <input type="hidden" name="type" value="{$type|escape}">
      <input type="hidden" name="id_content" value="{$id_content|escape}">
    </li>
  </ol>
</form>
</div>
