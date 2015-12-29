{include file="common/header.tpl"}

{foreach from=$liste_groupes item=groupes key=key}
  <div class="box">
    <header>
      <h2>{$key|escape}</h2>
    </header>
    <ul class="listgrp">
    {foreach from=$groupes item=groupe}
      {include file="groupes/_groupe.tpl" groupe=$groupe}
    {/foreach}
    </ul>
  </div>
{/foreach}

{include file="common/footer.tpl"}
