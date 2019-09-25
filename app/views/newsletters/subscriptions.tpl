{include file="common/header.tpl"}

<div class="box" style="width: 215px; margin: 0 auto 20px">
  <header>
    <h2>Abonnement à la newsletter</h2>
  </header>
  <div>
{if !empty($form)}
<form id="form-newsletter" name="form-newsletter" action="/newsletters/subscriptions" method="post">
  <label for="email">Email</label>
  <input type="email" id="email" name="email" value="{$email}">
  <label for="action">Action</label>
  <select id="action" name="action">
    <option value="sub" {if ($action == 'sub')} selected="selected"{/if}>Inscription</option>
    <option value="unsub" {if ($action == 'unsub')} selected="selected"{/if}>Désinscription</option>
  </select>
  <input class="button" type="submit" id="form-newsletter-submit" name="form-newsletter-submit" value="Valider">
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
