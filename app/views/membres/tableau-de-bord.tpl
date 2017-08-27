{include file="common/header.tpl"}

{if $me->isInterne()}
<div style="margin-bottom:2em">
   <a style="display:block;background:#f99;padding:5px;border:1px solid" href="/adm/">🔗 <strong>Accès zone privée</strong></a>
</div>
{/if}

<div class="grid-3-small-2-tiny-1 has-gutter-l">

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

  <div class="box">
    <header>
      <h2>Mes Abonnements</h2>
    </header>
    <div>
      <h5>Groupes</h5>
      {if !empty($alerting_groupes)}
      <ul>
        {foreach from=$alerting_groupes item=groupe}
        <li><a href="/groupes/{$groupe.id_groupe}">{$groupe.name}</a></li>
        {/foreach}
      </ul>
      {else}
      <p class="validation">Vous n'êtes abonné à aucun groupe</p>
      {/if}
      <h5>Agenda</h5>
      {if !empty($alerting_events)}
      <ul>
      {foreach from=$alerting_events item=event}
        <li><a href="/events/{$event.id_event}">{$event.name}</a></li>
      {/foreach}
      </ul>
      {else}
      <p class="validation">Vous n'avez aucun événement dans votre agenda</p>
      {/if}
      <h5>Lieux</h5>
      {if !empty($alerting_lieux)}
      <ul>
      {foreach from=$alerting_lieux item=lieu}
        <li><a href="/lieux/{$lieu.id_lieu}">{$lieu.name}</a></li>
      {/foreach}
      </ul>
      {else}
      <p class="validation">Vous n'êtes abonné à aucun lieu</p>
      {/if}
      <p><a href="/alerting/my">Gérer toutes mes alertes</a></p>
    </div>
  </div>

  <div class="box">
    <header>
      <h2>Mes Groupes</h2>
    </header>
    <div class="blocinfo">
      {if $groupes|@count > 0}
      <p>Vous administrez le(s) groupe(s) suivant(s) :</p>
      <table>
        <tr>
          <th>Groupe</th>
          <th>Poste</th>
          <th>Créé le</th>
          <th>Modifié le</th>
        </tr>
        {foreach from=$groupes item=groupe}
        <tr>
          <td><a href="/groupes/edit/{$groupe.id}" title="{$groupe.name|escape}">{$groupe.name|escape}</a></td>
          <td>{$groupe.nom_type_musicien}</td>
          <td>{$groupe.created_on|date_format:'%d/%m/%Y'}</td>
          <td>{$groupe.modified_on|date_format:'%d/%m/%Y'}</td>
        </tr>
        {/foreach}
      </table>
      {else}
      <p>Vous n'administrez aucun groupe</p>
      <p>Vous avez un groupe de musique ? inscrivez le sur AD'HOC !</p>
      {/if}
      <p><a href="/groupes/my">Tous mes groupes</a></p>
      <p><a href="/groupes/create">Inscrire un Groupe</a></p>
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
      {foreach from=$photos item=photo}
      <div class="thumb-80">
        <a href="/photos/edit/{$photo.id}?page={$page}"><img src="{$photo.thumb_80_80}" alt="{$photo.name|escape}"><br>{$photo.name|truncate:15:"...":true:true|escape}</a>
        <a class="overlay-80 overlay-photo-80" href="/photos/edit/{$photo.id}" title="{$photo.name|escape}"></a>
      </div>
      {/foreach}
      <p><a href="/photos/my">Toutes mes photos</a></p>
      <p><a href="/photos/create">Proposer une Photo</a></p>
      {/if}
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
      {foreach from=$videos item=video}
      <div class="thumb-80">
        <a href="/videos/edit/{$video.id}?page={$page}"><img src="{$video.thumb_80_80}" alt="{$video.name|escape}"><br>{$video.name|truncate:15:"...":true:true|escape}</a>
        <a class="overlay-80 overlay-video-80" href="/videos/edit/{$video.id}" title="{$video.name|escape}"></a>
      </div>
      {/foreach}
      <p><a href="/videos/my">Toutes mes vidéos</a></p>
      <p><a href="/videos/create">Proposer une Vidéo</a></p>
      {/if}
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
        {foreach from=$audios item=audio}
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
      {/if}
      <p><a href="/audios/my">Toutes mes musiques</a></p>
      <p><a href="/audios/create">Ajouter une Musique</a></p>
    </div>
  </div>

</div>

{include file="common/footer.tpl"}
