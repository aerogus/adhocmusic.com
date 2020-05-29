{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Éditer une date</h1>
  </header>
  <div>

<form name="form-event-edit" id="form-event-edit" action="/events/edit" enctype="multipart/form-data" method="post">
  <fieldset>
    <legend>Lieu</legend>
    <ul>
      <li>
        <label for="id_country">Pays (*)</label>
        <div class="infobulle error" id="error_id_lieu"{if empty($error_id_lieu)} style="display: none"{/if}>Vous devez indiquer un lieu pour l'événement ou le saisir s'il n'est pas encore référencé.</div>
        <select id="id_country" name="id_country">
          <option value="">---</option>
        </select>
      </li>
      <li>
        <label for="id_region">Région (*)</label>
        <select id="id_region" name="id_region">
          <option value="">---</option>
        </select>
      </li>
      <li>
        <label for="id_departement">Département (*)</label>
        <select id="id_departement" name="id_departement">
          <option value="">---</option>
        </select>
      </li>
      <li>
        <label for="id_city">Ville (*)</label>
        <select id="id_city" name="id_city">
          <option value="">---</option>
        </select>
      </li>
      <li>
        <label for="id_lieu">Lieu (*)</label>
        <select id="id_lieu" name="id_lieu">
          <option value="">---</option>
        </select>
      </li>
    </ul>
  </fieldset>
  <fieldset>
    <legend>Événement</legend>
    <ul>
      <li>
        <label for="name">Titre (*)</label>
        <div class="infobulle error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez indiquer un titre pour l'événement.</div>
        <input type="text" id="name" name="name" value="{$event->getName()|escape}">
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
        <label for="price">Tarifs (Entrée, Bar, Vestiaire...)</label>
        <div class="infobulle error" id="error_price"{if empty($error_price)} style="display: none"{/if}>Vous devez écrire les tarifs de l'entrée.</div>
        <textarea id="price" name="price" cols="40" rows="2">{$event->getPrice()|escape}</textarea>
      </li>
      <li>
        <label for="flyer">Flyer (.jpg)</label>
        <input type="file" id="flyer" name="flyer" value="{$data.file|escape}">
        {if $event->getThumbUrl()}
        <br><img src="{$event->getThumbUrl(320)}" alt="">
        {/if}
      </li>
      <li>
        <input type="text" id="flyer_url" name="flyer_url" value="{$data.flyer_url|escape}">
        <label for="flyer_url">ou Flyer (url)</label>
      </li>
      <li>
        <label for="style">Style(s)</label>
        <ul>
          {assign var=event_styles value=$event->getStyles()}
          {section name=cpt_style loop=3}
          <li>
            <select id="style" name="style[{$smarty.section.cpt_style.index}]">
              <option value="">-- Choix d'un style --</option>
              {foreach from=$styles item=style}
              <option value="{$style->getId()|escape}" {if $event_styles[$smarty.section.cpt_style.index] && ($event_styles[$smarty.section.cpt_style.index]->getId() === $style->getId())} selected="selected"{/if}>{$style->getName()|escape}</option>
              {/foreach}
            </select>
          </li>
          {/section}
        </ul>
      </li>
      <li>
        <label for="groupe">Artistes</label>
        <ul>
          {assign var=event_groupes value=$event->getGroupes()}
          {section name=cpt_groupe loop=5}
          <li>
            <select id="groupe" name="groupe[{$smarty.section.cpt_groupe.index}]">
              <option value="">-- Choix d'un groupe --</option>
              {foreach from=$groupes item=groupe}
              <option value="{$groupe->getId()|escape}"{if $event_groupes[$smarty.section.cpt_groupe.index] && ($event_groupes[$smarty.section.cpt_groupe.index]->getId() === $groupe->getIdGroupe())} selected="selected"{/if}>{$groupe->getName()|escape}</option>
              {/foreach}
            </select>
          </li>
          {/section}
        </ul>
      </li>
      <li>
        <label for="structure">Organisateur(s)</label>
        <ul>
          {assign var=event_structures value=$event->getStructures()}
          {section name=cpt_structure loop=3}
          <li>
            <select id="structure" name="structure[{$smarty.section.cpt_structure.index}]">
              <option value="">-- Choix d'une structure --</option>
              {foreach from=$structures item=structure}
              <option value="{$structure->getId()|escape}"{if $event_structures[$smarty.section.cpt_structure.index] && ($event_structures[$smarty.section.cpt_structure.index]->getId() === $structure->getId())} selected="selected"{/if}>{$structure->getName()|escape}</option>
              {/foreach}
            </select>
          </li>
          {/section}
        </ul>
      </li>
      <li>
        <label for="online">Afficher</label>
        <input type="checkbox" class="switch" id="online" name="online" {if $event->getOnline()}checked="checked"{/if}>
      </li>
    </ul>
  </fieldset>
  <fieldset>
    <legend>Facebook</legend>
    <ul>
      <li>
        <label for="facebook_event_id">n° Evénement (si déjà existant sur Facebook)</label>
        <span>
          https://www.facebook.com/events/<input id="facebook_event_id" type="text" name="facebook_event_id" value="{$data.facebook_event_id|escape}">
        </span>
      </li>
    </ul>
  </fieldset>
  <input id="form-event-edit-submit" name="form-event-edit-submit" class="btn btn--primary" type="submit" value="Modifier">
  <input type="hidden" name="id" value="{$data.id|escape}">
</form>

  </div>
</div>

{include file="common/footer.tpl"}
