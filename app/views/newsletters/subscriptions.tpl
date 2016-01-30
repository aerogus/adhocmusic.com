{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Gestion de l'abonnement à la Newsletter AD'HOC"}

{if !empty($form)}
<form id="form-newsletter" name="form-newsletter" action="/newsletters/subscriptions" method="post">
  <ol>
    <li>
      <label for="email">Email</label>
      <input type="text" id="email" name="email" value="{$email}">
    </li>
    <li>
      <label for="action">Action</label>
      <select id="action" name="action">
        <option value="sub" {if ($action=='sub')} selected="selected"{/if}>Inscription</option>
        <option value="unsub" {if ($action=='unsub')} selected="selected"{/if}>Désinscription</option>
      </select>
    </li>
    <li>
      <input type="submit" id="form-newsletter-submit" name="form-newsletter-submit" value="Valider">
    </li>
  </ol>
</form>
{/if}

{if !empty($error_email)}
<div class="error">Adresse email invalide</div>
{/if}

{if $ret == 'SUB-OK'}
<div class="success">L'email <strong>{$email|escape}</strong> a bien été inscrite à la liste des abonnés de la newsletter AD'HOC. Merci et bienvenue ! :)</div>
{elseif $ret == 'SUB-KO'}
<div class="error">L'email <strong>{$email|escape}</strong> est déjà inscrite à la liste des abonnés de la newsletter AD'HOC.</div>
{elseif $ret == 'UNSUB-OK'}
<div class="success">L'email <strong>{$email|escape}</strong> a bien été désinscrite de la liste des abonnés de la newsletter AD'HOC. Au revoir :(</div>
{elseif $ret == 'UNSUB-KO'}
<div class="error">L'email <strong>{$email|escape}</strong> n'est pas inscrite à la newsletter AD'HOC.</div>
{/if}

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
