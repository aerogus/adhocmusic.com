{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Suppression d'une question fréquente</h1>
  </header>
  <div>
  <form id="form-faq-delete" name="form-faq-delete" action="/adm/faq/delete" method="post">
    <p>Confirmer la suppression de cette question ?</p>
    <input class="btn btn--primary" id="form-faq-delete-submit" name="form-faq-delete-submit" type="submit" value="Supprimer">
    <input type="hidden" name="id" value="{$faq->getId()}">
  </form>
  </div>
</div>

{include file="common/footer.tpl"}
