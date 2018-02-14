{include file="common/header.tpl"}

<div class="box">
  <header>
    <h2>Newsletters</h2>
  </header>
  <div>
    <ul>
      {foreach $newsletters as $newsletter}
      <li><a href="/newsletters/{$newsletter.id}">{$newsletter.title|escape}</a></li>
      {/foreach}
    </ul>
  </div>
</div>

{include file="common/footer.tpl"}
