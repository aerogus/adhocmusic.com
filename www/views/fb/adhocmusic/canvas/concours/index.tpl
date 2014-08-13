{include file="fb/adhocmusic/canvas/common/header.tpl"}

{include file="fb/adhocmusic/canvas/common/boxstart.tpl" boxtitle="Jeux Concours"}

<p>Bienvenue sur l'espace Jeux Concours du site AD'HOC</p>

<p>Voici les concours actuellement actifs :</p>

{if !empty($concours)}
<ul>
  {foreach from=$concours item=c}
  <li><a href="show/{$c.id|escape}">{$c.title|escape}</a> : {$c.lots|escape}</li>
  {/foreach}
</ul>
{else}
<p>Pas de concours en ligne actuellement.</p>
{/if}

{include file="fb/adhocmusic/canvas/common/boxend.tpl"}

{include file="fb/adhocmusic/canvas/common/footer.tpl"}
