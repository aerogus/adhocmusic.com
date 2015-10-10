{include file="common/boxstart.tpl" boxtitle="{if !empty($is_auth)}Tableau de bord{else}Connexion{/if}" boxtitle2="X" width="200px"}

{if !empty($is_auth)}

<p align="center">Bonjour <strong>{$me->getPseudo()|escape}</strong><br />
{if $my_counters.nb_unread_messages > 0}
  {if $my_counters.nb_unread_messages > 1}
      <br /><a href="/messagerie/">{$my_counters.nb_unread_messages} nouveaux messages</a><br />
  {else}
      <br /><a href="/messagerie/">1 nouveau message</a><br />
  {/if}
{/if}
</p>

<ul class="mbr">
  <li class="mbrmessagerie"><a href="/messagerie/">Ma Messagerie</a> (<strong>{$my_counters.nb_unread_messages}</strong>/{$my_counters.nb_messages})</li>
  <li class="mbralerting"><a href="/alerting/my">Mes Alertes</a></li>
  <li class="mbrcompte"><a href="/membres/edit/{$me->getId()}">Mes infos persos</a></li>
  <li class="mbrgroupes"><a href="/groupes/my">Mes Groupes</a></li>
  <li class="mbrphotos"><a href="/photos/my">Mes Photos</a></li>
  <li class="mbraudios"><a href="/audios/my">Mes Musiques</a></li>
  <li class="mbrvideos"><a href="/videos/my">Mes Vidéos</a></li>
  {if $me->isInterne()}
  <li class="mbradmin"><a href="/adm/">Zone Privée</a></li>
  {/if}
  <li class="mbrlogout"><a href="/auth/logout">Déconnexion</a></li>
</ul>

{else}

<script>
$(function() {
  $("#form-login").submit(function() {
    var valid = true;
    if($("#login-pseudo").val() == "") {
      $("#login-pseudo").prev(".error").fadeIn();
      valid = false;
    } else {
      $("#login-pseudo").prev(".error").fadeOut();
    }
    if($("#login-password").val() == "") {
      $("#login-password").prev(".error").fadeIn();
      valid = false;
    } else {
      $("#login-password").prev(".error").fadeOut();
    }
    return valid;
  });
});
</script>

<div style="padding: 5px;">
  <h5>Avec Facebook</h5>
  <div><a href="{$fb_login_url}"><img src="{#STATIC_URL#}/img/facebook-connect.png" alt="Connexion" /></a></div>
</div>

<div style="padding: 5px;">
  <h5>Avec AD'HOC</h5>
</div>

<form id="form-login" name="form-login" method="post" action="/auth/login">
  <div class="error" id="error_login-pseudo"{if empty($error_login_pseudo)} style="display: none"{/if}>Pseudo vide !</div>
  <input size="18" type="text" id="login-pseudo" name="pseudo" placeholder="Pseudo" />
  <div class="error" id="error_login-password"{if empty($error_login_password)} style="display: none"{/if}>Password vide !</div>
  <input size="18" type="password" id="login-password" name="password" placeholder="Password" />
  <input id="form-login-submit" name="form-login-submit" type="submit" value="Ok" />
  {if !empty($referer)}<input type="hidden" id="login-referer" name="referer" value="{$referer|escape:'url'}" />{/if}
  <ul>
    <li><a href="/auth/lost-password">mot de passe oublié</a></li>
    <li><a href="/membres/create">s'inscrire</a></li>
  </ul>
</form>

{/if}

{include file="common/boxend.tpl"}