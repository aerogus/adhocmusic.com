{include file="common/boxstart.tpl" boxtitle2="X" boxtitle="{if !empty($is_auth)}Mon Compte{else}Connexion{/if}" width="200px"}

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
  <li class="mbrcompte"><a href="/membres/edit/{$me->getId()}">Mon Compte</a></li>
  {if $my_counters.nb_groupes > 0}
  <li class="mbrgroupes"><a href="/groupes/my">Mes Groupes</a> ({$my_counters.nb_groupes})</li>
  {/if}
  {if $my_counters.nb_photos > 0}
  <li class="mbrphotos"><a href="/photos/my">Mes Photos</a> ({$my_counters.nb_photos})</li>
  {/if}
  {if $my_counters.nb_audios > 0}
  <li class="mbraudios"><a href="/audios/my">Mes Musiques</a> ({$my_counters.nb_audios})</li>
  {/if}
  {if $my_counters.nb_videos > 0}
  <li class="mbrvideos"><a href="/videos/my">Mes Vidéos</a> ({$my_counters.nb_videos})</li>
  {/if}
  {if $me->isRedacteur()}
  <li class="mbrarticles"><a href="/articles/my">Mes Articles</a> ({$my_counters.nb_articles})</li>
  {/if}
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

<form id="form-login" name="form-login" method="post" action="/auth/login-submit">
  <div class="error" id="error_login-pseudo"{if empty($error_login_pseudo)} style="display: none"{/if}>Pseudo vide !</div>
  <input size="18" type="text" id="login-pseudo" name="pseudo" placeholder="Pseudo" />
  <div class="error" id="error_login-password"{if empty($error_login_password)} style="display: none"{/if}>Password vide !</div>
  <input size="18" type="password" id="login-password" name="password" placeholder="Password" />
  <input type="submit" value="Ok" />
  {if !empty($referer)}<input type="hidden" id="login-referer" name="referer" value="{$referer|escape:'url'}" />{/if}
  <ul>
    <li><a href="/auth/lost-password">mot de passe oublié</a></li>
    <li><a href="/membres/create">s'inscrire</a></li>
  </ul>
</form>

{/if}

{include file="common/boxend.tpl"}
