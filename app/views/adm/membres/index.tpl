{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Membres</h1>
  </header>
  <div class="reset">

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page link_base_params=$link_base_params}

<fieldset style="width: 160px; float: left;">
  <form id="form-member-search" name="form-member-search" method="get">
    <legend>Recherche</legend>
    <ol>
      <li>
        <label for="pseudo">Pseudo</label>
        <input type="text" id="pseudo" name="pseudo" value="{$search.pseudo|escape}" style="width: 100px;" />
      </li>
      <li>
        <label for="last_name">Nom</label>
        <input type="text" id="last_name" name="last_name" value="{$search.last_name|escape}" style="width: 100px;" />
      </li>
      <li>
        <label for="first_name">Prénom</label>
        <input type="text" id="first_name" name="first_name" value="{$search.first_name|escape}" style="width: 100px;" />
      </li>
      <li>
        <label for="email">Email</label>
        <input type="text" id="email" name="email" value="{$search.email|escape}" style="width: 100px;" />
      </li>
      {*
      <li>
        <label for="with_groupe">Avec groupe</label>
        <input type="checkbox" id="with_groupe" name="with_groupe" checked="{$search.with_groupe|escape}" />
      </li>
      <li>
        <label for="id_type_membre">Membre de type</label>
        <select id="id_type_membre" name="id_type_membre">
          {foreach from=$types_membre key=type_membre_id item=type_membre_name}
          <option value="{$type_membre_id|escape}">{$type_membre_name|escape}</option>
          {/foreach}
        </select>
      </li>
      <li>
        <label for="id_type_musicien">Musicien de type</label>
        <select id="id_type_musicien" name="id_type_musicien">
          {foreach from=$types_musicien item=type_musicien}
          <option value="{$type_musicien->getId()|escape}">{$type_musicien->getName()|escape}</option>
          {/foreach}
        </select>
      </li>
      *}
    </ol>
    <input type="submit" class="button" value="Rechercher" />
  </form>
</fieldset>

<table class="table table--zebra" id="tab-members" style="width: 720px; float: right;">

  <thead>
    <tr>
      <th><a href="/adm/membres/?sort=id&amp;sens={$sensinv}&amp;page={$page}">Id</a></th>
      <th><a href="/adm/membres/?sort=pseudo&amp;sens={$sensinv}&amp;page={$page}">Pseudo</a></th>
      <th><a href="/adm/membres/?sort=last_name&amp;sens={$sensinv}&amp;page={$page}">Nom</a></th>
      <th><a href="/adm/membres/?sort=first_name&amp;sens={$sensinv}&amp;page={$page}">Prénom</a></th>
      <th><a href="/adm/membres/?sort=email&amp;sens={$sensinv}&amp;page={$page}">Email</a></th>
      <th><a href="/adm/membres/?sort=created_on&amp;sens={$sensinv}&amp;page={$page}">Créa</a></th>
      <th><a href="/adm/membres/?sort=modified_on&amp;sens={$sensinv}&amp;page={$page}">Modif</a></th>
      <th><a href="/adm/membres/?sort=visited_on&amp;sens={$sensinv}&amp;page={$page}">Visite</a></th>
      <th><a href="/adm/membres/?sort=lastnl&amp;sens={$sensinv}&amp;page={$page}">LastNl</a></th>
    </tr>
  </thead>

  {include file="adm/membres/index-res.tpl"}

</table>

<br style="clear: both;" />

  </div>
</div>

{include file="common/footer.tpl"}
