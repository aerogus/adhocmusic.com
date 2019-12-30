{include file="common/header.tpl"}

<div class="box">
  <header>
    <h2>Suppression d'un compte</h2>
  </header>
  <div>

{if !empty($unknown_member)}

<p class="infobulle error">Ce membre est introuvable !</p>

{else}

<form id="form-member-delete" name="form-member-delete" action="/membres/delete" method="POST">
  <p>Confirmer la suppression du membre {$membre->getPseudo()|escape} ?</p>
  <input class="button" type="submit" id="form-member-delete-submit" name="form-member-delete-submit" value="Supprimer">
  <input type="hidden" name="id" value="{$membre->getId()|escape}">
</form>

{/if}

  </div>
</div>

{include file="common/footer.tpl"}
