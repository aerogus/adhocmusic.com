{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Lier votre profil Facebook à votre compte AD'HOC"}

{if !empty($err_link)}

<p class="error">Votre compte AD'HOC est déjà lié à un profil Facebook.</p>

{elseif !empty($fb_me)}

<p class="validation">Voulez vous lier votre compte AD'HOC à ce profil Facebook ?</p>

<p align="center">
<img src="http://graph.facebook.com/{$fb_me->id}/picture" alt="" /><br />
Nom : <strong>{$fb_me->last_name|escape}</strong><br />
Prénom : <strong>{$fb_me->first_name|escape}</strong>
</p>

<form id="form-fb-link" name="form-fb-link" action="/membres/fb-link" method="post">
  <input type="submit" class="button" id="form-fb-link-submit" name="form-fb-link-submit" value="Lier" />
</form>

{else}

<p class="info">Identifiez vous sur Facebook afin de faire la liaison entre votre compte AD'HOC et votre profil Facebook</p>

<fb:login-button style="background-color: #fcfcfc;" show-faces="true" width="300" max-rows="2" perms="email,user_about_me"></fb:login-button>

{/if}

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
