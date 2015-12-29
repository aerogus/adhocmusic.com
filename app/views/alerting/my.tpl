{include file="common/header.tpl"}

<div class="grid-3-small-2-tiny-1">

<div class="box">
  <header>
    <h2>Mes Abonnements Groupes</h2>
  </header>
  <div>
    <p>Recevez chaque semaine dans votre boite aux lettres les dernières actus (dates, photos, vidéos ...) sur vos groupes préférés.</p>
    {if !empty($groupes)}
    <ul>
    {foreach from=$groupes item=groupe}
      <li><a title="Se désabonner de ce groupe" href="/alerting/unsub?type=g&amp;id_content={$groupe.id_groupe}"><img src="/img/icones/delete.png" alt=""></a> <a href="/groupes/show/{$groupe.id_groupe}">{$groupe.name}</a></li>
    {/foreach}
    </ul>
    {else}
    <p class="validation">Vous n'êtes abonné à aucun groupe</p>
    {/if}
    <p>Pour ajouter un abonnement groupe, veuillez vous rendre sur une <a href="/groupes/">fiche groupe</a> et cliquez sur "S'abonner à ce groupe".</p>
  </div>
</div>

<div class="box">
  <header>
    <h2>Mon Agenda</h2>
  </header>
  <div>
    <p>Voici les événements que vous avez notés dans votre agenda.</p>
    {if !empty($events)}
    <ul>
    {foreach from=$events item=event}
      <li><a title="Retirer de mon agenda" href="/alerting/unsub?type=e&amp;id_content={$event.id_event}"><img src="{#STATIC_URL#}/img/icones/delete.png" alt=""></a> <a href="/events/show/{$event.id_event}">{$event.name}</a></li>
    {/foreach}
    </ul>
    {else}
    <p class="validation">Vous n'avez aucun événement dans votre agenda</p>
    {/if}
    <p>Pour ajouter un événement à votre agenda, veuillez vous rendre sur une <a href="/events/">fiche événement</a> et cliquez sur "Ajouter à mon agenda".</p>
  </div>
</div>

<div class="box">
  <header>
    <h2>Mes Abonnements Lieux</h2>
  </header>
  <div>
    <p>Recevez chaque semaine dans votre boite aux lettres les dernières actus d'un lieu.</p>
    {if !empty($lieux)}
    <ul>
    {foreach from=$lieux item=lieu}
      <li><a title="Se désabonner de ce lieu" href="/alerting/unsub?type=l&id_content={$lieu.id_lieu}"><img src="{#STATIC_URL#}/img/icones/delete.png" alt="" /></a> <a href="/lieux/show/{$lieu.id_lieu}">{$lieu.name}</a></li>
    {/foreach}
    </ul>
    {else}
    <p class="validation">Vous n'êtes abonné à aucun lieu</p>
    {/if}
    <p>Pour ajouter un abonnement lieu, veuillez vous rendre sur une <a href="/lieux/">fiche lieu</a> et cliquez sur "S'abonner à ce lieu".</p>
  </div>
</div>

</div>

{include file="common/footer.tpl"}
