{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Membres</h1>
  </header>
  <div class="reset">

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page link_base_params=$link_base_params}

<fieldset>
  <form id="form-member-search" name="form-member-search" method="get">
    <legend>Recherche</legend>
    <ul style="text-align:center">
      <li style="display:inline-block">
        <label for="pseudo">Pseudo</label>
        <input type="text" id="pseudo" placeholder="Pseudo" name="pseudo" value="{$search.pseudo|escape}" style="width: 100px;" />
      </li>
      <li style="display:inline-block">
        <label for="last_name">Nom</label>
        <input type="text" id="last_name" placeholder="Nom" name="last_name" value="{$search.last_name|escape}" style="width: 100px;" />
      </li>
      <li style="display:inline-block">
        <label for="first_name">Prénom</label>
        <input type="text" id="first_name" placeholder="Prénom" name="first_name" value="{$search.first_name|escape}" style="width: 100px;" />
      </li>
      <li style="display:inline-block">
        <label for="email">Email</label>
        <input type="text" id="email" placeholder="Email" name="email" value="{$search.email|escape}" style="width: 100px;" />
      </li>
    </ul>
    <input type="submit" class="btn btn--primary" value="Rechercher" />
  </form>
</fieldset>

<table class="table table--zebra" id="tab-members">

  <thead>
    <tr>
      <th><a href="/adm/membres/?order_by=id&amp;sort={$sortinv}&amp;page={$page}">Id</a></th>
      <th><a href="/adm/membres/?order_by=pseudo&amp;sort={$sortinv}&amp;page={$page}">Pseudo</a></th>
      <th><a href="/adm/membres/?order_by=last_name&amp;sort={$sortinv}&amp;page={$page}">Nom</a></th>
      <th><a href="/adm/membres/?order_by=first_name&amp;sort={$sortinv}&amp;page={$page}">Prénom</a></th>
      <th><a href="/adm/membres/?order_by=email&amp;sort={$sortinv}&amp;page={$page}">Email</a></th>
      <th><a href="/adm/membres/?order_by=created_at&amp;sort={$sortinv}&amp;page={$page}">Créa</a></th>
      <th><a href="/adm/membres/?order_by=modified_at&amp;sort={$sortinv}&amp;page={$page}">Modif</a></th>
      <th><a href="/adm/membres/?order_by=visited_at&amp;sort={$sortinv}&amp;page={$page}">Visite</a></th>
      <th><a href="/adm/membres/?order_by=lastnl&amp;sort={$sortinv}&amp;page={$page}">LastNl</a></th>
    </tr>
  </thead>

  {include file="adm/membres/index-res.tpl"}

</table>

<br style="clear: both;" />

  </div>
</div>

{include file="common/footer.tpl"}
