{include file="common/header.tpl"}

<div style="float: left;">
  {include file="common/boxstart.tpl" boxtitle="Newsletters" width="400px"}
  <a href="/adm/newsletter/create" class="button">Ecrire une lettre</a>
  <ul>
    {foreach from=$newsletters item=newsletter}
    <li><a href="/adm/newsletter/edit/{$newsletter.id|escape}">{$newsletter.title|escape}</a>
    {/foreach}
  </ul>
  {include file="common/boxend.tpl"}
</div>

<div style="float: right;">
  {include file="common/boxstart.tpl" boxtitle="Abonnés" width="400px"}
  nombre d'abonnés : {$nb_sub}
  {include file="common/boxend.tpl"}
</div>

{include file="common/footer.tpl"}
