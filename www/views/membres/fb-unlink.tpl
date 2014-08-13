{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Délier un profil Facebook de votre compte AD'HOC"}

{if !empty($err_unlink)}

<p class="error">Votre compte AD'HOC n'est lié à aucun profil Facebook</p>

{elseif !empty($fb_me)}

<p class="validation">Voulez vous délier votre compte AD'HOC du profil Facebook suivant ?</p>

<p align="center">
  <img src="{$fb_me->avatar}" alt="{$fb_me->name|escape}" /><br />
  <strong>{$fb_me->first_name|escape} {$fb_me->last_name|escape}</strong>
</p>

<form id="form-fb-unlink" name="form-fb-unlink" action="/membres/fb-unlink" method="post">
  <input type="submit" class="button" id="form-fb-unlink-submit" name="form-fb-unlink-submit" value="Délier" />
</form>

{else}

<p class="error">Vote compte AD'HOC semble lié à un profil Facebook mais récupération des infos impossible</p>

{/if}

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
