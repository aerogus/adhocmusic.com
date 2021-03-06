{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Ajouter une vidéo</h1>
  </header>
  <div>
    <form id="form-video-create" name="form-video-create" method="post" action="/videos/create">
      <section class="grid-4">
        <div>
          <label for="code">Url de la vidéo (*)</label>
        </div>
        <div class="col-3 mbs">
          <div class="infobulle error" id="error_code"{if empty($error_code)} style="display: none"{/if}>Vous devez copier/coller un code de vidéo</div>
          <div class="infobulle error" id="error_unknown_host"{if empty($error_unknow_host)} style="display: none"{/if}>Code de la vidéo non reconnu ou hébergeur incompatible</div>
          <input type="text" id="code" name="code" class="w100" value="">
        </div>
        <div>
          <label for="name">Titre (*)</label>
        </div>
        <div class="col-3 mbs">
          <div class="infobulle error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez saisir un titre pour la vidéo</div>
          <input type="text" id="name" name="name" class="w100" value="">
        </div>
        <div>
          <label for="thumb">Prévisualisation</label>
        </div>
        <div class="col-3 mbs">
          <div id="thumb"></div>
        </div>
        <div>
          <label for="ids_groupe[0]">Groupe(s)</label>
        </div>
        <div class="col-3 mbs">
          <div class="infobulle error" id="error_id_groupe"{if empty($error_id_groupe)} style="display: none"{/if}>Vous devez lier cette vidéo à soit un groupe, soit un lieu, soit un événement</div>
          {section name=cpt_groupe loop=5}
          <select id="ids_groupe[{$smarty.section.cpt_groupe.index}]" name="ids_groupe[{$smarty.section.cpt_groupe.index}]" class="w100 mbs">
            <option value="">-- Choix d'un groupe --</option>
            {foreach from=$groupes item=groupe}
            <option value="{$groupe->getId()|escape}"{if ($smarty.section.cpt_groupe.index === 0) && $groupe->getId() === $id_groupe} selected="selected"{/if}>{$groupe->getName()|escape}</option>
            {/foreach}
          </select>
          {/section}
        </div>
        <div>
          <label for="id_lieu">Lieu</label>
        </div>
        <div class="col-3 mbs">
          {if !empty($lieu)}
          <input type="hidden" name="id_lieu" value="{$lieu->getId()}">
          <span>{$lieu->getName()}</span>
          {else}
          <select id="id_lieu" name="id_lieu" class="w100">
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
        </div>
        <div>
          <label for="id_event">Evénement</label>
        </div>
        <div class="col-3 mbs">
          {if !empty($event)}
          <input type="hidden" name="id_event" value="{$event->getId()}">
          <span >{$event->getDate()} - {$event->getName()}</span>
          {else}
          <select id="id_event" name="id_event" class="w100">
            <option value="0">Veuillez sélectionner un lieu</option>
          </select>
          {/if}
        </div>
        <div>
          <label for="online">Rendre public</label>
        </div>
        <div class="col-3 mbs">
          <input class="checkbox" type="checkbox" name="online" checked="checked">
        </div>
        <div></div>
        <div class="col-3">
          <input id="form-video-create-submit" name="form-video-create-submit" class="btn btn--primary w100" type="submit" value="Enregistrer">
        </div>
      </section>
    </form>
  </div>
</div>

{include file="common/footer.tpl"}
