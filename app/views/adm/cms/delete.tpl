{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Effacer une page statique</h1>
  </header>
  <div>

<form id="form-cms-delete" name="form-cms-delete" action="/adm/cms/delete" method="post">
  <p>Confirmer la suppression de cette page : {$cms->getAlias()|escape}</p>
  <input id="form-cms-delete-submit" name="form-cms-delete-submit" type="submit" value="Supprimer" class="btn btn--primary">
  <input type="hidden" name="id_cms" value="{$cms->getId()|escape}">
</form>

  </div>
</div>

{include file="common/footer.tpl"}
