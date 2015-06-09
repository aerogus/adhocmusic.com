{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Communication interne"}

<table style="width: 100%">
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
      <td>Par <a href="/membres/show/{$forum.id_contact}">{$forum.pseudo}</a><br />le {$forum.date|date_format:'%d/%m/%Y à %H:%M'}</td>
      <td>{$forum.nb_threads|escape}</td>
      <td>{$forum.nb_messages|escape}</td>
    </tr>
  {/foreach}
  </tbody>
</table>

<br />

<p>Pour accéder au FTP, vous pouvez aussi utiliser <a href="http://filezilla-project.org/download.php?type=client">FileZilla</a>.<br />
Host: <strong>ftp.adhocmusic.com</strong>, Login: <strong>adhoc</strong>, Password: <strong>squallpowa</strong>, Port: <strong>21</strong></p>
<p>Vous pouvez aussi accéder au FTP par webdav à l'adresse <a href="https://ftp.adhocmusic.com">https://ftp.adhocmusic.com</a>. L'avantage
est qu'on peut monter un lecteur réseau (nativement sous MacOSX ou Linux, avec <a href="http://www.netdrive.net">NetDrive sous Windows)</a></p>
<ul class="admlinks">
  <li><a href="ftp://adhoc:squallpowa@ftp.adhocmusic.com">Listing FTP</a></li>
  <li><a href="https://trac.adhocmusic.com">Trac</a></li>
</ul>
{include file="common/boxend.tpl"}

{include file="common/boxstart.tpl" boxtitle="Editorial du site"}
<ul class="admlinks">
  <li><a href="/adm/featured/">À la une</a></li>
  <li><a href="/adm/newsletter/">Newsletter</a></li>
  <li><a href="/adm/faq/">Foire aux questions</a></li>
  <li><a href="/adm/cms/">Pages statiques</a></li>
  <li><a href="/dynimg/tool">Cache Image</a></li>
  <li><a href="/photos/import">Import photos</a></li>
  <li><a href="/comments/">Commentaires</a></li>
</ul>
{include file="common/boxend.tpl"}

{include file="common/boxstart.tpl" boxtitle="Base de données"}
<ul class="admlinks">
   <li><a href="/adm/membres/">Membres</a></li>
   <li><a href="/adm/groupes/">Groupes</a></li>
   <li><a href="/adm/exposants/">Exposants</a></li>
   <li><a href="/adm/sql">Requête SQL</a>
   <li><a href="/adm/groupe-de-style">Groupe de Style</a></li>
   <li><a href="/adm/est-marque-sur">Taggage photos</a></li>
   <li><a href="/adm/delete-account">Suppression Compte</a></li>
</ul>
{include file="common/boxend.tpl"}

{include file="common/boxstart.tpl" boxtitle="Statistiques / Log"}
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
  <li><a href="/adm/stats?m=F">Membres les plus taggés</a></li>
  <li><a href="/adm/stats?m=G">Membres les plus taggeurs</a></li>
  <li><a href="/adm/stats?m=H">Domaines Emails</a></li>
  <li><a href="/adm/stats?m=I">Nombre d'événements annoncés par mois</a></li>
  <li><a href="/adm/stats?m=J">Répartition des vidéos par hébergeur</a></li>
  <li><a href="/adm/stats?m=K">Nombre de photos par lieu</a></li>
  <li><a href="/adm/log-action">Log Action</a></li>
  <li><a href="/adm/stats-nl">Stats Newsletter</a></li>
</ul>
{include file="common/boxend.tpl"}

{include file="common/boxstart.tpl" boxtitle="Comptabilité / Facturation"}
<ul class="admlinks">
  <li><a href="/adm/billing">Factures OVH</a></li>
  <li><a href="/adm/domains">Nos domaines</a></li>
</ul>
{include file="common/boxend.tpl"}
 
{include file="common/footer.tpl"}
