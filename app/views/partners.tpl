{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Partenaires</h1>
  </header>
  <div>
    <ul class="partners">
    {foreach from=$partners item=partner}
      <li>
        <a href="{$partner->url}">
          <img src="/img/partners/{$partner->id}.png" alt="">
          <strong>{$partner->title}</strong><br>{$partner->description}
        </a>
      </li>
    {/foreach}
    </ul>
  </div>
</div>

{include file="common/footer.tpl"}
