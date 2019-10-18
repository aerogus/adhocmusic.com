{include file="common/header.tpl"}

  <div class="box">
    <header>
      <h3>Groupes</h3>
    </header>

    {if !count($groupes)}
    <div>
      <p>Aucun groupe référencé.</p>
    </div>
    {else}
    <div class="reset grid-6-small-3 has-gutter">
      {foreach from=$groupes item=groupe}
      <div class="item">
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
