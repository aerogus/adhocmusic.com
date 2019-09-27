{include file="common/header.tpl"}

<div class="box" style="width: 215px; margin: 0 auto 20px">
  <header>
    <h2>Newsletter</h2>
  </header>
  <div>
{if !empty($form)}
<form id="form-newsletter" name="form-newsletter" action="/newsletters/subscriptions" method="post">
  <div>
    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="{$email}">
  </div>
  <div style="margin: 10px 0">
    <input type="radio" class="radio" name="action" value="sub" {if ($action == 'sub')} checked="checked"{/if}>
    <label for="sub" style="display:inline">Inscription</label>
  </div>
  <div style="margin: 10px 0">
    <input type="radio" class="radio" name="action" value="unsub" {if ($action == 'unsub')} checked="checked"{/if}>
    <label for="unsub" style="display:inline">Désinscription</label>
  </div>
  <div>
    <input class="button" type="submit" id="form-newsletter-submit" name="form-newsletter-submit" value="Valider">
  </div>
</form>
{/if}

{if !empty($error_email)}
<div class="infobulle error">Adresse email invalide</div>
{/if}

{if $ret == 'SUB-OK'}
<div class="infobulle success">L'email <strong>{$email|escape}</strong> a bien été inscrite à la liste des abonnés de la newsletter AD'HOC. Merci et bienvenue ! :)</div>
{elseif $ret == 'SUB-KO'}
<div class="infobulle error">L'email <strong>{$email|escape}</strong> est déjà inscrite à la liste des abonnés de la newsletter AD'HOC.</div>
{elseif $ret == 'UNSUB-OK'}
<div class="infobulle success">L'email <strong>{$email|escape}</strong> a bien été désinscrite de la liste des abonnés de la newsletter AD'HOC. Au revoir :(</div>
{elseif $ret == 'UNSUB-KO'}
<div class="infobulle error">L'email <strong>{$email|escape}</strong> n'est pas inscrite à la newsletter AD'HOC.</div>
{/if}

  </div>
</div>

{include file="common/footer.tpl"}
