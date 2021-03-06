{include file="common/header.tpl"}

  <div class="box">
    <header>
      <h1>Groupes</h1>
    </header>

    {if !count($groupes)}
    <div>
      <p>Aucun groupe référencé.</p>
    </div>
    {else}
    <div class="reset grid-7-small-4 has-gutter">
      {foreach from=$groupes item=groupe}
      <div class="grpitem">
        <a href="{$groupe->getUrl()}">
          <img src="{$groupe->getMiniPhoto()}" alt="" />
          <p>{$groupe->getName()}</p>
        </a>
      </div>
      {/foreach}
    </div>
    {/if}
  </div>

{include file="common/footer.tpl"}
