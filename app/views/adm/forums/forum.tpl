{include file="common/header.tpl"}

<div class="box">
  <header>
    <h2>{$forum.title}</h2>
  </header>
  <div>

<div class="subscribers round-corners-all">
{foreach from=$subs item=sub}
<a href="{$sub.url}" title="{$sub.pseudo|escape} - {$sub.port|escape} - {$sub.email|escape}"><img src="{$sub.avatar}" class="thread-avatar" alt="{$sub.pseudo|escape} - {$sub.port|escape} - {$sub.email|escape}" /></a>
{/foreach}
</div>

<a class="btn btn--primary" href="/adm/forums/write?id_forum={$forum.id_forum|escape}">Nouveau sujet</a>

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

<table class="table table--zebra">
  <thead>
    <tr>
      <th>Sujet <em>(Réponses)</em></th>
      <th>Dernier Message</th>
      <th>Vues</th>
    </tr>
  </thead>
  <tbody>
  {foreach from=$threads key=cpt item=thread}
    <tr>
      <td><img src="{$thread.created_by_avatar}" style="padding-right: 5px" class="thread-avatar" alt="" /><a class="toggle" id="toggle_{$thread.id_thread}" href="{$thread.url}"><strong>{$thread.subject|escape}</strong></a> <em>({$thread.nb_replies|escape})</em><br />Par <a href="{$thread.created_by_url}">{$thread.created_by|pseudo_by_id}</a> le {$thread.created_at|date_format:'%d/%m/%Y à %H:%M'}
      <p style="display: none" class="msg" id="msg_{$thread.id_thread}">{$thread.text|@strip_tags|@nl2br}</p></td>
      <td>Par <a href="/membres/{$thread.modified_by}">{$thread.modified_by|pseudo_by_id}</a><br />le {$thread.modified_at|date_format:'%d/%m/%Y à %H:%M'}</td>
      <td>{$thread.nb_views|escape}</td>
  {/foreach}
  </tbody>
</table>

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

<a class="btn btn--primary" href="/adm/forums/write?id_forum={$forum.id_forum|escape}">Nouveau sujet</a>

  </div>
</div>

{include file="common/footer.tpl"}
