{include file="common/header.tpl"}

<div class="box">
  <header>
    <h2>Liste des structures</h2>
  </header>
  <div>
    <ul>
    {foreach $structures as $structure}
      <li><img src="{$structure.picto}" alt=""> <a href="/structures/{$structure.id}">{$structure.name|escape}</a></li>
    {/foreach}
    </ul>
  </div>
</div>

{include file="common/footer.tpl"}
