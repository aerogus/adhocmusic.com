{include file="common/header.tpl"}

{if $me->isInterne()}
<div class="infobulle info"><a href="/adm/">🔗 <strong>Accès zone privée</strong></a></div>
{/if}

<div class="grid-4-small-2-tiny-1 has-gutter-l">

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
          <span id="created_on" style="float: right">{$me->getCreatedOn()|date_format:"%d/%m/%Y %H:%M"}</span>
          <label for="created_on">Inscription</label>
        </li>
        <li>
          <span id="modified_on" style="float: right">{$me->getModifiedOn()|date_format:"%d/%m/%Y %H:%M"}</span>
          <label for="modified_on">Modification</label>
        </li>
        <li>
          <span id="visited_on" style="float: right">{$me->getVisitedOn()|date_format:"%d/%m/%Y %H:%M"}</span>
          <label for="visited_on">Visite</label>
        </li>
        <li>
          <span style="float: right">
          <img src="{$me->getAvatar()}" alt=""><br>
          </span>
          <label for="avatar">Avatar</label>
        </li>
      </ul>
      <p><a href="/membres/edit">Editer mes infos persos</a></p>
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
          <td><img src="/img/icones/{if !empty($msg.read)}email_open.png{else}email.png{/if}" alt=""></td>
          <td><a href="/messagerie/write?pseudo={$msg.pseudo|escape}">{$msg.pseudo|escape}</a></td>
          <td>{$msg.date|date_format:'%d/%m/%Y à %H:%M'}</td>
          <td><a href="/messagerie/read/{$msg.id|escape}">{$msg.text|truncate:40|escape}</a></td>
        </tr>
        {/foreach}
      </table>
      <p><a href="/messagerie/">Tous mes messages</a></p>
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
        <li><a href="/groupes/{$groupe.id_groupe}">{$groupe.name}</a></li>
        {/foreach}
      </ul>
      {else}
      <p class="infobulle validation"">Aucun abonnement groupe</p>
      {/if}
      <h5>Évènements</h5>
      {if !empty($alerting_events)}
      <ul>
      {foreach $alerting_events as $event}
        <li><a href="/events/{$event.id_event}">{$event.name}</a></li>
      {/foreach}
      </ul>
      {else}
      <p class="infobulle validation"">Aucun abonnement évènement</p>
      {/if}
      <h5>Lieux</h5>
      {if !empty($alerting_lieux)}
      <ul>
      {foreach $alerting_lieux as $lieu}
        <li><a href="/lieux/{$lieu.id_lieu}">{$lieu.name}</a></li>
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
      <table>
        <tr>
          <th>Groupe</th>
          <th>Poste</th>
          <th>Créé le</th>
          <th>Modifié le</th>
        </tr>
        {foreach $groupes as $groupe}
        <tr>
          <td><a href="/groupes/edit/{$groupe.id}" title="{$groupe.name|escape}">{$groupe.name|escape}</a></td>
          <td>{$groupe.nom_type_musicien}</td>
          <td>{$groupe.created_on|date_format:'%d/%m/%Y'}</td>
          <td>{$groupe.modified_on|date_format:'%d/%m/%Y'}</td>
        </tr>
        {/foreach}
      </table>
      <p><a href="/groupes/my">Tous mes groupes</a></p>
      {else}
      <p>aucun groupe</p>
      {/if}
      <p><a href="/groupes/create">Inscrire un groupe</a></p>
    </div>
  </div>

  <div class="box">
    <header>
      <h2>Mes Photos</h2>
    </header>
    <div>
      {if $photos|@count == 0}
      <p>Aucune photo</p>
      {else}
      <p>Vous avez {$nb_photos} photos</p>
      {foreach $photos as $photo}
      <div class="thumb-80">
        <a href="/photos/edit/{$photo.id}?page={$page}"><img src="{$photo.thumb_80_80}" alt="{$photo.name|escape}"><br>{$photo.name|truncate:15:"...":true:true|escape}</a>
        <a class="overlay-80 overlay-photo-80" href="/photos/edit/{$photo.id}" title="{$photo.name|escape}"></a>
      </div>
      {/foreach}
      <p><a href="/photos/my">Toutes mes photos</a></p>
      {/if}
      <p><a href="/photos/create">Ajouter une photo</a></p>
    </div>
  </div>

  <div class="box">
    <header>
      <h2>Mes Vidéos</h2>
    </header>
    <div>
      {if $videos|@count == 0}
      <p>Aucune vidéo</p>
      {else}
      <p>Vous avez {$nb_videos} vidéos</p>
      {foreach $videos as $video}
      <div class="thumb-80">
        <a href="/videos/edit/{$video.id}?page={$page}"><img src="{$video.thumb_80_80}" alt="{$video.name|escape}"><br>{$video.name|truncate:15:"...":true:true|escape}</a>
        <a class="overlay-80 overlay-video-80" href="/videos/edit/{$video.id}" title="{$video.name|escape}"></a>
      </div>
      {/foreach}
      <p><a href="/videos/my">Toutes mes vidéos</a></p>
      {/if}
      <p><a href="/videos/create">Ajouter une vidéo</a></p>
    </div>
  </div>

  <div class="box">
    <header>
      <h2>Mes Musiques</h2>
    </header>
    <div>
      {if $audios|@sizeof == 0}
      <p>Aucune musique</p>
      {else}
      <p>Vous avez {$nb_audios} audios</p>
      <table>
        <thead>
          <tr>
            <th>Groupe</th>
            <th>Titre</th>
            <th>Créé le</th>
            <th>Modifié le</th>
          </tr>
        </thead>
        {foreach $audios as $audio}
        <tbody>
          <tr>
            <td>{$audio.groupe_name|escape}</td>
            <td><a href="/audios/edit/{$audio.id|escape}">{$audio.name|escape}</a></td>
            <td>{$audio.created_on|date_format:'%d/%m/%Y'}</td>
            <td>{$audio.modified_on|date_format:'%d/%m/%Y'}</td>
          </tr>
        </tbody>
        {/foreach}
      </table>
      <p><a href="/audios/my">Toutes mes musiques</a></p>
      {/if}
      <p><a href="/audios/create">Ajouter une musique</a></p>
    </div>
  </div>

</div>

{include file="common/footer.tpl"}
