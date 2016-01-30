{include file="common/boxstart.tpl" boxtitle="{if !empty($is_auth)}Tableau de bord{else}Connexion{/if}" boxtitle2="X" width="200px"}

{if !empty($is_auth)}

<p align="center">Bonjour <strong>{$me->getPseudo()|escape}</strong><br>
{if $my_counters.nb_unread_messages > 0}
  {if $my_counters.nb_unread_messages > 1}
      <br><a href="/messagerie/">{$my_counters.nb_unread_messages} nouveaux messages</a><br>
  {else}
      <br><a href="/messagerie/">1 nouveau message</a><br>
  {/if}
{/if}
</p>

<ul class="mbr">
  <li><a href="/messagerie/">Ma Messagerie</a> (<strong>{$my_counters.nb_unread_messages}</strong>/{$my_counters.nb_messages})</li>
  <li><a href="/alerting/my">Mes Alertes</a></li>
  <li><a href="/membres/edit/{$me->getId()}">Mes infos persos</a></li>
  <li><a href="/groupes/my">Mes Groupes</a></li>
  <li><a href="/photos/my">Mes Photos</a></li>
  <li><a href="/audios/my">Mes Musiques</a></li>
  <li><a href="/videos/my">Mes Vidéos</a></li>
  {if $me->isInterne()}
  <li><a href="/adm/">Zone Privée</a></li>
  {/if}
  <li><a href="/auth/logout">Déconnexion</a></li>
</ul>

{else}

<div style="padding: 5px;">
  <h5>Avec Facebook</h5>
  <div><a href="{$fb_login_url}"><img src="/img/facebook-connect.png" alt="Connexion"></a></div>
</div>

<div style="padding: 5px;">
  <h5>Avec AD'HOC</h5>
</div>

<form id="form-login" name="form-login" method="post" action="/auth/login">
  <div class="error" id="error_login-pseudo"{if empty($error_login_pseudo)} style="display: none"{/if}>Pseudo vide !</div>
  <input size="18" type="text" id="login-pseudo" name="pseudo" placeholder="Pseudo">
  <div class="error" id="error_login-password"{if empty($error_login_password)} style="display: none"{/if}>Password vide !</div>
  <input size="18" type="password" id="login-password" name="password" placeholder="Password">
  <input id="form-login-submit" name="form-login-submit" type="submit" value="Ok">
  {if !empty($referer)}<input type="hidden" id="login-referer" name="referer" value="{$referer|escape:'url'}">{/if}
  <ul>
    <li><a href="/auth/lost-password">mot de passe oublié</a></li>
    <li><a href="/membres/create">s'inscrire</a></li>
  </ul>
</form>

{/if}

{include file="common/boxend.tpl"}
