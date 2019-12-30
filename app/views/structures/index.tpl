{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Liste des structures</h1>
  </header>
  <div>
    <ul>
    {foreach $structures as $structure}
      <li><img src="{$structure->getPicto()}" alt=""> <a href="{$structure->getUrl()}">{$structure->getName()|escape}</a></li>
    {/foreach}
    </ul>
  </div>
</div>

{include file="common/footer.tpl"}
