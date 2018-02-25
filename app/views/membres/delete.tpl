{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Suppression membre"}

{if !empty($unknown_member)}

<p class="infobulle error">Ce membre est introuvable !</p>

{else}

<form id="form-member-delete" name="form-member-delete" action="/membres/delete" method="POST">
<p>Confirmer la suppression du membre {$membre->getPseudo()|escape} ?</p>
<input type="submit" id="form-member-delete-submit" name="form-member-delete-submit" value="Supprimer">
<input type="hidden" name="id" value="{$membre->getId()|escape}">
</form>

{/if}

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
