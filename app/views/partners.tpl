{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Partenaires</h1>
  </header>
  <div>
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
  </div>
</div>

{include file="common/footer.tpl"}
