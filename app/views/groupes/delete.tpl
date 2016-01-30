{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Supprimer un groupe"}

{if !empty($unknown_groupe)}

<div class="error">Groupe introuvable</div>

{elseif !empty($not_my_groupe)}

<div class="error">Vous ne pouvez pas supprimer ce groupe.</div>

{else}

<p>Confirmer suppression du groupe {$groupe->getName()} ?</p>

<ul>
  <li>ceci effacera définitivement un groupe de la base + la photo, mini photo, logo</li>
  <li>+ ses liaisons avec membres</li>
  <li>+ ses liaisons avec styles</li>
  <li>+ ses liaisons avec events</li>
  <li>+ ses liaisons avec photos, videos, audios</li>
</ul>

<form id="form-groupe-delete" name="form-groupe-delete" action="/groupes/delete" method="post">
  <input type="hidden" name="id" value="{$groupe->getId()}">
  <input id="form-groupe-delete-submit" name="form-groupe-delete-submit" type="submit" value="OK">
</form>

{/if}

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
