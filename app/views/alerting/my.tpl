{include file="common/header.tpl"}

<div class="grid-3-small-2-tiny-1 has-gutter">

  <div class="box">
    <header>
      <h2>Mes Abonnements Groupes</h2>
    </header>
    <div>
      {if !empty($groupes)}
      <ul>
      {foreach from=$groupes item=groupe}
        <li><a title="Se désabonner de ce groupe" href="/alerting/unsub?type=g&amp;id_content={$groupe->getIdGroupe()}"><img src="/img/icones/delete.png" alt=""></a> <a href="{$groupe->getUrl()}">{$groupe->getName()}</a></li>
      {/foreach}
      </ul>
      {else}
      <p class="infobulle validation">Vous n'êtes abonné à aucun groupe</p>
      {/if}
      <p>Recevez chaque semaine dans votre boite aux lettres les dernières actus (dates, photos, vidéos ...) sur vos groupes préférés.</p>
      <p>Pour ajouter un abonnement groupe, veuillez vous rendre sur une <a href="/groupes">fiche groupe</a> et cliquez sur "S'abonner à ce groupe".</p>
    </div>
  </div>

  <div class="box">
    <header>
      <h2>Mon Agenda</h2>
    </header>
    <div>
      {if !empty($events)}
      <ul>
      {foreach from=$events item=event}
        <li><a title="Retirer de mon agenda" href="/alerting/unsub?type=e&amp;id_content={$event->getIdEvent()}"><img src="/img/icones/delete.png" alt=""></a> <a href="{$event->getUrl()}">{$event->getName()}</a></li>
      {/foreach}
      </ul>
      {else}
      <p class="infobulle validation">Aucun événement dans votre agenda</p>
      {/if}
      <p>Recevez une notification par email pour ne louper aucun événement</p>
      <p>Pour ajouter un événement à votre agenda, veuillez vous rendre sur une <a href="/events">fiche événement</a> et cliquez sur "Ajouter à mon agenda".</p>
    </div>
  </div>

  <div class="box">
    <header>
      <h2>Mes Abonnements Lieux</h2>
    </header>
    <div>
      {if !empty($lieux)}
      <ul>
      {foreach from=$lieux item=lieu}
        <li><a title="Se désabonner de ce lieu" href="/alerting/unsub?type=l&id_content={$lieu->getIdLieu()}"><img src="/img/icones/delete.png" alt=""></a> <a href="{$lieu->getUrl()}">{$lieu->getName()}</a></li>
      {/foreach}
      </ul>
      {else}
      <p class="infobulle validation">Vous n'êtes abonné à aucun lieu</p>
      {/if}
      <p>Recevez chaque semaine dans votre boite aux lettres les dernières actus d'un lieu.</p>
      <p>Pour ajouter un abonnement lieu, veuillez vous rendre sur une <a href="/lieux">fiche lieu</a> et cliquez sur "S'abonner à ce lieu".</p>
    </div>
  </div>

</div>

{include file="common/footer.tpl"}
