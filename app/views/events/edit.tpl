{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Éditer une date</h1>
  </header>
  <div>

<form name="form-event-edit" id="form-event-edit" action="/events/edit" enctype="multipart/form-data" method="post">
  <fieldset>
    <legend>Infos sur le lieu</legend>
    <ul>
      <li>
        <label for="id_country">Pays</label>
        <div class="infobulle error" id="error_id_lieu"{if empty($error_id_lieu)} style="display: none"{/if}>Vous devez indiquer un lieu pour l'événement ou le saisir s'il n'est pas encore référencé.</div>
        <select id="id_country" name="id_country">
          <option value="">---</option>
        </select>
      </li>
      <li>
        <label for="id_region">Région</label>
        <select id="id_region" name="id_region">
          <option value="">---</option>
        </select>
      </li>
      <li>
        <label for="id_departement">Département</label>
        <select id="id_departement" name="id_departement">
          <option value="">---</option>
        </select>
      </li>
      <li>
        <label for="id_city">Ville</label>
        <select id="id_city" name="id_city">
          <option value="">---</option>
        </select>
      </li>
      <li>
        <label for="id_lieu">Lieu</label>
        <select id="id_lieu" name="id_lieu">
          <option value="">---</option>
        </select>
      </li>
    </ul>
  </fieldset>
  <fieldset>
    <legend>Infos sur l'événement</legend>
    <ul>
      <li>
        <label for="name">Titre</label>
        <div class="infobulle error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez indiquer un titre pour l'événement.</div>
        <input id="name" name="name" value="{$event->getName()|escape}">
      </li>
      <li>
        <label for="date">Date</label>
        <input type="text" id="date" name="date" value="{$event->getDate()|date_format:'%d/%m/%Y'}">
        <select id="hourminute" name="hourminute">{html_input_date_hourminute hour=$event->getHour() minute=$event->getMinute()}</select>
      </li>
      <li>
        <label for="text">Description</label>
        <div class="infobulle error" id="error_text"{if empty($error_text)} style="display: none"{/if}>Vous devez mettre une description pour cet événement.</div>
        <textarea id="text" name="text" cols="40" rows="10">{$event->getText()|escape}</textarea>
      </li>
      <li>
        <label for="price">Tarifs (Entrée, Bar, Vestiaire ...)</label>
        <div class="infobulle error" id="error_price"{if empty($error_price)} style="display: none"{/if}>Vous devez écrire les tarifs de l'entrée.</div>
        <textarea id="price" name="price" cols="40" rows="2">{$event->getPrice()|escape}</textarea>
      </li>
      <li>
        <label for="flyer">Flyer (.jpg)</label>
        <input type="file" id="flyer" name="flyer" value="{$data.file|escape}">
        {if $event->getFullFlyerUrl()}
        <br><img src="{$event->getFlyer320Url()}" alt="">
        {/if}
      </li>
      <li>
        <input type="text" id="flyer_url" name="flyer_url" value="{$data.flyer_url|escape}">
        <label for="flyer_url">ou Flyer (url)</label>
      </li>
      <li>
        <label for="style">Style(s)</label>
        <ul>
          {section name=cpt_style loop=3}
          <li>
            <select id="style" name="style[{$smarty.section.cpt_style.index}]">
              <option value="">-- Choix d'un style --</option>
              {foreach from=$styles key=style_id item=style_name}
              <option value="{$style_id|escape}"{if $event->getStyle(cpt_style) == $style_id} selected="selected"{/if}>{$style_name|escape}</option>
              {/foreach}
            </select>
          </li>
          {/section}
        </ul>
      </li>
      <li>
        <label for="groupe">Groupe(s) AD'HOC</label>
        <ul>
          {section name=cpt_groupe loop=5}
          <li>
            <select id="groupe" name="groupe[{$smarty.section.cpt_groupe.index}]">
              <option value="">-- Choix d'un groupe --</option>
              {foreach from=$groupes item=groupe}
              <option value="{$groupe.id|escape}"{if $event->getGroupeId($smarty.section.cpt_groupe.index) == $groupe.id} selected="selected"{/if}>{$groupe.name|escape}</option>
              {/foreach}
            </select>
          </li>
          {/section}
        </ul>
      </li>
      <li>
        <label for="structure">Organisateur(s)</label>
        <ul>
          {section name=cpt_structure loop=3}
          <li>
            <select id="structure" name="structure[{$smarty.section.cpt_structure.index}]">
              <option value="">-- Choix d'une structure --</option>
              {foreach from=$structures item=structure}
              <option value="{$structure.id|escape}"{if $event->getStructureId($smarty.section.cpt_structure.index) == $structure.id} selected="selected"{/if}>{$structure.name|escape}</option>
              {/foreach}
            </select>
          </li>
          {/section}
        </ul>
      </li>
      <li>
        <label for="online">Afficher</label>
        <input type="checkbox" id="online" name="online" {if $event->getOnline()}checked="checked"{/if}>
      </li>
    </ul>
  </fieldset>
  <div class="infobulle success">Nouveau: liez cet événement à un événement Facebook existant ou bien créez directement un événement Facebook !</div>
  <fieldset>
    <legend>Facebook</legend>
    <ul>
      <li>
        <label for="facebook_event_id">n° Evénement (si déjà existant sur Facebook)</label>
        <span>
          https://www.facebook.com/events/<input id="facebook_event_id" name="facebook_event_id" style="width: 360px;" value="{$event->getFacebookEventId()|escape}">/
        </span>
      </li>
    </ul>
  </fieldset>
  <input id="form-event-edit-submit" name="form-event-edit-submit" class="button" type="submit" value="Modifier">
  <input type="hidden" name="id" value="{$data.id|escape}">
</form>

  </div>
</div>

<script>
var lieu = {
    id: {$lieu->getId()},
    id_country: '{$lieu->getIdCountry()}',
    id_region: '{$lieu->getIdRegion()}',
    id_departement: '{$lieu->getIdDepartement()}',
    id_city: {$lieu->getIdCity()}
};
</script>

{include file="common/footer.tpl"}
