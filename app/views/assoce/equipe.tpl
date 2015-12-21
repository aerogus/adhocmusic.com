{include file="common/header.tpl" swfobject=true}

<div id="right">

{include file="assoce/sidebar.inc.tpl"}

</div>

<div id="left-center">

{include file="common/boxstart.tpl" boxtitle="L'Equipe actuelle"}

<p>Voici les forces actives de l'association pour la saison 2015/2016</p>
<ul id="staff">
  {foreach from=$membres item=membre}
  <li class="staff-member">
    <a href="{$membre.url|escape}">
      <div class="thumb-80 thumb-photo-80" style="margin-right: 15px;">
        <img src="{$membre.avatar_interne|escape}" alt="" style="width: 80px; height: 80px;" />
        <p align="center"><strong>{$membre.official_pseudo|escape}</strong></p>
      </div>
      <strong>{$membre.first_name|escape} {$membre.last_name|escape}</strong><br />
      <em>{$membre.function|escape}</em><br />
      {$membre.age|escape} ans<br />
      {$membre.description|escape}
    </a>
  </li>
  {/foreach}
</ul>

{include file="common/boxend.tpl"}

{include file="common/boxstart.tpl" boxtitle="Les anciens"}

<p>De 1996 à aujourd'hui, beaucoup de monde a participé à l'aventure AD'HOC de près ou de loin. Qu'ils en soient remerciés</p>
<ul id="old-staff">
  {foreach from=$omembres item=membre}
  <li class="staff-member">
    <a href="{$membre.url|escape}">
      <div class="thumb-80 thumb-photo-80" style="margin-right: 15px;">
        <img src="{$membre.avatar_interne|escape}" alt="" style="width: 80px; height: 80px;" />
        <p align="center"><strong>{$membre.official_pseudo|escape}</strong></p>
      </div>
      <strong>{$membre.first_name|escape} {$membre.last_name|escape}</strong><br />
      <em>{$membre.function|escape}</em><br />
      De {$membre.datdeb|date_format:'%Y'} à {$membre.datfin|date_format:'%Y'}<br />
      {$membre.description|escape}
    </a>
  </li>
  {/foreach}
</ul>

{include file="common/boxend.tpl"}

</div>

{include file="common/footer.tpl"}
