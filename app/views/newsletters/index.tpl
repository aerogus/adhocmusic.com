{include file="common/header.tpl"}

<div class="box">
  <header>
    <h2>Newsletters</h2>
  </header>
  <div>
    <ul>
      {foreach from=$newsletters item=newsletter}
      <li><a href="/newsletters/show/{$newsletter.id}.html">{$newsletter.title|escape}</a></li>
      {/foreach}
    </ul>
  </div>
</div>

{include file="common/footer.tpl"}
