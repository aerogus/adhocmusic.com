{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Ajouter une musique</h1>
  </header>
  <div>
    <form name="form-audio-create" id="form-audio-create" method="post" action="/audios/create" enctype="multipart/form-data">
      <section class="grid-4">
        <div>
          <label for="file">Audio (*)</label>
        </div>
        <div class="col-3 mbs">
          <div class="infobulle error" id="error_file"{if empty($error_file)} style="display: none"{/if}>Vous devez choisir un fichier .mp3 à uploader</div>
          <input type="file" id="file" name="file" value=""> (.mp3 16bits/44KHz/stéréo, &lt; 16 Mo)
        </div>
        <div>
          <label for="name">Titre (*)</label>
        </div>
        <div class="col-3 mbs">
          <div class="infobulle error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez renseigner un titre</div>
          <input type="text" id="name" name="name" class="w100" value="">
        </div>
        <div>
          <label for="groupe">Groupe</label>
        </div>
        <div class="col-3 mbs">
          {if !empty($groupe)}
            <input type="hidden" name="id_groupe" value="{$groupe->getId()}">
            <span>{$groupe->getName()}</span>
          {else}
            <div class="infobulle error" id="error_id_groupe"{if empty($error_id_groupe)} style="display: none"{/if}>Vous devez lier cette musique à un groupe, un lieu ou un événement</div>
            <select id="id_groupe" name="id_groupe" class="w100">
              <option value="0">Aucun</option>
              {foreach $groupes as $groupe}
              <option value="{$groupe->getIdGroupe()}">{$groupe->getName()|escape}</option>
              {/foreach}
            </select>
          {/if}
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
          <label for="id_event">Évènement</label>
        </div>
        <div class="col-3 mbs">
          {if !empty($event)}
            <input type="hidden" name="id_event" value="{$event->getId()}">
            <span style="float: right;">{$event->getDate()} - {$event->getName()}</span>
          {else}
            <select id="id_event" name="id_event" class="w100">
              <option value="0">Aucun</option>
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
          <input id="form-audio-create-submit" name="form-audio-create-submit" class="btn btn--primary w100" type="submit" value="Enregistrer">
        </div>
      </section>
    </form>
  </div>
</div>

{include file="common/footer.tpl"}
