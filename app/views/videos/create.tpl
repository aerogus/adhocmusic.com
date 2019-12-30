{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Ajouter une vidéo</h1>
  </header>
  <div>
    <form id="form-video-create" name="form-video-create" method="post" action="/videos/create">
      <ul>
        <li>
          <div class="infobulle error" id="error_code"{if empty($error_code)} style="display: none"{/if}>Vous devez copier/coller un code de vidéo</div>
          <div class="infobulle error" id="error_unknown_host"{if empty($error_unknow_host)} style="display: none"{/if}>Code de la vidéo non reconnu ou hébergeur incompatible</div>
          <label for="code">Url de la vidéo (*)</label>
          <input type="text" id="code" name="code" size="50" value="">
        </li>
        <li>
          <label for="name">Titre (*)</label>
          <div class="infobulle error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez saisir un titre pour la vidéo</div>
          <input type="text" id="name" name="name" size="50" value="">
          <div id="thumb" class="pts"></div>
        </li>
        <li>
          <label for="id_groupe">Groupe</label>
          {if !empty($groupe)}
          <input type="hidden" name="id_groupe" value="{$groupe->getId()}">
          <span>{$groupe->getName()}</span>
          {else}
          <div class="infobulle error" id="error_id_groupe"{if empty($error_id_groupe)} style="display: none"{/if}>Vous devez lier cette vidéo à soit un groupe, soit un lieu, soit un événement</div>
          <select id="id_groupe" name="id_groupe">
            <option value="0">Aucun</option>
            {foreach $groupes as $groupe}
            <option value="{$groupe->getIdGroupe()}">{$groupe->getName()|escape}</option>
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
              <option value="{$lieu->getIdLieu()}">{$lieu->getCity()->getCp()} {$lieu->getCity()->getName()|escape} : {$lieu->getName()|escape}</option>
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
          <span >{$event->getDate()} - {$event->getName()}</span>
          {else}
          <select id="id_event" name="id_event">
            <option value="0">Veuillez sélectionner un lieu</option>
          </select>
          {/if}
        </li>
        <li>
          <label for="online">Afficher publiquement</label>
          <input class="switch" type="checkbox" name="online" checked="checked">
        </li>
      </ul>
      <input id="form-video-create-submit" name="form-video-create-submit" class="button" type="submit" value="Enregistrer">
    </form>
  </div>
</div>

{include file="common/footer.tpl"}
