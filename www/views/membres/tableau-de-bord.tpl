{include file="common/header.tpl"}

<div style="float: left;">
{include file="common/boxstart.tpl" boxtitle="Mes Groupes" width="400px"}
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
<p><a href="/groupes/create">Inscrire un Groupe</a>
</div>
{include file="common/boxend.tpl"}
</div>

<div style="float: left;">
{include file="common/boxstart.tpl" boxtitle="Mes Photos" width="250px"}
{if $photos|@count == 0}
<p>Aucune photo</p>
{else}
<p>Vous avez {$nb_photos} photos</p>
{foreach from=$photos item=photo}
<div class="thumb-80">
  <a href="/photos/edit/{$photo.id}?page={$page}"><img src="{$photo.thumb_80_80}" alt="{$photo.name|escape}" /><br />{$photo.name|truncate:15:"...":true:true|escape}</a>
  <a class="overlay-80 overlay-photo-80" href="/photos/edit/{$photo.id}" title="{$photo.name|escape}"></a>
</div>
{/foreach}
<hr style="clear: both;" />
<p><a href="/photos/my">Toutes mes photos</a></p>
<p><a href="/photos/create">Proposer une Photo</a></p>
{/if}
{include file="common/boxend.tpl"}
</div>

<div style="float: left;">
{include file="common/boxstart.tpl" boxtitle="Mes Vidéos" width="250px"}
{if $videos|@count == 0}
<p>Aucune vidéo</p>
{else}
<p>Vous avez {$nb_videos} vidéos</p>
{foreach from=$videos item=video}
<div class="thumb-80">
  <a href="/videos/edit/{$video.id}?page={$page}"><img src="{$video.thumb_80_80}" alt="{$video.name|escape}" /><br />{$video.name|truncate:15:"...":true:true|escape}</a>
  <a class="overlay-80 overlay-video-80" href="/videos/edit/{$video.id}" title="{$video.name|escape}"></a>
</div>
{/foreach}
<hr style="clear: both;" />
<p><a href="/videos/my">Toutes mes vidéos</a></p>
<p><a href="/videos/create">Proposer une Vidéo</a></p>
{/if}
{include file="common/boxend.tpl"}
</div>

<br style="clear: both;" />

<div style="float: left;">
{include file="common/boxstart.tpl" boxtitle="Mes Musiques" width="400px"}
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
{include file="common/boxend.tpl"}
</div>

<div style="float: left;">
{include file="common/boxstart.tpl" boxtitle="Messages reçus" width="500px"}
<table>
  <tr>
    <th>Lu</th>
    <th>De</th>
    <th>Date</th>
    <th>Message</th>
  </tr>
  {foreach from=$inbox key=cpt item=msg}
  <tr class="{if $cpt is odd}odd{else}even{/if}">
    <td><img src="{#STATIC_URL#}/img/icones/{if !empty($msg.read)}email_open.png{else}email.png{/if}" alt="" /></td>
    <td><a href="/messagerie/write?pseudo={$msg.pseudo|escape}">{$msg.pseudo|escape}</a></td>
    <td>{$msg.date|date_format:'%d/%m/%Y à %H:%M'}</td>
    <td><a href="/messagerie/read/{$msg.id|escape}">{$msg.text|truncate:40|escape}</a></td>
  </tr>
  {/foreach}
</table>
<p><a href="/messagerie/">Tous mes messages</a></p>
{include file="common/boxend.tpl"}
</div>

<br style="clear: both;" />

<div style="float: left;">
{include file="common/boxstart.tpl" boxtitle="Mes Infos Persos" width="250px"}
{*
{if $me->getFacebookUid()}
{else}
<p class="warning"><a href="">Cliquez ici pour lier votre compte AD'HOC à votre compte Facebook</a></p>
{/if}
*}
<ol>
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
    <img src="{$me->getAvatar()}" alt="" /><br />
    </span>
    <label for="avatar">Avatar</label>
  </li>
</ol>
<br style="clear: both;" />
<p><a href="/membres/edit/{$me->getId()}">Editer mes infos persos</a></p>
{include file="common/boxend.tpl"}
</div>

<div style="float: left;">
{include file="common/boxstart.tpl" boxtitle="Mes Articles" width="400px"}
{if $nb_articles == 0}
<p>Aucun article</p>
{else}
<p>Vous avez écrit {$nb_articles} articles</p>
<table>
  <thead>
    <tr>
      <th>Titre</th>
      <th>Création</th>
      <th>Modification</th>
      <th>Rubrique</th>
      <th>En Ligne</th>
    </tr>
  </thead>
  <tbody>
    {foreach from=$articles key=cpt item=article}
    <tr class="{if $cpt is odd}odd{else}even{/if}">
      <td><a href="/articles/edit/{$article.id}" title="{$article.title|escape}">{$article.title|escape}</a></td>
      <td>{$article.created_on|date_format:"%d/%m/%Y"}</td>
      <td>{$article.modified_on|date_format:"%d/%m/%Y"}</td>
      <td>{$article.rubrique|escape}</td>
      <td><span id="toggle-art-{$article.id}">{$article.online|display_on_off_icon}<span></td>
    </tr>
    {/foreach}
  </tbody>
</table>
{/if}
<p><a href="/articles/my">Tous mes articles</a></p>
<p><a href="/articles/create">Ecrire un article</a></p>
{include file="common/boxend.tpl"}
</div>

<div style="float: left;">
{include file="common/boxstart.tpl" boxtitle="Mes Abonnements" width="250px"}

<h5>Groupes</h5>
{if !empty($alerting_groupes)}
<ul>
  {foreach from=$alerting_groupes item=groupe}
  <li><a href="/groupes/show/{$groupe.id_groupe}">{$groupe.name}</a></li>
  {/foreach}
</ul>
{else}
<p class="validation">Vous n'êtes abonné à aucun groupe</p>
{/if}

<h5>Agenda</h5>
{if !empty($alerting_events)}
<ul>
{foreach from=$alerting_events item=event}
  <li><a href="/events/show/{$event.id_event}">{$event.name}</a></li>
{/foreach}
</ul>
{else}
<p class="validation">Vous n'avez aucun événement dans votre agenda</p>
{/if}

<h5>Lieux</h5>
{if !empty($alerting_lieux)}
<ul>
{foreach from=$alerting_lieux item=lieu}
  <li><a href="/lieux/show/{$lieu.id_lieu}">{$lieu.name}</a></li>
{/foreach}
</ul>
{else}
<p class="validation">Vous n'êtes abonné à aucun lieu</p>
{/if}

<p><a href="/alerting/my">Gérer toutes mes alertes</a></p>

{include file="common/boxend.tpl"}
</div>

<br style="clear: both;" />

{include file="common/footer.tpl"}
