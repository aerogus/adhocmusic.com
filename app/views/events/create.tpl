{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Ajouter une date</h1>
  </header>
  <div>

<form name="form-event-create" id="form-event-create" action="/events/create" enctype="multipart/form-data" method="post">
  <fieldset id="bloc-lieu">
    <legend>Lieu</legend>
    {if !empty($lieu)}
    <strong>{$lieu->getName()}</strong><br>
    {$lieu->getAddress()}<br>
    {$lieu->getCp()} {$lieu->getCity()}<br>
    {$lieu->getCountry()}
    <input type="hidden" id="id_lieu" name="id_lieu" value="{$lieu->getId()|escape}">
    {else}
    <ul>
      <li>
        <div class="infobulle error" id="error_id_lieu"{if empty($error_id_lieu)} style="display: none"{/if}>Vous devez indiquer un lieu pour l'événement ou le saisir s'il n'est pas encore référencé.</div>
        <label for="id_country">Pays (*)</label>
        <select id="id_country" name="id_country">
          <option value="">---</option>
        </select>
      </li>
      <li>
        <label for="id_region">Région (*)</label>
        <select id="id_region" name="id_region">
          <option value="">---</option>
        </select>
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
      <li>
        <p>Pas dans la liste ? <a href="/lieux/create">Créer le lieu</a></p>
      </li>
    </ul>
    {/if}
  </fieldset>
  <fieldset id="bloc-groupes">
  <legend>Artistes</legend>
  <ul>
    <li>
      <label for="groupe">Groupe(s)</label>
      <ul>
        {section name=cpt_groupe loop=3}
        <li>
          <select id="groupe" name="groupe[{$smarty.section.cpt_groupe.index}]">
            <option value="">-- Choix d'un groupe --</option>
            {foreach from=$groupes item=groupe}
            <option value="{$groupe->getId()|escape}"{if $data.groupes.0 === $groupe->getId()} selected="selected"{/if}>{$groupe->getName()|escape}</option>
            {/foreach}
          </select>
        </li>
        {/section}
      </ul>
    </li>
  </ul>
  </fieldset>
  <fieldset id="bloc-event">
    <legend>Événement</legend>
    <ul>
      <li>
        <label for="name">Titre (*)</label>
        <div class="infobulle error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez indiquer un titre pour l'événement.</div>
        <input type="text" id="name" name="name" value="{$data.name|escape}">
      </li>
      <li>
        <label for="date">Date (*)</label>
        <input type="text" id="date" name="date" value="{$data.date.date|date_format:'%d/%m/%Y'}">
        <select id="hourminute" name="hourminute">{html_input_date_hourminute hour=$data.date.hour minute=$data.date.minute}</select>
      </li>
      <li>
        <label for="text">Description (*)</label>
        <div class="infobulle error" id="error_text"{if empty($error_text)} style="display: none"{/if}>Vous devez mettre une description pour cet événement.</div>
        <textarea name="text" id="text" cols="40" rows="10">{$data.text|escape}</textarea>
      </li>
      <li>
        <label for="price">Tarifs (Entrée, Bar, Vestiaire ...) (*)</label>
        <div class="infobulle error" id="error_price"{if empty($error_price)} style="display: none"{/if}>Vous devez écrire les tarifs de l'entrée.</div>
        <textarea name="price" id="price" cols="40" rows="2">{$data.price|escape}</textarea>
      </li>
      <li>
        <label for="flyer">Flyer (.jpg)</label>
        <input type="file" id="flyer" name="flyer" value="{$data.file|escape}">
      </li>
      <li>
        <label for="flyer_url">ou Flyer (url)</label>
        <input type="text" id="flyer_url" name="flyer_url" value="{$data.flyer_url|escape}">
      </li>
      <li>
        <label for="style">Style(s)</label>
        <ul>
        {section name=cpt_style loop=3}
          <li>
            <select id="style" name="style[{$smarty.section.cpt_style.index}]">
              <option value="">-- Choix d'un style --</option>
              {foreach from=$styles item=style}
              <option value="{$style->getId()|escape}"{if $data.styles.0 === $style->getId()} selected="selected"{/if}>{$style->getName()|escape}</option>
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
              <option value="{$structure->getId()|escape}"{if $data.structures.0 == $structure->getId()} selected="selected"{/if}>{$structure->getName()|escape}</option>
              {/foreach}
            </select>
          </li>
          {/section}
        </ul>
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
  <fieldset>
    <legend>Annoncer plusieurs événements</legend>
    <ul>
      <li>
        <label for="more-event">Ajouter un autre événement pour le même lieu</label>
        <input type="checkbox" id="more-event" name="more-event"{if !empty($data.more_event)} selected="selected"{/if}>
      </li>
    </ul>
  </fieldset>
  <input id="form-event-create-submit" name="form-event-create-submit" class="button" type="submit" value="Ajouter">
</form>

  </div>
</div>

<script>
var lieu = {
    id: 1,
    id_country: 'FR',
    id_region: 'A8',
    id_departement: '91',
    id_city: 91216
};
</script>

{include file="common/footer.tpl"}
