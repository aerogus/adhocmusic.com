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
    <h2>Base de données</h2>
  </header>
  <div class="reset">
    <ul class="admlinks">
       <li><a href="/adm/membres/">Membres</a></li>
       <li><a href="/adm/groupes/">Groupes</a></li>
       <li><a href="/adm/groupe-de-style">Groupe de Style</a></li>
    </ul>
  </div>
</div>

{include file="common/footer.tpl"}
