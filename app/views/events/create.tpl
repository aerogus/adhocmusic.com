{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Ajouter une date"}

<form name="form-event-create" id="form-event-create" action="/events/create" enctype="multipart/form-data" method="post">
  <fieldset id="bloc-lieu">
    <legend>Infos sur le lieu</legend>
    {if !empty($lieu)}
    <strong>{$lieu->getName()}</strong><br>
    {$lieu->getAddress()}<br>
    {$lieu->getCp()} {$lieu->getCity()}<br>
    {$lieu->getCountry()}
    <input type="hidden" id="id_lieu" name="id_lieu" value="{$lieu->getId()|escape}">
    {else}
    <ol>
      <li>
        <div class="error" id="error_id_lieu"{if empty($error_id_lieu)} style="display: none"{/if}>Vous devez indiquer un lieu pour l'événement ou le saisir s'il n'est pas encore référencé.</div>
        <select id="id_country" name="id_country" style="float: right;">
          <option value="0">---</option>
          {foreach from=$countries key=id item=name}
          <option value="{$id}"{if $id == $data.id_country} selected="selected"{/if}>{$name.fr|escape}</option>
          {/foreach}
        </select>
        <label for="id_country">Pays</label>
      </li>
      <li>
        <select id="id_region" name="id_region" style="float: right;">
          <option value="0"></option>
        </select>
        <label for="id_region">Région</label>
      <li>
        <select id="id_departement" name="id_departement" style="float: right;">
          <option value="0"></option>
        </select>
        <label for="id_departement">Département</label>
      </li>
      <li>
        <select id="id_city" name="id_city" style="float: right;">
          <option value="0"></option>
        </select>
        <label for="id_city">Ville</label>
      </li>
      <li>
        <select id="id_lieu" name="id_lieu" style="float: right;">
          <option value="0"></option>
        </select>
        <label for="id_lieu">Lieu</label>
      </li>
      <li>
        <p>Pas dans la liste ? <a href="/lieux/create">Créer le lieu</a></p>
      </li>
    </ol>
    {/if}
  </fieldset>
  <fieldset id="bloc-groupes">
  <legend>Artistes</legend>
  <ol>
    <li>
      <span style="float: right;">
        <ul>
          {section name=cpt_groupe loop=3}
          <li>
            <select id="groupe" name="groupe[{$smarty.section.cpt_groupe.index}]">
              <option value="0">-- Choix d'un groupe --</option>
              {foreach from=$groupes item=groupe}
              <option value="{$groupe.id|escape}"{if $data.groupes.0 == $groupe.id} selected="selected"{/if}>{$groupe.name|escape}</option>
              {/foreach}
            </select>
          </li>
          {/section}
        </ul>
      </span>
      <label for="groupe">Groupe(s) AD'HOC</label>
    </li>
  </ol>
  </fieldset>
  <fieldset id="bloc-event">
    <legend>Infos sur l'événement</legend>
    <ol>
      <li>
        <div class="error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez indiquer un titre pour l'événement.</div>
        <input id="name" name="name" style="float: right; width: 360px;" value="{$data.name|escape}">
        <label for="name">Titre</label>
      </li>
      <li>
        <span style="float: right;">
          <input type="text" id="date" name="date" value="{$data.date.date|date_format:'%d/%m/%Y'}" style="width: 100px; background: url(/img/icones/event.png) no-repeat right top;">
          <select id="hourminute" name="hourminute">{html_input_date_hourminute hour=$data.date.hour minute=$data.date.minute}</select>
        </span>
        <label for="date">Date</label>
      </li>
      <li>
        <div class="error" id="error_text"{if empty($error_text)} style="display: none"{/if}>Vous devez mettre une description pour cet événement.</div>
        <textarea name="text" id="text" cols="40" rows="10" style="float: right;">{$data.text|escape}</textarea>
        <label for="text">Description</label>
      </li>
      <li>
        <div class="error" id="error_price"{if empty($error_price)} style="display: none"{/if}>Vous devez écrire les tarifs de l'entrée.</div>
        <textarea name="price" id="price" cols="40" rows="2"  style="float: right;">{$data.price|escape}</textarea>
        <label for="price">Tarifs (Entrée, Bar, Vestiaire ...)</label>
      </li>
      <li>
        <input type="file" id="flyer" name="flyer" style="float: right;" value="{$data.file|escape}">
        <label for="flyer">Flyer (.jpg)</label>
      </li>
      <li>
        <input type="text" id="flyer_url" name="flyer_url" style="float: right;" value="{$data.flyer_url|escape}">
        <label for="flyer_url">ou Flyer (url)</label>
      </li>
      {*
      <li>
        <span style="float: right;">
        <ul>
          {section name=cpt_style loop=3}
          <li>
            <select id="style" name="style[{$smarty.section.cpt_style.index}]"  style="float: right;">
              <option value="0">-- Choix d'un style --</option>
              {foreach from=$styles key=style_id item=style_name}
              <option value="{$style_id|escape}"{if $data.styles.0 == $style_id} selected="selected"{/if}>{$style_name|escape}</option>
              {/foreach}
            </select>
          </li>
          {/section}
        </ul>
        </span>
        <label for="style">Style(s)</label>
      </li>
      *}
      <li>
        <span style="float: right;">
          <ul>
            {section name=cpt_structure loop=3}
            <li>
              <select id="structure" name="structure[{$smarty.section.cpt_structure.index}]">
                <option value="0">-- Choix d'une structure --</option>
                {foreach from=$structures item=structure}
                <option value="{$structure.id|escape}"{if $data.structures.0 == $structure.id} selected="selected"{/if}>{$structure.name|escape}</option>
                {/foreach}
              </select>
            </li>
            {/section}
          </ul>
        </span>
        <label for="structure">Organisateur(s)</label>
      </li>
    </ol>
  </fieldset>

  <div class="success">Nouveau: liez cet événement à un événement Facebook existant ou bien créez directement un événement Facebook !</div>
  <fieldset>
    <legend>Facebook</legend>
    <ol>
      <li>
        <span style="float: right;">
          http://www.facebook.com/events/<input id="facebook_event_id" name="facebook_event_id" style="width: 360px;" value="{$data.facebook_event_id|escape}">/
        </span>
        <label for="facebook_event_id">n° Evénement (si déjà existant sur Facebook)</label>
      </li>
      <li>
        <input type="checkbox" id="facebook_event_create" name="facebook_event_create" disabled="disabled" style="float: right;">
        <label for="facebook_event_create">Créer l'événement sur Facebook (si non existant)</label>
      </li>
    </ol>
  </fieldset>
  <fieldset>
    <legend>Annoncer plusieurs événements</legend>
    <ol>
      <li>
        <input style="float: right;" type="checkbox" id="more-event" name="more-event"{if !empty($data.more_event)} selected="selected"{/if}>
        <label for="more-event">Ajouter un autre événement pour le même lieu</label>
      </li>
    </ol>
  </fieldset>
  <input id="form-event-create-submit" name="form-event-create-submit" class="button" type="submit" value="Ajouter">
</form>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
