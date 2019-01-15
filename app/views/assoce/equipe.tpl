{include file="common/header.tpl"}

<div class="grid-2-small-1 has-gutter-l">

  <div class="two-thirds">

    <div class="box">
      <header>
        <h1>L'Equipe</h1>
      </header>
      <div>
        <p>Voici les forces actives de l'association pour la saison 2018/2019</p>
        <ul class="staff">
          {foreach from=$membres item=membre}
          <li>
            <img src="{$membre.avatar_interne|escape}" alt="">
            <strong>{$membre.first_name|escape} {$membre.last_name|escape}</strong><br>
            <em>{$membre.function|escape}</em>
          </li>
          {/foreach}
        </ul>
      </div>
    </div>

    <div class="box">
      <header>
        <h1>Les anciens</h1>
      </header>
      <div>
        <p>De 1996 à aujourd'hui, nombre de bénévoles ont participé à l'aventure AD'HOC de près ou de loin. Qu'ils en soient remerciés:</p>
        <p>
          {foreach from=$omembres item=membre}
          <strong>{$membre.first_name|escape} {$membre.last_name|escape}</strong> ({$membre.datdeb|date_format:'%Y'} à {$membre.datfin|date_format:'%Y'}),
          {/foreach}
          et <strong>Francisque Vigouroux</strong> (1996 à 2002).
        </p>
      </div>
    </div>

  </div>

  <div class="one-third">
  {include file="assoce/_sidebar.tpl"}
  </div>

</div>

{include file="common/footer.tpl"}
