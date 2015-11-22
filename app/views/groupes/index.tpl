{include file="common/header.tpl"}

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
