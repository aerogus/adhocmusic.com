{include file="common/header.tpl"}

<div class="box">
  <header>
    <h2>Newsletters</h2>
  </header>
  <div>
    {if $newsletters|@count > 0}
    <ul>
      {foreach $newsletters as $newsletter}
      <li><a href="/newsletters/{$newsletter.id}">{$newsletter.title|escape}</a></li>
      {/foreach}
    </ul>
    {else}
    <p>Aucune newsletter</p>
    {/if}
  </div>
</div>

{include file="common/footer.tpl"}
