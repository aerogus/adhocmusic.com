{include file="common/header.tpl"}

{include file="common/boxstart.tpl" title="Listes de diffusion"}

<table>
  <tr>
    <th>Domaine</th>
    <th>Nom</th>
    <th>Propriétaire</th>
    <th>Nb Abonnés</th>
    <th>Modération</th>
    <th>User Post Only</th>
    <th>Sub. Moderation</th>
    <th>Reply To</th>
    <th>Langue</th>
  </tr>
{foreach from=$list item=l}
  <tr>
    <td>{$l->domain}</td>
    <td>{$l->ml}</td>
    <td>{$l->owner}</td>
    <td>{$l->nbSubscribers}</td>
    <td>{$l->message_moderation}</td>
    <td>{$l->users_post_only}</td>
    <td>{$l->subscription_moderation}</td>
    <td>{$l->replyto}</td>
    <td>{$l->lang}</td>
  </tr>
{/foreach}
</table>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
