{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Foire aux questions"}

<form id="form-faq-delete" name="form-faq-delete" action="/adm/faq/delete" method="post">
  <p>Confirmer la suppression de cette question :</p>
  <input id="form-faq-delete-submit" name="form-faq-delete-submit" type="submit" value="Supprimer">
  <input type="hidden" name="id_faq" value="{$faq->getId()}">
</form>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
