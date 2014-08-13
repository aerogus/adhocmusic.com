{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Jeux Concours"}

<div class="fb-share-box">
<a class="fb-share-link" href="http://www.facebook.com/sharer/sharer.php?u={$concours->getUrl()|escape:'url'}">Partager</a>
<fb:like style="margin-left: 74px;" href="{$concours->getUrl()}" show_faces="false" width="600" font="arial" send="true"></fb:like>
</div>

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

{if !empty($show_form)}

<script>
$(function() {
  $("#jouer").hide();
  $("#form-concours-play").submit(function() {
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

<form id="form-concours-play" name="form-concours-play" method="post" action="/concours/play">

{foreach from=$concours->getQr() item=qr name=qr}
<div id="qr{$smarty.foreach.qr.iteration}" class="qr">
  <div class="error" id="error_qr{$smarty.foreach.qr.iteration}" style="display: none;">Vous devez répondre à la question {$smarty.foreach.qr.iteration}</div>
  <p class="round-corner-all">{$smarty.foreach.qr.iteration}. {$qr.q|escape}</p>
  {if !empty($qr.image)}<img src="{$qr.image}" alt="" />{/if}
  <ol>
    {if !empty($qr.r1)}<li><input type="radio" name="q{$smarty.foreach.qr.iteration}" value="1" />{$qr.r1|escape}</li>{/if}
    {if !empty($qr.r2)}<li><input type="radio" name="q{$smarty.foreach.qr.iteration}" value="2" />{$qr.r2|escape}</li>{/if}
    {if !empty($qr.r3)}<li><input type="radio" name="q{$smarty.foreach.qr.iteration}" value="3" />{$qr.r3|escape}</li>{/if}
    {if !empty($qr.r4)}<li><input type="radio" name="q{$smarty.foreach.qr.iteration}" value="4" />{$qr.r4|escape}</li>{/if}
    {if !empty($qr.r5)}<li><input type="radio" name="q{$smarty.foreach.qr.iteration}" value="5" />{$qr.r5|escape}</li>{/if}
  </ol>
</div>
{/foreach}

<input type="hidden" name="id" value="{$concours->getId()|escape}" />
<input type="submit" id="form-concours-play-submit" name="form-concours-play-submit" class="inputsubmit" value="Valider" />

</form>

{/if}

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
