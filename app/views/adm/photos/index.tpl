{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Photos</h1>
  </header>
  <div class="reset">

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

<table class="table table--zebra" id="tab-groupes">
  <thead>
    <tr>
      <th>Photo</th>
      <th>Groupe</th>
      <th>Évènement</th>
      <th>Lieu</th>
      <th>Créa</th>
      <th>Modif</th>
    </tr>
  </thead>
  <tbody>
  {foreach from=$photos item=photo}
    <tr>
      <td><img src="{$photo->getThumbUrl(80)}" alt=""/><br/>{$photo->getName()|escape}</td>
      <td>{if ($photo->getIdGroupe())}{$photo->getGroupe()->getName()|escape}{/if}</td>
      <td>{if ($photo->getIdEvent())}{$photo->getEvent()->getName()|escape}{/if}</td>
      <td>{if ($photo->getIdLieu())}{$photo->getLieu()->getName()|escape}{/if}</td>
      <td>{$photo->getCreatedOn()|date_format:'%d/%m/%y'}</td>
      <td>{$photo->getModifiedOn()|date_format:'%d/%m/%y'}</td>
    </tr>
  {/foreach}
  </tbody>
</table>

  </div>
</div>

{include file="common/footer.tpl"}
