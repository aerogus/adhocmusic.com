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
    <div class="reset grid-8-small-4 has-gutter">
      {foreach from=$groupes item=groupe}
      <div class="grpitem">
        <a href="{$groupe['url']}">
          <img src="{$groupe['mini_photo']}" alt="" />
          <p>{$groupe['name']}</p>
        </a>
      </div>
      {/foreach}
    </div>
    {/if}
  </div>

{include file="common/footer.tpl"}
