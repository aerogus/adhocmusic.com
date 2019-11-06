{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Ajouter une musique</h1>
  </header>
  <div>
    <form name="form-audio-create" id="form-audio-create" method="post" action="/audios/create" enctype="multipart/form-data">
      <ul>
        <li>
          <div class="infobulle error" id="error_file"{if empty($error_file)} style="display: none"{/if}>Vous devez choisir un fichier .mp3 à uploader</div>
          <label for="file">Audio (*) (.mp3 16bits/44KHz/stéréo, &lt; 16 Mo)</label>
          <input type="file" id="file" name="file" value="">
        </li>
        <li>
          <div class="infobulle error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez renseigner un titre</div>
          <label for="name">Titre (*)</label>
          <input type="text" id="name" name="name" size="50" value="">
        </li>
        <li>
        <label for="groupe">Groupe</label>
        {if !empty($groupe)}
          <input type="hidden" name="id_groupe" value="{$groupe->getId()}">
          <span>{$groupe->getName()}</span>
        {else}
          <div class="infobulle error" id="error_id_groupe"{if empty($error_id_groupe)} style="display: none"{/if}>Vous devez lier cette musique à un groupe, un lieu ou un événement</div>
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
          <label for="id_event">Évènement</label>
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
      <input id="form-audio-create-submit" name="form-audio-create-submit" class="button" type="submit" value="Enregistrer">
    </form>
  </div>
</div>

{include file="common/footer.tpl"}
