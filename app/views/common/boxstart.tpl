<div class="box"{if !empty($width)} style="width: {$width};"{/if}>
{if !empty($boxtitle)}
<div class="boxtitle">
  {if !empty($boxtitle2)}<span style="float: right">{$boxtitle2}</span>{/if}
  {if !empty($boxtitlelink)}<a href="{$boxtitlelink}" style="color: #ffffff;">{$boxtitle}</a>{else}{$boxtitle}{/if}
</div>
{else}
<div class="boxheader"{if !empty($boxbgcolor)} style="background: {$boxbgcolor};"{/if}></div>
{/if}
<div class="boxcontent"{if !empty($boxbgcolor)} style="background: {$boxbgcolor};"{/if}>
