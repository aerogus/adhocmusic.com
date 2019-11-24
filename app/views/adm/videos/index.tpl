{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Vidéos</h1>
  </header>
  <div class="reset">

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

<table class="table table--zebra" id="tab-groupes">
  <thead>
    <tr>
      <th>Vidéo</th>
      <th>Groupe</th>
      <th>Évènement</th>
      <th>Lieu</th>
      <th>Créa</th>
      <th>Modif</th>
    </tr>
  </thead>
  <tbody>
  {foreach from=$videos item=video}
    <tr>
      <td>{$video->getId()}<br/><img src="{$video->getThumbUrl(80)}" alt=""/><br/>{$video->getName()|escape}</td>
      <td>{if ($video->getIdGroupe())}<a href="{$video->getGroupe()->getUrl()}">{$video->getGroupe()->getName()|escape}</a>{/if}</td>
      <td>{if ($video->getIdEvent())}<a href="{$video->getEvent()->getUrl()}">{$video->getEvent()->getName()|escape}</a><br/>{$video->getEvent()->getDate()|date_format:'%d/%m/%Y'}{/if}</td>
      <td>{if ($video->getIdLieu())}<a href="{$video->getLieu()->getUrl()}">{$video->getLieu()->getName()|escape}</a><br>{$video->getLieu()->getIdDepartement()} {$video->getLieu()->getCity()->getName()}{/if}</td>
      <td>{$video->getCreatedOn()|date_format:'%d/%m/%Y'}</td>
      <td>{$video->getModifiedOn()|date_format:'%d/%m/%Y'}</td>
    </tr>
  {/foreach}
  </tbody>
</table>

  </div>
</div>

{include file="common/footer.tpl"}
