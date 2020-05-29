{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Supprimer un groupe</h1>
  </header>
  <div>

{if !empty($unknown_groupe)}

<div class="infobulle error">Groupe introuvable</div>

{elseif !empty($not_my_groupe)}

<div class="infobulle error">Vous ne pouvez pas supprimer ce groupe.</div>

{else}

<p>Confirmer la suppression du groupe {$groupe->getName()} ?</p>

<ul>
  <li>ceci effacera définitivement un groupe de la base + la photo, mini photo, logo</li>
  <li>+ ses liaisons avec membres</li>
  <li>+ ses liaisons avec styles</li>
  <li>+ ses liaisons avec events</li>
  <li>+ ses liaisons avec photos, videos, audios</li>
</ul>

<form id="form-groupe-delete" name="form-groupe-delete" action="/groupes/delete" method="post">
  <input type="hidden" name="id" value="{$groupe->getId()}">
  <input class="btn btn--primary" id="form-groupe-delete-submit" name="form-groupe-delete-submit" type="submit" value="OK">
</form>

{/if}

  </div>
</div>

{include file="common/footer.tpl"}
