{include file="common/header.tpl"}

{if $me->isInterne()}
<div class="infobulle info"><a href="/adm">🔗 <strong>Accès zone privée</strong></a></div>
{/if}

<div class="grid-4-small-2-tiny-1 has-gutter">

  <div class="col-1">

  <div class="box">
    <header>
      <h2>Mes Infos Persos</h2>
    </header>
    <div>
      <ul>  
        <li>
          <strong style="float: right">{$me->getPseudo()|escape}</strong>
          <label for="pseudo">Pseudo</label>
        </li>
        <li>
          <span id="last_name" style="float: right;">{$me->getLastName()|escape}</span>
          <label for="last_name">Nom</label>
        </li>
        <li>
          <span id="first_name" style="float: right;">{$me->getFirstName()|escape}</span>
          <label for="first_name">Prénom</label>
        </li>
        <li>
          <span id="created_at" style="float: right">{$me->getCreatedAt()|date_format:"%d/%m/%Y"}</span>
          <label for="created_at">Inscription</label>
        </li>
        <li>
          <span id="modified_at" style="float: right">{$me->getModifiedAt()|date_format:"%d/%m/%Y"}</span>
          <label for="modified_at">Modification</label>
        </li>
        <li>
          <span id="visited_at" style="float: right">{$me->getVisitedAt()|date_format:"%d/%m/%Y"}</span>
          <label for="visited_at">Visite</label>
        </li>
        <li>
          <span style="float: right">
          <img src="{$me->getAvatarUrl()}" alt=""><br>
          </span>
          <label for="avatar">Avatar</label>
        </li>
      </ul>
      <p><a href="/membres/edit">Éditer mes infos persos</a></p>
      <p><a href="/auth/logout">Déconnexion</a></p>
    </div>
  </div>

  </div>

  <div class="col-2">

  <div class="box">
    <header>
      <h2>Messages reçus</h2>
    </header>
    <div>
      <table>
        <tr>
          <th>Lu</th>
          <th>De</th>
          <th>Date</th>
          <th>Message</th>
        </tr>
        {foreach from=$inbox key=cpt item=msg}
        <tr class="{if $cpt is odd}odd{else}even{/if}">
          <td><img src="/img/icones/{if !empty($msg.read_to)}email_open.png{else}email.png{/if}" alt=""></td>
          <td><a href="/messagerie/write?pseudo={$msg.pseudo|escape}">{$msg.pseudo|escape}</a></td>
          <td>{$msg.date|date_format:'%d/%m/%Y à %H:%M'}</td>
          <td><a href="/messagerie/read/{$msg.id|escape}">{$msg.text|truncate:40|escape}</a></td>
        </tr>
        {/foreach}
      </table>
      <p><a href="/messagerie">Tous mes messages</a></p>
    </div>
  </div>

  </div>

  <div class="col-1">

  <div class="box">
    <header>
      <h2>Mes alertes</h2>
    </header>
    <div>
      <h5>Groupes</h5>
      {if !empty($alerting_groupes)}
      <ul>
        {foreach $alerting_groupes as $groupe}
        <li><a href="{$groupe->getUrl()}">{$groupe->getName()}</a></li>
        {/foreach}
      </ul>
      {else}
      <p class="infobulle validation"">Aucun abonnement groupe</p>
      {/if}
      <h5>Évènements</h5>
      {if !empty($alerting_events)}
      <ul>
      {foreach $alerting_events as $event}
        <li><a href="{$event->getUrl()}">{$event->getName()}</a></li>
      {/foreach}
      </ul>
      {else}
      <p class="infobulle validation"">Aucun abonnement évènement</p>
      {/if}
      <h5>Lieux</h5>
      {if !empty($alerting_lieux)}
      <ul>
      {foreach $alerting_lieux as $lieu}
        <li><a href="{$lieu->getUrl()}">{$lieu->getName()}</a></li>
      {/foreach}
      </ul>
      {else}
      <p class="infobulle validation"">Aucun abonnement lieu</p>
      {/if}
      <p><a href="/alerting/my">Gérer toutes mes alertes</a></p>
    </div>
  </div>

  </div>

  <div class="box">
    <header>
      <h2>Mes Groupes</h2>
    </header>
    <div>
      {if $groupes|@count > 0}
      <p>Vous administrez le(s) groupe(s) suivant(s) :</p>
      <ul>
        {foreach $groupes as $groupe}
        <li><a href="/groupes/edit/{$groupe->getIdGroupe()}" title="{$groupe->getName()|escape}">{$groupe->getName()|escape}</a></li>
        {/foreach}
      </ul>
      <p><a href="/groupes/my">Tous mes groupes</a></p>
      {else}
      <p>aucun groupe</p>
      {/if}
      <p><a href="/groupes/create">Inscrire un groupe</a></p>
    </div>
  </div>

  <div class="box">
    <header>
      <h2>Mes photos</h2>
    </header>
    <div>
      {if $nb_photos > 0}
      <p>Vous avez {$nb_photos} photos</p>
      <p><a href="/photos/my">Toutes mes photos</a></p>
      {else}
      <p>Aucune photo</p>
      {/if}
      <p><a href="/photos/create">Ajouter une photo</a></p>
    </div>
  </div>

  <div class="box">
    <header>
      <h2>Mes vidéos</h2>
    </header>
    <div>
      {if $nb_videos > 0}
      <p>Vous avez {$nb_videos} vidéos</p>
      <p><a href="/videos/my">Toutes mes vidéos</a></p>
      {else}
      <p>Aucune vidéo</p>
      {/if}
      <p><a href="/videos/create">Ajouter une vidéo</a></p>
    </div>
  </div>

  <div class="box">
    <header>
      <h2>Mes musiques</h2>
    </header>
    <div>
      {if $nb_audios > 0}
      <p>Vous avez {$nb_audios} audios</p>
      <p><a href="/audios/my">Toutes mes musiques</a></p>
      {else}
      <p>Aucune musique</p>
      {/if}
      <p><a href="/audios/create">Ajouter une musique</a></p>
    </div>
  </div>

</div>

{include file="common/footer.tpl"}
