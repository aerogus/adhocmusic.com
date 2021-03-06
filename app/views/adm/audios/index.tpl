{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Audios</h1>
  </header>
  <div class="reset">

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

<table class="table table--zebra" id="tab-groupes">
  <thead>
    <tr>
      <th>Audio</th>
      <th>Groupe</th>
      <th>Évènement</th>
      <th>Lieu</th>
      <th>Créa</th>
      <th>Modif</th>
    </tr>
  </thead>
  <tbody>
  {foreach from=$audios item=audio}
    <tr>
      <td>{$audio->getId()}<br/><img src="{$audio->getThumbUrl(80)}" alt=""/><br/>{$audio->getName()|escape}</td>
      <td>{if ($audio->getIdGroupe())}<a href="{$audio->getGroupe()->getUrl()}">{$audio->getGroupe()->getName()|escape}</a>{/if}</td>
      <td>{if ($audio->getIdEvent())}<a href="{$audio->getEvent()->getUrl()}">{$audio->getEvent()->getName()|escape}</a><br/>{$audio->getEvent()->getDate()|date_format:'%d/%m/%Y'}{/if}</td>
      <td>{if ($audio->getIdLieu())}<a href="{$audio->getLieu()->getUrl()}">{$audio->getLieu()->getName()|escape}</a><br>{$audio->getLieu()->getIdDepartement()} {$audio->getLieu()->getCity()->getName()}{/if}</td>
      <td>{$audio->getCreatedAt()|date_format:'%d/%m/%Y'}</td>
      <td>{$audio->getModifiedAt()|date_format:'%d/%m/%Y'}</td>
    </tr>
  {/foreach}
  </tbody>
</table>

  </div>
</div>

{include file="common/footer.tpl"}
