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
      <td>{$photo->getId()}<br/><img src="{$photo->getThumbUrl(80)}" alt=""/><br/>{$photo->getName()|escape}</td>
      <td>{if ($photo->getIdGroupe())}<a href="{$photo->getGroupe()->getUrl()}">{$photo->getGroupe()->getName()|escape}</a>{/if}</td>
      <td>{if ($photo->getIdEvent())}<a href="{$photo->getEvent()->getUrl()}">{$photo->getEvent()->getName()|escape}</a><br/>{$photo->getEvent()->getDate()|date_format:'%d/%m/%Y'}{/if}</td>
      <td>{if ($photo->getIdLieu())}<a href="{$photo->getLieu()->getUrl()}">{$photo->getLieu()->getName()|escape}</a><br>{$photo->getLieu()->getIdDepartement()} {$photo->getLieu()->getCity()->getName()}{/if}</td>
      <td>{$photo->getCreatedAt()|date_format:'%d/%m/%Y'}</td>
      <td>{$photo->getModifiedAt()|date_format:'%d/%m/%Y'}</td>
    </tr>
  {/foreach}
  </tbody>
</table>

  </div>
</div>

{include file="common/footer.tpl"}
