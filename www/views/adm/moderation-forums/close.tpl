{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Modération Forums"}
{if !empty($id)}
Thread {$id} Fermé.<br />
<a href="/adm/forums/">retour</a>
{/if}
{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}