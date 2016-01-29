{include file="common/header.tpl"}

<script src="/js/jquery.flot.min.js"></script>

{include file="common/boxstart.tpl" boxtitle="Statistiques"}

{if !empty($module)}

<div class="blocinfo">
<h3>{$modules.$m}</h3>

{if !empty($module.com_top)}{$module.com_top}{/if}

<table>
  <tr>
    {foreach from=$module.cols item=col}
    <th>{$col}</th>
    {/foreach}
  </tr>
  {foreach from=$module.data item=data}
  <tr>
    {foreach from=$module.keys item=key}
    <td>{$data.$key}</td>
    {/foreach}
  </tr>
  {/foreach}
</table>

{if !empty($module.com_bottom)}{$module.com_bottom}{/if}

<p>Total: {$module.total}</p>
<p>Max: {$module.max}</p>
</div>

{else}

<ol class="admlinks">
  <li><a href="/adm/stats-top-membres">Membres ayant le + joué à AD'HOC</a></li>
  <li><a href="/adm/stats-top-groupes">Groupes ayant le + joué à AD'HOC</a></li>
{foreach from=$modules key=modId item=modTitle}
  <li><a href="/adm/stats?m={$modId}">{$modTitle}</a></li>
{/foreach}
</ol>

{/if}

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
