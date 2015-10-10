{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Supprimer un lieu"}

{if !empty($unknown_lieu)}

<p class="error">Ce lieu est introuvable !</p>

{else}

<form id="form-lieu-delete" name="form-lieu-delete" action="/lieux/delete" method="post">
  <fieldset>
    <ol>
      <li>Nom : {$lieu->getName()|escape}</li>
      <li>Type : {$lieu->getType()|escape}</li>
      <li>Adresse : {$lieu->getAddress()|escape}</li>
      <li>Code Postal : {$lieu->getCp()}</li>
      <li>Département : {$lieu->getIdDepartement()}</li>
      <li>Ville : {$lieu->getCity()|escape}</li>
      <li>Pays : {$lieu->getIdCountry()}</li>
      <li>Description : {$lieu->getText()|escape}</li>
      <li>Téléphone : {$lieu->getTel()|escape}</li>
      <li>Fax : {$lieu->getFax()|escape}</li>
      <li>Email : {$lieu->getEmail()|escape}</li>
      <li>Site : {$lieu->getSite()|escape}</li>
      <li>Latitude : {$lieu->getLat()|escape}</li>
      <li>Longitude : {$lieu->getLng()|escape}</li>
    </ol>
  </fieldset>
  <input id="form-lieu-delete-submit" name="form-lieu-delete-submit" type="submit" class="button" value="Supprimer" />
  <input type="hidden" name="id" value="{$lieu->getId()|escape}" />
</form>

{/if}

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}