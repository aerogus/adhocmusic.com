{include file="common/header.tpl"}

<div class="box">
  <header>
    <h2>Communication Interne</h2>
  </header>
  <div class="reset">

    <table class="table table--zebra">
      <thead>
        <tr>
          <th>Forum</th>
          <th>Dernier Message</th>
          <th>Discussions</th>
          <th>Messages</th>
        </tr>
      </thead>
      <tbody>
      {foreach from=$forums key=cpt item=forum}
        <tr class="{if $cpt is odd}odd{else}even{/if}">
          <td><a href="/adm/forums/forum/{$forum.id_forum|escape}"><strong>{$forum.title|escape}</strong></a><br />{$forum.description|escape}</td>
          <td>Par <a href="/membres/{$forum.id_contact}">{$forum.pseudo}</a><br />le {$forum.date|date_format:'%d/%m/%Y à %H:%M'}</td>
          <td>{$forum.nb_threads|escape}</td>
          <td>{$forum.nb_messages|escape}</td>
        </tr>
      {/foreach}
      </tbody>
    </table>
  </div>
</div>

<div class="box">
  <header>
    <h2>Editorial du site</h2>
  </header>
  <div class="reset">
    <ul class="admlinks">
      <li><a href="/adm/featured/">À la une</a></li>
      <li><a href="/adm/newsletter/">Newsletter</a></li>
      <li><a href="/adm/faq/">Foire aux questions</a></li>
      <li><a href="/adm/cms/">Pages statiques</a></li>
      <li><a href="/comments/">Commentaires</a></li>
    </ul>
  </div>
</div>

<div class="box">
  <header>
    <h2>Données</h2>
  </header>
  <div class="reset">
    <ul class="admlinks">
       <li><a href="/adm/membres/">Membres</a></li>
       <li><a href="/adm/groupes/">Groupes</a></li>
       <li><a href="/adm/groupe-de-style">Groupe de Style</a></li>
       <li><a href="/adm/delete-account">Suppression Compte</a></li>
    </ul>
  </div>
</div>

<div class="box">
  <header>
    <h2>Statistiques / Log</h2>
  </header>
  <div class="reset">
    <ul class="admlinks">
      <li><a href="/adm/stats-top-membres">Membres ayant le + joué à AD'HOC</a></li>
      <li><a href="/adm/stats-top-groupes">Groupes ayant le + joué à AD'HOC</a></li>
      <li><a href="/adm/stats?m=1">Inscriptions membres par mois</a></li>
      <li><a href="/adm/stats?m=2">Inscriptions groupes par mois</a></li>
      <li><a href="/adm/stats?m=3">Top contributeurs photos</a></li>
      <li><a href="/adm/stats?m=4">Top contributeurs audios</a></li>
      <li><a href="/adm/stats?m=5">Top contributeurs vidéos</a></li>
      <li><a href="/adm/stats?m=6">Top contributeurs messages forums</a></li>
      <li><a href="/adm/stats?m=7">Top contributeurs lieux</a></li>
      <li><a href="/adm/stats?m=8">Top contributeurs dates</a></li>
      <li><a href="/adm/stats?m=9">Dernières connexions</a></li>
      <li><a href="/adm/stats?m=A">Top lieux</a></li>
      <li><a href="/adm/stats?m=B">Nombre de lieux par département</a></li>
      <li><a href="/adm/stats?m=C">Nombre de lieux par région</a></li>
      <li><a href="/adm/stats?m=D">Top Visites Groupes</a></li>
      <li><a href="/adm/stats?m=E">Top Visites Articles</a></li>
      <li><a href="/adm/stats?m=H">Domaines Emails</a></li>
      <li><a href="/adm/stats?m=I">Nombre d'événements annoncés par mois</a></li>
      <li><a href="/adm/stats?m=J">Répartition des vidéos par hébergeur</a></li>
      <li><a href="/adm/stats?m=K">Nombre de photos par lieu</a></li>
      <li><a href="/adm/log-action">Log Action</a></li>
      <li><a href="/adm/stats-nl">Stats Newsletter</a></li>
    </ul>
  </div>
</div>

{include file="common/footer.tpl"}
