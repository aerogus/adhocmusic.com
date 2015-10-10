{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Pages Statiques"}

<form id="form-cms-delete" name="form-cms-delete" action="/adm/cms/delete" method="post">
  <p>Confirmer la suppression de cette page : {$cms->getAlias()|escape}</p>
  <input id="form-cms-delete-submit" name="form-cms-delete-submit" type="submit" value="Supprimer" class="button" />
  <input type="hidden" name="id_cms" value="{$cms->getId()|escape}" />
</form>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
