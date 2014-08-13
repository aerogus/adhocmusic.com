{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Modération Forums"}
{if !empty($id)}
message {$id} effacé<br />
<a href="/adm/forums/?mbr={$id_con}&amp;id={$id_forum}">Retour</a>
{/if}
{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}