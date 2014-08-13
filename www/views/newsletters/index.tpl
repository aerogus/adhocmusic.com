{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Newsletters"}
<ul>
  {foreach from=$newsletters item=newsletter}
  <li><a href="/newsletters/show/{$newsletter.id}.html">{$newsletter.title|escape}</a></li>
  {/foreach}
</ul>
{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
