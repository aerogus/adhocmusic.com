{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Newsletters</h1>
  </header>
  <div>
    <p>nombre d'abonnés : {$nb_sub}</p>
    <p><a href="/adm/newsletter/create" class="button">Ecrire une lettre</a></p>
    <ul>
      {foreach from=$newsletters item=newsletter}
      <li><a href="/adm/newsletter/edit/{$newsletter.id|escape}">{$newsletter.title|escape}</a>
      {/foreach}
    </ul>
  </div>
</div>

{include file="common/footer.tpl"}
