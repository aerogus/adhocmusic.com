{* fil d'ariane *}
{if !empty($trail) && ($trail|@count) > 1}
<div class="breadcrumb">
  <ul>
    {foreach from=$trail key=key item=item name=breadcrumb}
    <li>
    {if !empty($item.link)}
      <a {if $key === 0} class="home"{/if} href="{$item.link|escape}" title="{$item.description|escape}">
        {if $key === 0}<span class="mobile">🏠</span>{/if}
        <span>{$item.title|escape}</span>
      </a>
    {else}
    <span>{$item.title|escape}</span>
    {/if}
    </li>
    {/foreach}
  </ul>
</div>
{/if}
