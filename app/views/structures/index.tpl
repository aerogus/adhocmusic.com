{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Liste des structures"}
<ul>
  {foreach from=$structures item=structure}
  <li><img src="{$structure.picto}" alt=""> <a href="/structures/{$structure.id}">{$structure.name|escape}</a></li>
  {/foreach}
</ul>
{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
