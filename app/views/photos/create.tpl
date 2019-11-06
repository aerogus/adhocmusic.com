{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Ajouter une ou des photo(s)</h1>
  </header>
  <div>
    <form id="form-photo-create" name="form-photo-create" method="post" action="/photos/create" enctype="multipart/form-data">
      <ul>
        <li>
          <label for="file[]">Photo(s) (.jpg)</label>
          <div class="infobulle error" id="error_file"{if empty($error_file)} style="display: none"{/if}>Vous devez sélectionner une ou des photo(s)</div>
          <input type="file" name="file[]" id="file" value="" multiple>
          <div class="infobulle info">En cas de photos multiples, les données suivantes sont communes</div>
        </li>
        <li>
          <label for="name">Titre</label>
          <div class="infobulle error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez saisir un titre pour la/les photo(s)</div>
          <input type="text" id="name" name="name" placeholder="Titre" size="50" value="">
        </li>
        <li>
          <label for="credits">Photographe</label>
          <div class="infobulle error" id="error_credits"{if empty($error_credits)} style="display: none"{/if}>Vous devez saisir le nom du photographe pour cette/ces photo(s)</div>
          <input type="text" id="credits" name="credits" placeholder="Photographe" size="50" value="">
        </li>
        <li>
          <label for="id_groupe">Groupe</label>
        {if !empty($groupe)}
          <input type="hidden" name="id_groupe" value="{$groupe->getId()}">
          <span>{$groupe->getName()}</span>
        {else}
          <div class="infobulle error" id="error_id_groupe"{if empty($error_id_groupe)} style="display: none"{/if}>Vous devez lier cette/ces photo(s) à un groupe, un lieu ou un événement</div>
          <select id="id_groupe" name="id_groupe">
            <option value="0">Aucun</option>
            {foreach $groupes as $groupe}
            <option value="{$groupe.id}">{$groupe.name|escape}</option>
            {/foreach}
          </select>
        {/if}
        </li>
        <li>
          <label for="id_lieu">Lieu</label>
        {if !empty($lieu)}
          <input type="hidden" name="id_lieu" value="{$lieu->getId()}">
          <span>{$lieu->getName()}</span>
        {else}
          <select id="id_lieu" name="id_lieu">
            <optgroup label="Autre">
              <option value="0">aucun / non référencé</option>
            </optgroup>
            {foreach from=$deps item=dep}
            <optgroup label="{$dep->getId()} - {$dep->getName()|escape}">
              {foreach from=$lieux[$dep->getId()] item=lieu}
              <option value="{$lieu.id}">{$lieu.cp} {$lieu.city|escape} : {$lieu.name|escape}</option>
              {/foreach}
            </optgroup>
            {/foreach}
          </select>
        {/if}
        </li>
        <li>
          <label for="id_event">Evénement</label>
        {if !empty($event)}
          <input type="hidden" name="id_event" value="{$event->getId()}">
          <span style="float: right;">{$event->getDate()} - {$event->getName()}</span>
        {else}
          <select id="id_event" name="id_event">
            <option value="0">Aucun</option>
          </select>
        {/if}
        </li>
        <li>
          <label for="online">Afficher publiquement</label>
          <input class="switch" type="checkbox" name="online" checked="checked">
        </li>
      </ul>
      <input id="form-photo-create-submit" name="form-photo-create-submit" class="button" type="submit" value="Enregistrer">
    </form>
  </div>
</div>

{include file="common/footer.tpl"}
