{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle=$forum.title|escape}

<a class="button" href="/forums/write?id_forum={$forum.id_forum|escape}">Nouveau Sujet</a>

<table style="width: 100%">
  <thead>
    <tr>
      <th>Sujet <em>(Réponses)</em></th>
      <th>Dernier message</th>
      <th>Vues</th>
    </tr>
  </thead>
  <tbody>
    {foreach from=$threads key=cpt item=thread}
    <tr class="{if $cpt is even}even{else}odd{/if}">
      <td><a href="/forums/thread/{$thread.id_thread|escape}"><strong>{$thread.subject|escape}</strong></a> <em>({$thread.nb_replies|escape})</em></td>
      <td>Par
      {if !empty($thread.modified_by)}
        {assign var="pseudo" value=$thread.modified_by|pseudo_by_id}
        {if !empty($pseudo)}
        <a href="/membres/show/{$thread.modified_by|escape}">{$thread.modified_by|pseudo_by_id}</a>
        {else}
        <em>compte supprimé</em>
        {/if}
      {else}
        {$thread.modified_by_name|escape}
      {/if}
      <br />le {$thread.modified_on|date_format:'%d/%m/%Y à %H:%M'}</td>
      <td>{$thread.nb_views|escape}</td>
    </tr>
    {/foreach}
  </tbody>
</table>

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

<a class="button" href="/forums/write?id_forum={$forum.id_forum|escape}">Nouveau sujet</a>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
