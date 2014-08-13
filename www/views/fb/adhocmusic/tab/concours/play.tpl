{include file="fb/adhocmusic/tab/common/header.tpl"}

{include file="fb/adhocmusic/tab/common/boxstart.tpl" boxtitle="Jeux Concours"}

{if !empty($error)}
  {if $error == 'already_played'}
    <div class="error">Désolé vous avez déjà joué à ce jeu</div>
  {else}
    <div class="error">Erreur inconnue</div>
  {/if}
{/if}

{if !empty($show_congrats)}
  <div class="success">Votre participation a été enregistrée, merci d'avoir joué !<br />Rendez vous à la fin du jeu pour découvrir la liste des gagnants.</div>
{/if}

{if empty($member)}

<div class="error">Vous devez avoir un compte adhoc valide sur adhocmusic.com et le lier à votre compte facebook pour pouvoir participer aux jeux concours</div>

{elseif !empty($show_form)}

<script>
$(function() {
  $("#jouer").hide();
  $("#form-concours").submit(function() {
    var valid = true;
    var radioName = 'q1';
    $(".qr").each(function() {
      var iteration = $(this).attr('id').replace('qr', '');
      if($('input[name=q' + iteration + ']:checked').length == 0) {
        valid = false;
        $("#error_qr" + iteration).fadeIn();
      } else {
        $("#error_qr" + iteration).fadeOut();
      }
    });
    return valid;
  });
});
</script>

{$concours->getDescription()}

<form id="form-concours" name="form-concours" method="post" action="/fb/adhocmusic/tab/concours/play">

{foreach from=$concours->getQr() item=qr name=qr}
<div id="qr{$smarty.foreach.qr.iteration}" class="qr">
  <div class="error" id="error_qr{$smarty.foreach.qr.iteration}" style="display: none;">Vous devez répondre à la question {$smarty.foreach.qr.iteration}</div>
  <p class="round-corner-all">{$smarty.foreach.qr.iteration}. {$qr.q|escape}</p>
  {if !empty($qr.image)}<img src="{$qr.image}" alt="" />{/if}
  <ol>
    <li><input type="radio" name="q{$smarty.foreach.qr.iteration}" value="1" />{$qr.r1|escape}</li>
    <li><input type="radio" name="q{$smarty.foreach.qr.iteration}" value="2" />{$qr.r2|escape}</li>
    <li><input type="radio" name="q{$smarty.foreach.qr.iteration}" value="3" />{$qr.r3|escape}</li>
    <li><input type="radio" name="q{$smarty.foreach.qr.iteration}" value="4" />{$qr.r4|escape}</li>
    <li><input type="radio" name="q{$smarty.foreach.qr.iteration}" value="5" />{$qr.r5|escape}</li>
  </ol>
</div>
{/foreach}

<input type="hidden" name="id" value="{$concours->getId()|escape}" />
<input type="submit" class="button inputsubmit" value="Valider" />

</form>

{/if}

{include file="fb/adhocmusic/tab/common/boxend.tpl"}

</div>

{include file="fb/adhocmusic/tab/common/footer.tpl"}
