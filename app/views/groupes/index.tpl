{include file="common/header.tpl"}


  <div class="box">
    <header>
      <h3>Groupes</h3>
    </header>
    <div>

{if !count($liste_groupes)}
<p>Aucun groupe référencé.</p>
{/if}

{foreach from=$liste_groupes item=groupes key=key}
  <div class="box">
    <header>
      <h2>{$key|escape}</h2>
    </header>
    <ul class="groupes">
    {foreach $groupes as $groupe}
      {include file="groupes/_groupe.tpl" groupe=$groupe}
    {/foreach}
    </ul>
  </div>
{/foreach}

</div>
</div>

{include file="common/footer.tpl"}
