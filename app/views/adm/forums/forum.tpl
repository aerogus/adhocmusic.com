{include file="common/header.tpl"}

<script>
$(function() {
  $(".toggle").hover(function() {
    var toggle_id = $(this).attr('id').replace('toggle_', '');
    $("#msg_" + toggle_id).toggle();
  });
  $(".thread-avatar").hover(function() {
    $(this).addClass('thread-avatar-full');
  }, function() {
    $(this).removeClass('thread-avatar-full');
  });
});
</script>

{include file="common/boxstart.tpl" boxtitle="Forum : {$forum.title|escape}"}

<div class="subscribers round-corners-all">
{foreach from=$subs item=sub}
<a href="/membres/show/{$sub.id_contact}" title="{$sub.pseudo|escape} - {$sub.port|escape} - {$sub.email|escape}"><img src="{#STATIC_URL#}/media/membre/ca/{$sub.id_contact}.jpg" class="thread-avatar" alt="{$sub.pseudo|escape} - {$sub.port|escape} - {$sub.email|escape}" /></a>
{/foreach}
</div>

<a class="button" href="/adm/forums/write?id_forum={$forum.id_forum|escape}">Nouveau sujet</a>

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

<table>
  <thead>
    <tr>
      <th>Sujet <em>(Réponses)</em></th>
      <th>Dernier Message</th>
      <th>Vues</th>
    </tr>
  </thead>
  <tbody>
  {foreach from=$threads key=cpt item=thread}
    <tr class="{if $cpt is odd}odd{else}even{/if}">
      <td><img src="{#STATIC_URL#}/media/membre/ca/{$thread.created_by}.jpg" style="padding-right: 5px" class="thread-avatar" alt="" /><a class="toggle" id="toggle_{$thread.id_thread}" href="/adm/forums/thread/{$thread.id_thread}"><strong>{$thread.subject|escape}</strong></a> <em>({$thread.nb_replies|escape})</em><br />Par <a href="/membres/show/{$thread.created_by}">{$thread.created_by|pseudo_by_id}</a> le {$thread.created_on|date_format:'%d/%m/%Y à %H:%M'}
      <p style="display: none" class="msg" id="msg_{$thread.id_thread}">{$thread.text|@strip_tags|@nl2br}</p></td>
      <td>Par <a href="/membres/show/{$thread.modified_by}">{$thread.modified_by|pseudo_by_id}</a><br />le {$thread.modified_on|date_format:'%d/%m/%Y à %H:%M'}</td>
      <td>{$thread.nb_views|escape}</td>
  {/foreach}
  </tbody>
</table>

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

<a class="button" href="/adm/forums/write?id_forum={$forum.id_forum|escape}">Nouveau sujet</a>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
