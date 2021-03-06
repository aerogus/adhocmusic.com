{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Supprimer un lieu</h1>
  </header>
  <div>

{if !empty($unknown_lieu)}

<p class="infobulle error">Ce lieu est introuvable !</p>

{else}

<form id="form-lieu-delete" name="form-lieu-delete" action="/lieux/delete" method="post">
  <fieldset>
    <ol>
      <li>Nom : {$lieu->getName()|escape}</li>
      <li>Type : {$lieu->getType()|escape}</li>
      <li>Adresse : {$lieu->getAddress()|escape}</li>
      <li>Code Postal : {$lieu->getCity()->getCp()}</li>
      <li>Département : {$lieu->getIdDepartement()}</li>
      <li>Ville : {$lieu->getCity()->getName()|escape}</li>
      <li>Pays : {$lieu->getCountry()->getName()}</li>
      <li>Description : {$lieu->getText()|escape}</li>
      <li>Site : {$lieu->getSite()|escape}</li>
      <li>Latitude : {$lieu->getLat()|escape}</li>
      <li>Longitude : {$lieu->getLng()|escape}</li>
    </ol>
  </fieldset>
  <input id="form-lieu-delete-submit" name="form-lieu-delete-submit" type="submit" class="btn btn--primary" value="Supprimer">
  <input type="hidden" name="id" value="{$lieu->getId()|escape}">
</form>

{/if}

  </div>
</div>

{include file="common/footer.tpl"}
