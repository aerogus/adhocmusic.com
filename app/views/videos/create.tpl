{include file="common/header.tpl"}

<div class="box">
  <header>
    <h2>Ajouter une vidéo</h2>
  </header>
  <div>

<form id="form-video-create" name="form-video-create" method="post" action="/videos/create">
  <ul>
    <li>
      <div class="infobulle error" id="error_code"{if empty($error_code)} style="display: none"{/if}>Vous devez copier/coller un code de vidéo</div>
      <div class="infobulle error" id="error_unknown_host"{if empty($error_unknow_host)} style="display: none"{/if}>Code de la vidéo non reconnu ou hébergeur incompatible</div>
      <input type="text" id="code" name="code" size="50" value="" style="float: right;">
      <label for="code">Url de la vidéo</label>
    </li>
    <li>
      <div class="infobulle error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez saisir un titre pour la vidéo</div>
      <input type="text" id="name" name="name" size="50" value="" style="float: right;">
      <label for="name">Titre</label>
    </li>
    <li>
    {if !empty($groupe)}
      <input type="hidden" name="id_groupe" value="{$groupe->getId()}">
      <span style="float: right">{$groupe->getName()}</span>
    {else}
      <div class="infobulle error" id="error_id_groupe"{if empty($error_id_groupe)} style="display: none"{/if}>Vous devez lier cette vidéo à soit un groupe, soit un lieu, soit un événement</div>
      <select id="id_groupe" name="id_groupe" style="float: right">
        <option value="0">Aucun</option>
        {foreach $groupes as $groupe}
        <option value="{$groupe.id}">{$groupe.name|escape}</option>
        {/foreach}
      </select>
    {/if}
      <label for="id_groupe">Groupe</label>
    </li>
    <li>
    {if !empty($lieu)}
      <input type="hidden" name="id_lieu" value="{$lieu->getId()}">
      <span style="float: right;">{$lieu->getName()}</span>
    {else}
      <select id="id_lieu" name="id_lieu" style="float: right">
        <optgroup label="Autre">
          <option value="0">aucun / non référencé</option>
        </optgroup>
        {foreach from=$dep item=dep_name key=dep_id}
        <optgroup label="{$dep_id} - {$dep_name|escape}">
          {foreach from=$lieux[$dep_id] item=lieu}
          <option value="{$lieu.id}">{$lieu.cp} {$lieu.city|escape} : {$lieu.name|escape}</option>
          {/foreach}
        </optgroup>
        {/foreach}
      </select>
    {/if}
      <label for="id_lieu">Lieu</label>
    </li>
    <li>
    {if !empty($event)}
      <input type="hidden" name="id_event" value="{$event->getId()}">
      <span style="float: right;">{$event->getDate()} - {$event->getName()}</span>
    {else}
      <select id="id_event" name="id_event" style="float: right">
        <option value="0">Veuillez sélectionner un lieu</option>
      </select>
    {/if}
      <label for="id_event">Evénement</label>
    </li>
  </ul>
  <input id="form-video-create-submit" name="form-video-create-submit" class="button" type="submit" value="Enregistrer">
</form>


  </div>
</div>

{include file="common/footer.tpl"}
