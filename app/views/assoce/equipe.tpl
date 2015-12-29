{include file="common/header.tpl" swfobject=true}

<div class="grid-2-1">

  <div>

    <div class="box">
      <header>
        <h1>L'Equipe</h1>
      </header>
      <div>
        <p>Voici les forces actives de l'association pour la saison 2015/2016</p>
        <ul class="staff">
          {foreach from=$membres item=membre}
          <li>
            <a href="{$membre.url|escape}">
              <div class="thumb-80 thumb-photo-80">
                <img src="{$membre.avatar_interne|escape}" alt="" style="width: 80px; height: 80px;">
                <p align="center"><strong>{$membre.official_pseudo|escape}</strong></p>
              </div>
              <div>
                <strong>{$membre.first_name|escape} {$membre.last_name|escape}</strong><br>
                <em>{$membre.function|escape}</em><br>
                {$membre.age|escape} ans<br>
                {$membre.description|escape}
              </div>
            </a>
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
        <p>De 1996 à aujourd'hui, beaucoup de monde a participé à l'aventure AD'HOC de près ou de loin. Qu'ils en soient tous remerciés</p>
        <ul class="staff">
          {foreach from=$omembres item=membre}
          <li>
            <a href="{$membre.url|escape}">
              <div class="thumb-80 thumb-photo-80">
                <img src="{$membre.avatar_interne|escape}" alt="" style="width: 80px; height: 80px;">
                <p align="center"><strong>{$membre.official_pseudo|escape}</strong></p>
              </div>
              <div>
                <strong>{$membre.first_name|escape} {$membre.last_name|escape}</strong><br>
                <em>{$membre.function|escape}</em><br>
                De {$membre.datdeb|date_format:'%Y'} à {$membre.datfin|date_format:'%Y'}<br>
                {$membre.description|escape}
              </div>
            </a>
          </li>
          {/foreach}
        </ul>
      </div>
    </div>

  </div>

  <div>
  {include file="assoce/sidebar.inc.tpl"}
  </div>

</div>

{include file="common/footer.tpl"}
