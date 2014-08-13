{include file="fb/adhocmusic/tab/common/header.tpl"}

{foreach from=$liste_groupes item=groupes key=key}
  {include file="fb/adhocmusic/tab/common/boxstart.tpl" title=$key|escape}
  <ul class="listgrp">
  {foreach from=$groupes item=groupe}
    <li class="boxgrp {$groupe.class}">
    <a name="{$groupe.id}" href="/fb/adhocmusic/tab/groupe/{$groupe.id}" title="{$groupe.mini_text|escape}">
    <img src="{$groupe.mini_photo}" alt="" class="imggrp" />
    <strong>{$groupe.name|escape}</strong><br />
    <em>{$groupe.style|escape}</em><br />
    Maj: {$groupe.modified_on|date_format:"%d/%m/%y"}
    </a>
  </li>
  {/foreach}
  </ul>
  <hr class="spacer" />
  {include file="fb/adhocmusic/tab/common/boxend.tpl"}
{/foreach}

{include file="fb/adhocmusic/tab/common/footer.tpl"}
