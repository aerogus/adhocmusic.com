{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Partenaires</h1>
  </header>
  <div>
    {if $partners|@count > 0}
    <ul class="partners">
    {foreach from=$partners item=partner}
      <li>
        <a href="{$partner->getUrl()}">
          <img src="{$partner->getIconUrl()}" alt="">
          <strong>{$partner->getTitle()}</strong><br>{$partner->getDescription()}
        </a>
      </li>
    {/foreach}
    </ul>
    {else}
    Pas de partenaires référencés
    {/if}
  </div>
</div>

{include file="common/footer.tpl"}
