{include file="common/header.tpl"}

{include file="common/boxstart.tpl" width="; margin-bottom: 10px;"}
<p>Voici la liste des groupes formant le réseau AD'HOC. <a href="/groupes/create">Inscrivez donc votre groupe de musique</a>, c'est gratuit !</p>
{include file="common/boxend.tpl"}

{foreach from=$liste_groupes item=groupes key=key}
  {include file="common/boxstart.tpl" boxtitle=$key|escape}
  <ul class="listgrp">
  {foreach from=$groupes item=groupe}
    {include file="groupes/_groupe.tpl" groupe=$groupe}
  {/foreach}
  </ul>
  <hr class="spacer" />
  {include file="common/boxend.tpl"}
{/foreach}

{include file="common/footer.tpl"}
